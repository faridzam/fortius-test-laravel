<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponseTrait;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Http\Controllers\AccessTokenController;

use Psr\Http\Message\ServerRequestInterface;

class AuthCookie
{

    use ApiResponseTrait;

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
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // if(!Auth::check()) {

        //     if ($request->hasCookie('refresh')) {

        //         $request = Request::create('oauth/token', 'POST', [
        //             'grant_type' => 'refresh_token',
        //             'client_id' => '3',
        //             'client_secret' => 'iABV2UywnrVIJ9UdsB1YJjcnLkoDHdRiiTD3EIuQ',
        //             'refresh_token' => $request->cookie('refresh'),
        //             'scope' => '',
        //         ]);

        //         $result = app()->handle($request);
        //         $data = json_decode($result->getContent(), true);

        //         return $next($request)
        //         ->withCookie(cookie('access', $data['access_token'], 60, null, null, null, false))
        //         ->withCookie(cookie('refresh', $data['refresh_token'], 900, null, null, null, false));
        //     }

        // }

        return $next($request);

    }
}
