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
        if($request->isMethod('put'))
        {
            try 
            {
                $codeIsChecked = VerificationCode::where('email', strtolower($request->email))->first()->checked;
                if($codeIsChecked == '0')
                {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Error de código de verificación.',
                        'success' => false,
                        'data' => null,
                        'errors' => [
                            'verification_code' => ['Código de verificación: No verificado aún.']
                        ]
                    ], 400);
                }
            } catch(\Throwable $th) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Error de código de verificación.',
                    'success' => false,
                    'data' => null,
                    'errors' => [
                        'verification_code' => ['Código de verificación: No se ha encontrado ningún código.']
                    ]
                ], 400);
            }
            VerificationCode::where('email', strtolower($request->email))->update([
                'checked' => false
            ]);
            return $next($request);
        }
        if(is_null(session('email')))
        {
            return redirect()->route('forgot.password');
        }
        $codeIsChecked = VerificationCode::where('email', session('email'))->first()->checked;
        if($codeIsChecked == '0')
        {
            return redirect()->route('verification.code');
        }
        VerificationCode::where('email', session('email'))->update([
            'checked' => false
        ]);
        return $next($request);
    }
}
