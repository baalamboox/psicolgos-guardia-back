<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\UserPersonalData;
use App\Models\UserLog;
use App\Models\VerificationCode;
use App\Mail\VerificationCodeMail;

class RecoverAccountController extends Controller
{

    public function showViewForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function showViewVerificationCode()
    {
        return view('auth.verification-code');
    }

    public function showViewResetPassword()
    {
        return view('auth.reset-password');
    }

    public function sendVerificationCode(Request $request)
    {
        $rule = [
            'email' => 'required|email|unique:verification_codes|max:64'
        ];
        $messages = [
            'email.required' => 'Correo electrónico: Requerido.',
            'email.email' => 'Correo electrónico: Invalido.',
            'email.max' => 'Correo electrónico: Muy largo.',
            'email.unique' => 'Correo electrónico: Ya se envió código de verificación.'
        ];
        $validator = Validator::make($request->only('email'), $rule, $messages);
        if($validator->fails())
        {
            $request->session()->put('email', $request->email);
            $email = $request->old('email');
            return redirect()->route('forgot.password')->withErrors($validator)->withInput();
        }
        $user = User::where('email', strtolower($request->email))->first();
        try
        {
            if($user->profile_id == 1)
            {
                $userPersonalData = UserPersonalData::where('user_id', $user->id)->first();
                $request->session()->put('email', $request->email);
                $names = ucwords($userPersonalData->names);
                $code = mt_rand(1000, 9999);
                VerificationCode::create([
                    'email' => $request->email,
                    'code' => $code,
                    'checked' => false
                ]);
                Mail::to($request->email)->send(new VerificationCodeMail($names, $code));
                UserLog::create([
                    'user_id' => $user->id,
                    'action' => 'envío de código de verificación',
                    'details' => 'creó un código de verificación para recuperación de contraseña'
                ]);
                return redirect()->route('verification.code');
            }
            return redirect()->route('forgot.password')->withErrors(['email' => 'Correo electrónico no pertenece a ningún administrador.'])->withInput();
        } catch (\Throwable $th)
        {
            return redirect()->route('forgot.password')->withErrors(['email' => 'Correo electrónico no registrado.'])->withInput();
        }
    }

    public function checkVerificationCode(Request $request)
    {
        $rule = [
            'verification_code' => 'required'
        ];
        $messages = [
            'verification_code.required' => 'Código de verificación: Requerido.'
        ];
        $validator = Validator::make($request->only('verification_code'), $rule, $messages);
        if($validator->fails())
        {
            $verificationCode = $request->old('verification_code');
            return redirect()->route('verification.code')->withErrors($validator)->withInput();
        }
        VerificationCode::where('email', session('email'))->update([
            'checked' => true
        ]);
        return redirect()->route('reset.password');
    }
}
