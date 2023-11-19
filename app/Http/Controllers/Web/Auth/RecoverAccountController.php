<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
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
                Mail::to($request->email)->send(new VerificationCodeMail($names, $code));
                VerificationCode::create([
                    'email' => $request->email,
                    'code' => $code,
                    'checked' => false
                ]);
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
            'verification_code' => 'required|numeric'
        ];
        $messages = [
            'verification_code.required' => 'Código de verificación: Requerido.',
            'verification_code.numeric' => 'Código de verificación: Solo deben de ser números.'
        ];
        $validator = Validator::make($request->only('verification_code'), $rule, $messages);
        if($validator->fails())
        {
            $verificationCode = $request->old('verification_code');
            return redirect()->route('verification.code')->withErrors($validator)->withInput();
        }
        if($request->verification_code != VerificationCode::where('email', session('email'))->first()->code)
        {
            $verificationCode = $request->old('verification_code');
            return redirect()->route('verification.code')->withErrors(['verification_code' => 'Código de verificación: No valido.'])->withInput();
        }
        VerificationCode::where('email', session('email'))->update([
            'checked' => true
        ]);
        return redirect()->route('reset.password');
    }
    public function resetPassword(Request $request)
    {
        $rules = [
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,:?(){}<>"])[A-Za-z\d!@#$%^&*.,:?(){}<>"]{8,10}$/|confirmed'
        ];
        $messages = [
            'password.required' => 'Contraseña: Requerida.',
            'password.regex' => 'Contraseña: Debe tener al menos una letra minúscula, al menos una letra mayúscula, al menos un caracter especial, al menos un número y una longitud entre 8 y 10 caracteres.',
            'password.confirmed' => 'Contraseñas: No coinciden.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            $password = $request->old('password');
            VerificationCode::where('email', session('email'))->update([
                'checked' => true
            ]);
            return redirect()->route('reset.password')->withErrors($validator)->withInput();
        }
        $user = User::where('email', session('email'))->first();
        $user->password = Hash::make($request->password);
        $user->save();
        UserLog::create([
            'user_id' => $user->id,
            'action' => 'actualización de contraseña',
            'details' => 'actualizó contraseña correctamente'
        ]);
        VerificationCode::where('email', session('email'))->delete();
        $request->session()->invalidate();
        return redirect()->route('sign.in')->with('success', true);
    }
}
