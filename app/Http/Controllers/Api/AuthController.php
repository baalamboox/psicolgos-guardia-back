<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Profile;
use App\Models\UserPersonalData;

class AuthController extends Controller
{

    public function signup(Request $request): JsonResponse 
    {
        switch($request->profile)
        {
            case '2':
                $patientRules = [
                    'email'=>'required|unique:users|email|max:128',
                    'password'=>'required|string|max:8',
                    'profile_photo'=>'required',
                    'names'=>'required|string|max:32',
                    'first_surname'=>'required|string|max:16',
                    'second_surname'=>'required|string|max:16',
                    'curp'=>'required|string|max:18'
                ];
                $patientValidator = Validator::make($request->all(), $patientRules);
                if($patientValidator->fails())
                {
                    return response()->json([
                        'status'=> 400,
                        'message'=> 'Error en los datos del paciente para su creación.',
                        'success'=>false
                    ], 400);
                }
                $profile = Profile::find($request->profile);
                $user = new User([
                    'email'=>$request->email,
                    'password'=>$request->password,
                    'profile_photo'=>$request->profile_photo,
                    'state'=>1
                ]);
                $profile->users()->save($user);
                $userPersonalData = new UserPersonalData([
                    'names'=>$request->names,
                    'first_surname'=>$request->first_surname,
                    'second_surname'=>$request->second_surname,
                    'curp'=>$request->curp
                ]);
                $user->userPersonalData()->save($userPersonalData);
                $token = $user->createToken('token')->plainTextToken;
                return response()->json([
                    'status'=> 200,
                    'message'=> 'Se creo paciente correctamente.',
                    'success'=>true,
                    'data'=>[
                        'user_created'=>$profile,
                        'token'=>$token
                    ]
                ], 200);
                break;
            case '3':
                $psychologistRules = [
                    'email'=>'required|unique:users|email|max:128',
                    'password'=>'required|string|max:8',
                    'profile_photo'=>'required',
                    'names'=>'required|string|max:32',
                    'first_surname'=>'required|string|max:16',
                    'second_surname'=>'required|string|max:16',
                    'curp'=>'required|string|max:18',
                    'type'=>'required|string|max:255',
                    'professional_license'=>'required|string|max:10',
                    'title'=>'required'
                ];
                $psychologistValidator = Validator::make($request->all(), $psychologistRules);
                if($psychologistValidator->fails())
                {
                    return response()->json([
                        'status'=> 400,
                        'message'=> 'Error en los datos del psicólogo para su creación.',
                        'success'=>false
                    ], 400);
                }
                $profile = Profile::find($request->profile);
                $user = new User([
                    'email'=>$request->email,
                    'password'=>$request->password,
                    'profile_photo'=>$request->profile_photo,
                    'state'=>1
                ]);
                $profile->users()->save($user);
                $userPersonalData = new UserPersonalData([
                    'names'=>$request->names,
                    'first_surname'=>$request->first_surname,
                    'second_surname'=>$request->second_surname,
                    'curp'=>$request->curp,
                    'type'=>$request->type,
                    'professional_license'=>$request->professional_license,
                    'title'=>$request->title
                ]);
                $user->userPersonalData()->save($userPersonalData);
                $token = $user->createToken('token')->plainTextToken;
                return response()->json([
                    'status'=> 200,
                    'message'=> 'Se creo psicólogo correctamente.',
                    'success'=>true,
                    'data'=>[
                        'user_created'=>$profile,
                        'token'=>$token
                    ]
                ], 200);
                break;
            default:
                return response()->json([
                    'status'=>400,
                    'message'=>'Se requiere un perfil: ["2" => paciente, "3" => psicólogo] para crear usuario.',
                    'success'=>false
                ], 400);
                break;
        }
    }
    public function signin(Request $request): JsonResponse
    {
        if(!Auth::attempt($request->only('email', 'password')))
        {
            return response()->json([
                'status'=>400,
                'message'=>'Fallo al autenticar al usuario, credenciales incorrectas.',
                'success'=>false
            ], 400);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'status'=>200,
            'message'=>'Usuario autenticado correctamente.',
            'success'=>true,
            'data'=> [
                'token'=>$token
            ]
        ], 200);
    }
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Sesión cerrada correctamente.',
            'success'=>true,
        ],200);
    }
}
