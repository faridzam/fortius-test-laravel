<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FeaturePermission
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $cekModule1 = 0, $cekModule2 = 0, $cekModule3 = 0, $cekModule4 = 0): Response
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            $isAuthorized = Permission::where('role', $role)
            ->whereIn('module', [(int)$cekModule1, (int)$cekModule2, (int)$cekModule3, (int)$cekModule4])
            ->first();

            if (!$isAuthorized) {
                return $this->unauthorizedResponse("Unauthorized feature!");
            }
        } elseif ($request->route() !== 'api/login') {
            return $this->unauthorizedResponse("Unauthorized feature!");
        }
        return $next($request);
    }
}
