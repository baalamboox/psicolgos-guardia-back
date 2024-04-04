<?php

namespace App\Http\Controllers\Api\Auth;

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
            return response()->json([
                'status' => 400,
                'message' => 'Error de correo electrónico.',
                'success' => false,
                'data' => null,
                'errors' => $validator->errors()
            ], 400);
        }
        $user = User::where('email', strtolower($request->email))->first();
        if($user == null)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Error de correo electrónico.',
                'success' => false,
                'data' => null,
                'errors' => [
                    'email' => ['Correo electrónico: No esta registrado.']
                ]
            ], 400);
        }
        if($user->profile_id == 1)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Error de correo electrónico.',
                'success' => false,
                'data' => null,
                'errors' => [
                    'email' => ['Correo electrónico: No pertenece a ningún paciente ó psicólogo.']
                ]
            ], 400);
        }
        $userPersonalData = UserPersonalData::where('user_id', $user->id)->first();
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
        return response()->json([
            'status' => 200,
            'message' => 'Se envió correctamente código de verificación.',
            'success' => true,
            'data' => null,
            'errors' => null
        ], 200);
    }

    public function checkVerificationCode(Request $request)
    {
        $rule = [
            'email' => 'required|email|max:64',
            'verification_code' => 'required|numeric'
        ];
        $messages = [
            'email.required' => 'Correo electrónico: Requerido.',
            'email.email' => 'Correo electrónico: Invalido.',
            'email.max' => 'Correo electrónico: Muy largo.',
            'verification_code.required' => 'Código de verificación: Requerido.',
            'verification_code.numeric' => 'Código de verificación: Solo deben de ser números.'
        ];
        $validator = Validator::make($request->only('email', 'verification_code'), $rule, $messages);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Error de código de verificación.',
                'success' => false,
                'data' => null,
                'errors' => $validator->errors()
            ], 400);
        }
        try 
        {
            if($request->verification_code != VerificationCode::where('email', strtolower($request->email))->first()->code)
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'Error de código de verificación.',
                    'success' => false,
                    'data' => null,
                    'errors' => [
                        'verification_code' => ['Código de verificación: No valido.']
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
        VerificationCode::where('email', $request->email)->update([
            'checked' => true
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Se verificó correctamente el código de verificación.',
            'success' => true,
            'data' => null,
            'errors' => null
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:64',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,:?(){}<>"])[A-Za-z\d!@#$%^&*.,:?(){}<>"]{8,10}$/|confirmed'
        ];
        $messages = [
            'email.required' => 'Correo electrónico: Requerido.',
            'email.email' => 'Correo electrónico: Invalido.',
            'email.max' => 'Correo electrónico: Muy largo.',
            'password.required' => 'Contraseña: Requerida.',
            'password.regex' => 'Contraseña: Debe tener al menos una letra minúscula, al menos una letra mayúscula, al menos un caracter especial, al menos un número y una longitud entre 8 y 10 caracteres.',
            'password.confirmed' => 'Contraseñas: No coinciden.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Error de contraseña.',
                'success' => false,
                'data' => null,
                'errors' => $validator->errors()
            ], 400);
        }
        $user = User::where('email', strtolower($request->email))->first();
        $user->password = Hash::make($request->password);
        $user->save();
        UserLog::create([
            'user_id' => $user->id,
            'action' => 'actualización de contraseña',
            'details' => 'actualizó contraseña correctamente'
        ]);
        VerificationCode::where('email', strtolower($request->email))->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Se actualizó contraseña correctamente.',
            'success' => true,
            'data' => null,
            'errors' => null
        ], 200);  
    }
}
