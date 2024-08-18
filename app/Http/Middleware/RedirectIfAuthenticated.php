<?php

namespace App\Http\Middleware;

use App\Enums\UserTypeEnum;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(Auth::check() && Auth::user()->user_type == UserTypeEnum::CUSTOMER->value){
                    return redirect(RouteServiceProvider::HOME);
                }
                if(Auth::check() && Auth::user()->user_type == UserTypeEnum::VENDOR->value){
                    return redirect('/vendor/dashboard');
                }
                if(Auth::check() && Auth::user()->user_type == UserTypeEnum::ADMIN->value){
                    return redirect('/admin/dashboard');
                }
            }
        }

        return $next($request);
    }
}
