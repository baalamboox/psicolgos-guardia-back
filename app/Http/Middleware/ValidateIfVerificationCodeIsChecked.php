<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VerificationCode;

class ValidateIfVerificationCodeIsChecked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(is_null(session('email')))
        {
            return redirect()->route('forgot.password');
        }
        $codeIsChecked = VerificationCode::where('email', session('email'))->first()->checked;
        if($codeIsChecked == '0')
        {
            return redirect()->route('verification.code');
        }
        return $next($request);
    }
}
