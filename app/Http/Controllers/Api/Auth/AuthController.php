<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserPersonalData;
use App\Models\UserLog;
use App\Events\Admin\SendNotifications;

class AuthController extends Controller
{

    public function signUp(Request $request)
    {
        switch($request->profile)
        {
            case '2':
                $patientRules = [
                    'email' => 'required|email|unique:users|max:64',
                    'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,:?(){}<>"])[A-Za-z\d!@#$%^&*.,:?(){}<>"]{8,10}$/',
                    'profile_photo' => 'required|mimes:jpeg,jpg,png|max:2048',
                    'names' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:32',
                    'first_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:16',
                    'second_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:16',
                    'curp' => 'required|alpha_num:ascii|min:18|max:18'
                ];
                $patientMessages = [
                    'email.required' => 'Correo electrónico: Requerido.',
                    'email.unique' => 'Correo electrónico: Ya registrado.',
                    'email.email' => 'Correo electrónico: Inválido.',
                    'email.max' => 'Correo electrónico: Muy largo.',
                    'password.required' => 'Contraseña: Requerida.',
                    'password.regex' => 'Contraseña: Debe tener al menos una letra minúscula, al menos una letra mayúscula, al menos un caracter especial, al menos un número y una longitud entre 8 y 10 caracteres.',
                    'profile_photo.required' => 'Foto de perfil: Requerida.',
                    'profile_photo.mimes' => 'Foto de perfil: Solo puede ser de tipo: JPG, PNG ó JPEG.',
                    'profile_photo.max' => 'Foto de perfil: No debe pesar más de 2 MB.',
                    'names.required' => 'Nombre(s): Requerido(s).',
                    'names.regex' => 'Nombre(s): Debe contener solo letras.',
                    'names.max' => 'Nombre(s): Demasiado largo.',
                    'first_surname.required' => 'Apellido paterno: Requerido.',
                    'first_surname.regex' => 'Apellido paterno: Debe contener solo letras.',
                    'first_surname.max' => 'Apellido paterno: Demasiado largo.',
                    'second_surname.required' => 'Apellido materno: Requerido.',
                    'second_surname.regex' => 'Apellido materno: Debe contener solo letras.',
                    'second_surname.max' => 'Apellido materno: Demasiado largo.',
                    'curp.required' => 'CURP: Requerido.',
                    'curp.alpha_num' => 'CURP: Debe contener solo caracteres alfanuméricos.',
                    'curp.min' => 'CURP: Demasiado corto.',
                    'curp.max' => 'CURP: Demasiado largo'
                ];
                $patientValidator = Validator::make($request->all(), $patientRules, $patientMessages);
                if($patientValidator->fails())
                {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Error en la validación de datos.',
                        'success' => false,
                        'data' => null,
                        'errors' => $patientValidator->errors()
                    ], 400);
                }
                if(!$request->hasFile('profile_photo'))
                {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Error al subir foto de perfil.',
                        'success' => false,
                        'data' => null,
                        'errors' => [
                            'profile_photo' => ['Foto de perfil: No existe.']
                        ]
                    ], 400);
                }
                $profile_photo = $request->file('profile_photo');
                $profile = Profile::find($request->profile);
                $user = new User([
                    'email' => strtolower($request->email),
                    'password' => $request->password,
                    'profile_photo' => 'img/profiles/patients/' . $profile_photo->storeAs(strtolower($request->email), strtolower(str_replace(' ', '', $profile_photo->getClientOriginalName())), 'patients'),
                    'state' => 'activo'
                ]);
                $profile->users()->save($user);
                $userPersonalData = new UserPersonalData([
                    'names' => strtolower($request->names),
                    'first_surname' => strtolower($request->first_surname),
                    'second_surname' => strtolower($request->second_surname),
                    'curp' => strtolower($request->curp)
                ]);
                $user->userPersonalData()->save($userPersonalData);
                UserLog::create([
                    'user_id' => $user->id,
                    'action' => 'creación de usuario',
                    'details' => 'creó un usuario con el perfil de paciente'
                ]);
                broadcast(new SendNotifications('Se ha registrado un nuevo paciente.'));
                return response()->json([
                    'status' => 200,
                    'message' => 'Se creó paciente correctamente.',
                    'success' => true,
                    'data' => $user,
                    'errors' => null
                ], 200);
                break;
            case '3':
                $psychologistRules = [
                    'email' => 'required|email|unique:users|max:64',
                    'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,:?(){}<>"])[A-Za-z\d!@#$%^&*.,:?(){}<>"]{8,10}$/',
                    'profile_photo' => 'required|mimes:jpeg,jpg,png|max:2048',
                    'names' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:32',
                    'first_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:16',
                    'second_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:16',
                    'phone' => 'required|regex:/^[0-9]+$/|min:10|max:10',
                    'whatsapp' => 'required|regex:/^[0-9]+$/|min:10|max:10',
                    'curp' => 'required|alpha_num:ascii|min:18|max:18',
                    'type' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:255',
                    'professional_license' => 'regex:/^[a-zA-Z0-9-]+$/|min:7|max:10',
                    'title' => 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ.\s]+$/'
                ];
                $psychologistMessages = [
                    'email.required' => 'Correo electrónico: Requerido.',
                    'email.unique' => 'Correo electrónico: Ya registrado.',
                    'email.email' => 'Correo electrónico: Inválido.',
                    'email.max' => 'Correo electrónico: Muy largo.',
                    'password.required' => 'Contraseña: Requerida.',
                    'password.regex' => 'Contraseña: Debe tener al menos una letra minúscula, al menos una letra mayúscula, al menos un caracter especial, al menos un número y una longitud entre 8 y 10 caracteres.',
                    'profile_photo.required' => 'Foto de perfil: Requerida.',
                    'profile_photo.mimes' => 'Foto de perfil: Solo puede ser de tipo: JPG, PNG ó JPEG.',
                    'profile_photo.max' => 'Foto de perfil: No debe pesar más de 2 MB.',
                    'names.required' => 'Nombre(s): Requerido(s).',
                    'names.regex' => 'Nombre(s): Debe contener solo letras.',
                    'names.max' => 'Nombre(s): Demasiado largo.',
                    'first_surname.required' => 'Apellido paterno: Requerido.',
                    'first_surname.regex' => 'Apellido paterno: Debe contener solo letras.',
                    'first_surname.max' => 'Apellido paterno: Demasiado largo.',
                    'second_surname.required' => 'Apellido materno: Requerido.',
                    'second_surname.regex' => 'Apellido materno: Debe contener solo letras.',
                    'second_surname.max' => 'Apellido materno: Demasiado largo.',
                    'phone.required' => 'Teléfono: Requerido.',
                    'phone.regex' => 'Teléfono: Solo debe tener números.',
                    'phone.min' => 'Teléfono: Debe tener al menos 10 digitos.',
                    'phone.max' => 'Teléfono: Debe tener máximo 10 digitos.',
                    'whatsapp.required' => 'WhatsApp: Requerido.',
                    'whatsapp.regex' => 'WhatsApp: Solo debe tener números.',
                    'whatsapp.min' => 'WhatsApp: Debe tener al menos 10 digitos.',
                    'whatsapp.max' => 'WhatsApp: Debe tener máximo 10 digitos.',
                    'curp.required' => 'CURP: requerido.',
                    'curp.alpha_num' => 'CURP: Debe contener solo caracteres alfanuméricos.',
                    'curp.min' => 'CURP: Demasiado corto.',
                    'curp.max' => 'CURP: Demasiado largo',
                    'type.required' => 'Tipo: Requerido.',
                    'type.regex' => 'Tipo: Debe contener solo letras.',
                    'type.max' => 'Tipo: Debe contener máximo 255 caracteres.',
                    'professional_license.regex' => 'Cédula profesional: Solo puede contener números, guiones o letras.',
                    'professional_license.min' => 'Cédula profesional: Debe tener mínimo 7 caracteres.',
                    'professional_license.max' => 'Cédula profesional: Debe tener máximo 10 caracteres.',
                    'title.regex' => 'Título: Solo puede contener letras, espacios y puntos.'
                ];
                $psychologistValidator = Validator::make($request->all(), $psychologistRules, $psychologistMessages);
                if($psychologistValidator->fails())
                {
                    return response()->json([
                        'status'=> 400,
                        'message'=> 'Error de datos del psicólogo a crear.',
                        'success'=>false,
                        'data' => null,
                        'errors' => $psychologistValidator->errors()
                    ], 400);
                }
                if(!$request->hasFile('profile_photo'))
                {
                    return response()->json([
                        'status'=> 400,
                        'message'=> 'Error al subir foto de perfil.',
                        'success'=>false,
                        'data' => null,
                        'errors' => [
                            'profile_photo' => ['Foto de perfil: No existe.']
                        ]
                    ], 400);
                }
                $profile_photo = $request->file('profile_photo');
                $profile = Profile::find($request->profile);
                $user = new User([
                    'email' => strtolower($request->email),
                    'password' => $request->password,
                    'profile_photo' => 'img/profiles/psychologists/' . $profile_photo->storeAs(strtolower($request->email), strtolower(str_replace(' ', '', $profile_photo->getClientOriginalName())), 'psychologists'),
                    'state' => 'activo'
                ]);
                $profile->users()->save($user);
                $userPersonalData = new UserPersonalData([
                    'names' => strtolower($request->names),
                    'first_surname' => strtolower($request->first_surname),
                    'second_surname' => strtolower($request->second_surname),
                    'phone' => $request->phone,
                    'whatsapp' => $request->whatsapp,
                    'curp' => strtolower($request->curp),
                    'type' => strtolower($request->type),
                    'professional_title' => strtolower($request->professional_title),
                    'professional_license' => strtolower($request->professional_license)
                ]);
                $user->userPersonalData()->save($userPersonalData);
                UserLog::create([
                    'user_id' => $user->id,
                    'action' => 'creación de usuario',
                    'details' => 'creó un usuario con el perfil de psicólogo'
                ]);
                broadcast(new SendNotifications('Se ha registrado un nuevo psicólogo.'));
                return response()->json([
                    'status' => 200,
                    'message' => 'Se creó psicólogo correctamente.',
                    'success' => true,
                    'data' => $user,
                    'errors' => null
                ], 200);
                break;
            default:
                return response()->json([
                    'status' => 400,
                    'message' => 'Error de perfil.',
                    'success' => false,
                    'data' => null,
                    'errors' => [
                        'profile' => ['Perfil: Debe tener un valor entero entre 2=paciente y 3=psicólogo.']
                    ]
                ], 400);
                break;
        }
    }

    public function signIn(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:64',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,:?(){}<>"])[A-Za-z\d!@#$%^&*.,:?(){}<>"]{8,10}$/',
        ];
        $messages = [
            'email.required' => 'Correo electrónico: Requerido.',
            'email.email' => 'Correo electrónico: Inválido.',
            'email.max' => 'Correo electrónico: Demasiado largo.',
            'password.required' => 'Contraseña: Requerida.',
            'password.regex' => 'Contraseña: Debe tener al menos una letra minúscula, al menos una letra mayúscula, al menos un caracter especial, al menos un número y una longitud entre 8 y 10 caracteres.'
        ];
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, $rules, $messages);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Error de datos para credenciales de autenticación.',
                'success' => false,
                'data' => null,
                'errors' => $validator->errors() 
            ], 400);
        }
        $user = User::where('email', strtolower($request->email))->first();
        try
        {
            if($user->profile_id == 1)
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'Usuario no permitido.',
                    'success' => false,
                    'data' => null,
                    'errors' => [
                        'email' => ['Correo electrónico: Usado por un administrador.']
                    ]
                ], 400);
            }
        } catch (\Throwable $th)
        {
            return response()->json([
                'status' => 400,
                'message' => 'No existe usuario.',
                'success' => false,
                'data' => null,
                'errors' => [
                    'email' => ['Correo electrónico: No registrado.']
                ]
            ], 400);
        }
        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'status' => 400,
                'message' => 'Error de autenticación de usuario, credenciales incorrectas.',
                'success' => false,
                'data' => null,
                'errors' => [
                    'email or password' => ['Correo electrónico: Erróneo ó Contraseña: Errónea.']
                ]
            ], 400);
        }
        $user = User::where('email', strtolower($request->email))->first();
        $token = $user->createToken('token')->plainTextToken;
        UserLog::create([
            'user_id' => $user->id,
            'action' => 'inicio de sesión',
            'details' => 'accedió correctamente a su cuenta'
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Usuario autenticado correctamente.',
            'success' => true,
            'data' => [
                'user_id' => $user->id,
                'token'=> $token
            ],
            'errors' => null
        ], 200);
    }

    public function signOut()
    {
        auth()->user()->tokens()->delete();
        UserLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'cierre de sesión',
            'details' => 'salió correctamente de su cuenta'
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Sesión cerrada correctamente.',
            'success' => true,
            'data' => null,
            'errors' => null
        ], 200);
    }

    public function verifyUser(Request $request)
    {
        $rule = [
            'email' => 'required|email|max:64'
        ];
        $messages = [
            'email.required' => 'Correo electrónico: Requerido.',
            'email.email' => 'Correo electrónico: Inválido.',
            'email.max' => 'Correo electrónico: Demasiado largo.'
        ];
        $validator = Validator::make($request->only('email'), $rule, $messages);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Error de correo electrónico como parámetro.',
                'success' => false,
                'data' =>  null,
                'errors' => $validator->errors()
            ], 400);
        }
        $user = User::where('email', strtolower($request->query('email')))->first();
        try
        {
            if($user->profile_id == 1)
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'Usuario no permitido.',
                    'success' => false,
                    'data' => null,
                    'errors' => [
                        'email' => ['Correo electrónico: Usado por un administrador.']
                    ]
                ], 400);
            }
            if($user)
            {
                $userPersonalData = UserPersonalData::find($user->id);
                return response()->json([
                    'status' => 200,
                    'message' => 'Usuario existente.',
                    'success' => true,
                    'data' => [
                        'email' => $user->email,
                        'profile_photo' => env('APP_URL') . '/' . $user->profile_photo,
                        'names' => ucwords($userPersonalData->names),
                        'first_surname' => ucwords($userPersonalData->first_surname)
                    ],
                    'errors' => null
                ], 200);
            }
        } catch (\Throwable $th)
        {
            return response()->json([
                'status' => 400,
                'message' => 'No existe usuario.',
                'success' => false,
                'data' => null,
                'errors' => [
                    'email' => ['Correo electrónico: No registrado.']
                ]
            ], 400);
        }
    }
}
