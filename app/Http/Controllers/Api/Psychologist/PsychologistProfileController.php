<?php

namespace App\Http\Controllers\Api\Psychologist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Appointment;

class PsychologistProfileController extends Controller
{
    public function showPsychologist()
    {
        $user = User::where('id', auth()->user()->id)->with('userPersonalData')->first();
        if ($user->profile_id == 3) 
        {
            if($user->userPersonalData->type == 'titulado') 
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'Se encontrarón los datos de perfil.',
                    'success' => true,
                    'data' => [
                        'profile_photo' => $user->profile_photo,
                        'phone' => $user->userPersonalData->phone,
                        'whatsapp' => $user->userPersonalData->whatsapp,
                        'gender' => $user->userPersonalData->gender,
                        'sex' => $user->userPersonalData->sex,
                        'address' => $user->userPersonalData->address,
                        'type' => $user->userPersonalData->type,
                        'professional_license' => $user->userPersonalData->professional_license,
                        'professional_title' => $user->userPersonalData->professional_title,
                        'specialty' => $user->userPersonalData->specialty,
                    ],
                    'errors' => null
                ], 200);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Se encontrarón los datos de perfil.',
                    'success' => true,
                    'data' => [
                        'profile_photo' => $user->profile_photo,
                        'phone' => $user->userPersonalData->phone,
                        'whatsapp' => $user->userPersonalData->whatsapp,
                        'gender' => $user->userPersonalData->gender,
                        'sex' => $user->userPersonalData->sex,
                        'address' => $user->userPersonalData->address,
                        'type' => $user->userPersonalData->type,
                    ],
                    'errors' => null
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrio un error de usuario',
                'success' => false,
                'data' => null,
                'errors' => [
                    'ID usuario' => 'No corresponde a un perfil de psycológo.'
                ]
            ], 400);
        }
    }
    public function updatePsychologist(Request $request) 
    {
        
        if(auth()->user()->profile_id == 3) 
        {
            switch ($request->method()) {
                case 'POST':
                    $user = User::where('id', auth()->user()->id)->with('userPersonalData')->first();
                    $rules = [
                        'profile_photo' => 'required|mimes:jpeg,jpg,png|max:2048',
                    ];
                    $messanges = [
                        'profile_photo.required' => 'Foto de perfil: Requerida.',
                        'profile_photo.mimes' => 'Foto de perfil: Solo puede ser de tipo: JPG, PNG ó JPEG.',
                        'profile_photo.max' => 'Foto de perfil: No debe pesar más de 2 MB.',
                    ];
                    $validator = Validator::make($request->all(), $rules, $messanges);
                    if($validator->fails())
                    {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Ocurrio un error de validación de datos.',
                            'success' => false,
                            'data' => null,
                            'errors' => $validator->errors()
                        ], 400);
                    } else {
                        $profilePhoto = $request->file('profile_photo');
                        Storage::deleteDirectory('/public/img/profiles/psychologists/' . $profilePhoto->storeAs(strtolower(auth()->user()->email)),'psychologists');
                        $user->profile_photo = 'img/profiles/pyschologists/' . $profilePhoto->storeAs(strtolower(auth()->user()->email), strtolower(str_replace(' ', '', $profilePhoto->getClientOriginalName())), 'psychologists');
                        $user->save();
                        return response()->json([
                            'status' => 200,
                            'message' => 'Foto de perfil actualizada correctamente.',
                            'success' => true,
                            'data' => null,
                            'errors' => null
                        ], 200);
                    }
                    break;
                case 'PATCH':
                    $typeInput = strtolower(str_replace(' ', '', $request->type));
                    $user = User::where('id', auth()->user()->id)->with('userPersonalData')->first();
                    $typeDB = $user->userPersonalData->type;
                    $typeProfessional = '';

                    if(($typeDB == 'titulado' && $typeInput == 'titulado') || ($typeDB == 'pasante' && $typeInput == 'titulado') || ($typeDB == 'coach' && $typeInput == 'titulado'))
                    {
                        $typeProfessional = 'titulado';
                    }
                    if(($typeDB == 'coach' && $typeInput == 'coach') ||  ($typeDB == 'pasante' && $typeInput == 'coach'))
                    {
                        $typeProfessional = 'coach';
                    }
                    if ( ($typeDB == 'pasante' && $typeInput == 'pasante') || ($typeDB == 'coach' && $typeInput == 'pasante'))
                    {
                        $typeProfessional = 'pasante';
                    }
                    if(($typeDB == 'titulado' && $typeInput == 'coach') || ($typeDB == 'titulado' && $typeInput == 'pasante'))
                    {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Ocurrio un error de tipo de estudio',
                            'success' => false,
                            'data' => null,
                            'errors' => [
                                'Tipo de petición:' => 'No puedes ser Coach o Pasante. ¡Ya cuentas con estudios de Titulado!.'
                            ]
                        ], 400);
                    }
                    switch ($typeProfessional) {
                        case 'titulado':
                            $rules = [
                                'phone' => 'required|regex:/^[0-9]+$/|min:10|max:10',
                                'whatsapp' => 'required|regex:/^[0-9]+$/|min:10|max:10',
                                'gender' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                                'sex' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:10',
                                'address' => 'required|max:255',
                                'type' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:255',
                                'professional_license' => 'required|regex:/^[a-zA-Z0-9-]+$/|min:7|max:10',
                                'professional_title' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ.\s]+$/',
                                'specialty' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ.\s]+$/'
                            ];
                            $titledMessages = [
                                'phone.required' => 'Teléfono: Requerido.',
                                'phone.regex' => 'Teléfono: Debe tener solo digitos.',
                                'phone.min' => 'Teléfono: Debe tener al menos 10 digitos.',
                                'phone.max' => 'Teléfono: Debe tener máximo 10 digitos.',
                                'whatsapp.required' => 'WhatsApp: Requerido.',
                                'whatsapp.regex' => 'WhatsApp: Debe tener solo digitos.',
                                'whatsapp.min' => 'WhatsApp: Debe tener al menos 10 digitos.',
                                'whatsapp.max' => 'Teléfono: Debe tener máximo 10 digitos.',
                                'gender.required' => 'Género: Requerido.',
                                'gender.regex' => 'Género: Debe tener solo letras.',
                                'sex.required' => 'Sexo: Requerido.',
                                'sex.regex' => 'Sexo: No admite acentos ni caracteres especiales.',
                                'sex.max' => 'Sexo: Demasido largo.',
                                'address.required' => 'Dirección: Requerida.',
                                'address.max' => 'Dirección: Demasiada larga.',
                                'type.required' => 'Tipo: Requerido.',
                                'type.regex' => 'Tipo: Debe contener solo letras.', 
                                'type.max' => 'Tipo: Debe contener máximo 255 caracteres.',
                                'professional_license.required' => 'Cédula profesional: Requerida.',
                                'professional_license.regex' => 'Cédula profesional: Solo puede contener números, guiones o letras.',
                                'professional_license.min' => 'Cédula profesional: Debe tener mínimo 7 caracteres.',
                                'professional_license.max' => 'Cédula profesional: Debe tener máximo 10 caracteres.',
                                'professional_title.required' => 'Título profesional: Requerido.',
                                'professional_title.regex' => 'Título profesional: Solo puede contener letras, espacios y puntos.',
                                'specialty.required' => 'Especialidad: Requerida.',
                                'specialty.regex' => 'Especialidad: Solo puede contener letras, espacios y puntos.', 
                            ];
                            $validatorTitled = Validator::make($request->all(), $rules, $titledMessages);
                            if($validatorTitled->fails())
                            {
                                return response()->json([
                                    'status' => 400,
                                    'message' => 'Ocurrio un error de validación de datos.',
                                    'success' => false,
                                    'data' => null,
                                    'errors' => $validatorTitled->errors()
                                ], 400);
                            }
                            $user = User::where('id', auth()->user()->id)->with('userPersonalData')->first();
                            $user->userPersonalData->phone = $request->phone;
                            $user->userPersonalData->whatsapp  = $request->whatsapp;
                            $user->userPersonalData->gender = strtolower($request->gender);
                            $user->userPersonalData->sex = strtolower($request->sex);
                            $user->userPersonalData->address = strtolower($request->address);
                            $user->userPersonalData->type = strtolower($request->type);
                            $user->userPersonalData->professional_license = $request->professional_license;
                            $user->userPersonalData->professional_title = strtolower($request->professional_title);
                            $user->userPersonalData->specialty = strtolower($request->specialty);
                            $user->userPersonalData->save();
                            return response()->json([
                                'status' => 200,
                                'message' => 'Datos actualizados exitosamente.',
                                'success' => true,
                                'data' => null,
                                'errors' => null
                            ], 200);
                            break;
                        case 'pasante' :
                        case 'coach' :
                            $rules = [
                                'phone' => 'required|regex:/^[0-9]+$/|min:10|max:10',
                                'whatsapp' => 'required|regex:/^[0-9]+$/|min:10|max:10',
                                'gender' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                                'sex' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:10',
                                'address' => 'required|max:255',
                                'type' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:255',
                            ];
                            $internsOrCoachMessages = [
                                'phone.required' => 'Teléfono: Requerido.',
                                'phone.regex' => 'Teléfono: Debe tener solo digitos.',
                                'phone.min' => 'Teléfono: Debe tener al menos 10 digitos.',
                                'phone.max' => 'Teléfono: Debe tener máximo 10 digitos.',
                                'whatsapp.required' => 'WhatsApp: Requerido.',
                                'whatsapp.regex' => 'WhatsApp: Debe tener solo digitos.',
                                'whatsapp.min' => 'WhatsApp: Debe tener al menos 10 digitos.',
                                'whatsapp.max' => 'Teléfono: Debe tener máximo 10 digitos.',
                                'gender.required' => 'Género: Requerido.',
                                'gender.regex' => 'Género: Debe tener solo letras.',
                                'sex.required' => 'Sexo: Requerido.',
                                'sex.regex' => 'Sexo: No admite acentos ni caracteres especiales.',
                                'sex.max' => 'Sexo: Demasido largo.',
                                'address.required' => 'Dirección: Requerida.',
                                'address.max' => 'Dirección: Demasiada larga.',
                                'type.required' => 'Tipo: Requerido.',
                                'type.regex' => 'Tipo: Debe contener solo letras.', 
                                'type.max' => 'Tipo: Debe contener máximo 255 caracteres.',
                            ];
                            $validatorInternsOrCoach = Validator::make($request->all(), $rules, $internsOrCoachMessages);
                            if($validatorInternsOrCoach->fails())
                            {
                                return response()->json([
                                    'status' => 400,
                                    'message' => 'Ocurrio un error de validación de datos.',
                                    'success' => false,
                                    'data' => null,
                                    'errors' => $validatorInternsOrCoach->errors()
                                ], 400);
                            }
                            $user = User::where('id', auth()->user()->id)->with('userPersonalData')->first();
                            $user->userPersonalData->phone = $request->phone;
                            $user->userPersonalData->whatsapp  = $request->whatsapp;
                            $user->userPersonalData->gender = strtolower($request->gender);
                            $user->userPersonalData->sex = strtolower($request->sex);
                            $user->userPersonalData->address = strtolower($request->address);
                            $user->userPersonalData->type = strtolower($request->type);
                            $user->userPersonalData->save();
                            return response()->json([
                                'status' => 200,
                                'message' => 'Datos actualizados exitosamente.',
                                'success' => true,
                                'data' => null,
                                'errors' => null
                            ], 200);
                            break;
                        default:
                            return response()->json([
                                'status' => 400,
                                'message' => 'Ocurrio un error de tipo de profesión',
                                'success' => false,
                                'data' => null,
                                'errors' => [
                                    'Tipo de petición:' => 'Solo puedes colocar una opción: "Titulado", "Pasante" ó "Coach.'
                                ]
                            ], 400);
                            break;
                    }
                    break;
                default:
                    return response()->json([
                        'status' => 400,
                        'message' => 'Ocurrio un error de petición',
                        'success' => false,
                        'data' => null,
                        'errors' => [
                            'Tipo de petición:' => 'No corresponde a POST ó PATCH.'
                        ]
                    ], 400);
                    break;
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrio un error de usuario',
                'success' => false,
                'data' => null,
                'errors' => [
                    'ID usuario' => 'No corresponde a un perfil de psicológo.'
                ]
            ], 400);
        }
    }
    public function deletePsychologist()
    {
        $userDeleted = User::where('id', auth()->user()->id)->first();
        $userDeleted->userLocation->delete();
        $userDeleted->userPersonalData->delete();
        $userType = (auth()->user()->profile_id == '3') ? 'patient' : 'psychologist';
        $appointments = Appointment::where($userType.'_user_id', auth()->user()->id)->get();
        $appointments->each(function ($appointment){
            $appointment->delete();
        });
        $userDeleted->delete();
    }
}
