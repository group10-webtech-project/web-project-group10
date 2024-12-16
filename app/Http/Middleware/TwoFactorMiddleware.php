<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if(auth()->check() && $user->two_factor_auth_code)
        {
            $expiresAt = Carbon::parse($user->two_factor_auth_expires_at);

            if($expiresAt->lt(now()))
            {
                $user->reseTwoFactorAuthCode();
                auth()->logout();

                return redirect()->route('login')->withMessage('The two factor authentication code expired, log in again.');               
            }

            if(!$request->is('verify*'))
            {
                return redirect()->route('verify.index');
            }
        }
        return $next($request);
    }
}
