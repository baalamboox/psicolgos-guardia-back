<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserLog;

class AuthController extends Controller
{
    
    public function showViewSignIn()
    {
        return view('auth.sign-in');
    }

    public function signIn(Request $request)
    {
        $email = $request->old('email');
        $password = $request->old('password');
        $rules = [
            'email' => 'required|email|max:64',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,:?(){}<>"])[A-Za-z\d!@#$%^&*.,:?(){}<>"]{8,10}$/'
        ];
        $messages = [
            'email.required' => 'Correo electrónico: Requerido.',
            'email.email' => 'Correo electrónico: Inválido.',
            'email.max' => 'Correo electrónico: Muy largo.',
            'password.required' => 'Contraseña: Requerida.',
            'password.regex' => 'Contraseña: Debe tener al menos una letra minúscula, al menos una letra mayúscula, al menos un caracter especial, al menos un número y una longitud entre 8 y 10 caracteres.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect()->route('sign.in')->withErrors($validator)->withInput();
        }
        try
        {
            $profile = User::where('email', strtolower($request->email))->first()->profile_id;
            if($profile != 1)
            {
                return redirect()->route('sign.in')->withErrors(['email' => 'Correo electrónico: No pertenece a ningún administrador.'])->withInput();
            }
            if(Auth::attempt(['email' => strtolower($request->email), 'password' => $request->password]))
            {
                $request->session()->regenerate();
                UserLog::create([
                    'user_id' => $request->user()->id,
                    'action' => 'inicio de sesión',
                    'details' => 'inició sesión de forma correcta'
                ]);
                return redirect()->route('home');
            }
            return redirect()->route('sign.in')->withErrors(['password' => 'Contraseña: Incorrecta.'])->withInput();
        } catch (\Throwable $th)
        {
            return redirect()->route('sign.in')->withErrors(['email' => 'Correo electrónico: No registrado.'])->withInput();
        }
    }

    public function signOut(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        UserLog::create([
            'user_id' => $request->user()->id,
            'action' => 'sesión cerrada',
            'details' => 'cerró sesión de forma correcta'
        ]);
        Auth::logout();
        return redirect()->route('sign.in');
    }
}
