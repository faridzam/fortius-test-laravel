<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class AuthController extends Controller
{

    protected $accessTokenController;

    /**
     * AuthController constructor.
     * @param AccessTokenController $accessTokenController
     */
    public function __construct(AccessTokenController $accessTokenController)
    {
        $this->accessTokenController = $accessTokenController;
    }

    public function issueToken(ServerRequestInterface $request)
    {
        return $this->accessTokenController->issueToken($request);
    }

    /**
     * Register
     *
     * @bodyParam role number required
     * The role of the user. Example: 1
     *
     * @bodyParam name string required
     * The name of the user. Example: "Ahmad Farid Imam Zamani"
     *
     * @bodyParam email string required
     * The email of the user. Example: "engineer@mail.com"
     *
     * @bodyParam password string required
     * The password of the user. Example: "password"
     *
     * @bodyParam confirm_password string required
     * The password confirmation of the role. Example: "password"
     *
     * @authenticated
     * @response {
     *      "status": "success",
     *      "success": true,
     *      "message": "Register success!",
     *      "data": null
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Register(Request $request): JsonResponse{
        try {
            $validator = $this->getValidationFactory()->make($request->all(), [
                'role' => 'required|integer|min:1|exists:App\Models\Role,id',
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|max:32',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return $this->validateErrorResponse($validator->errors(), 400);
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            if ($user) {
                return $this->successResponse(null, 'Register success!', 200);
            } else {
                return $this->errorResponse('User not registered', 500);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse('Register failed', 500);
        }
    }

    /**
     * Login
     *
     * @bodyParam username string required
     * The email of the user. Example: "engineer@mail.com"
     *
     * @bodyParam password string required
     * The name of the role. Example: "password"
     *
     * @authenticated
     * @response {
     *      "status": "success",
     *      "success": true,
     *      "message": "Login success!",
     *      "data": null
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Login(ServerRequestInterface $request): JsonResponse{
        try {
            $validator = $this->getValidationFactory()->make($request->getParsedBody(), [
                'username' => 'required|email',
                'password' => 'required|string|min:8|max:32',
            ]);

            if ($validator->fails()) {
                return $this->validateErrorResponse($validator->errors(), 401);
            }

            if (Auth::attempt(['email' => $request->getParsedBody()['username'], 'password' => $request->getParsedBody()['password']])) {
                $email = $request->getParsedBody()['username'];

                //get user
                $user = User::where('email', '=', $email)->firstOrFail();

                $tokenRequest = $request->withParsedBody([
                    'username' => $request->getParsedBody()['username'],
                    'password' => $request->getParsedBody()['password'],
                    'grant_type' => 'password',
                    'client_id' => '3',
                    'client_secret' => 'iABV2UywnrVIJ9UdsB1YJjcnLkoDHdRiiTD3EIuQ',
                    'scope' => '',
                ]);

                //issuetoken
                $tokenResponse = $this->issueToken($tokenRequest);

                //convert response to json string
                // $content = $tokenResponse->getBody()->__toString();

                //convert json to array
                $data = json_decode((string) $tokenResponse->content(), true);

                //add access token to user
                $user = collect($user);
                $user->put('access_token', $data['access_token']);
                $user->put('expires_in', $data['expires_in']);
                $user->put('refresh_token', $data['refresh_token']);

                return $this->successResponse(null, 'Login success!', 200)
                ->withCookie(cookie('access', $data['access_token'], 1, null, null, null, false))
                ->withCookie(cookie('refresh', $data['refresh_token'], 43800, null, null, null, false));
            } else {
                return $this->errorResponse('User not found', 404);
            }
        } catch (\Throwable $th) {

            return $this->errorResponse($th, 500);
        }
    }

}
