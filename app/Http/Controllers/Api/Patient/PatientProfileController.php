<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Appointment;

class PatientProfileController extends Controller
{

    public function showPatient()
    {
        $user = User::where('id', auth()->user()->id)->with('userPersonalData')->first();
        if($user->profile_id == 2) 
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
                ],
                'errors' => null
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrio un error de usuario',
                'success' => false,
                'data' => null,
                'errors' => [
                    'ID usuario' => 'No corresponde a un perfil de paciente.'
                ]
            ], 400);
        }
    }

    public function updatePatient(Request $request)
    {
        if(auth()->user()->profile_id == 2)
        {
            switch($request->method()) 
            {
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
                        Storage::deleteDirectory('/public/img/profiles/patients/' . $profilePhoto->storeAs(strtolower(auth()->user()->email)),'patients');
                        $user->profile_photo = 'img/profiles/patients/' . $profilePhoto->storeAs(strtolower(auth()->user()->email), strtolower(str_replace(' ', '', $profilePhoto->getClientOriginalName())), 'patients');
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
                    $rules = [
                        'phone' => 'required|regex:/^[0-9]+$/|min:10|max:10',
                        'whatsapp' => 'required|regex:/^[0-9]+$/|min:10|max:10',
                        'gender' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                        'sex' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:10',
                        'address' => 'required|max:255',
                    ];
                    $messanges = [
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
                        $user = User::where('id', auth()->user()->id)->with('userPersonalData')->first();
                        $user->userPersonalData->phone = $request->phone;
                        $user->userPersonalData->whatsapp  = $request->whatsapp;
                        $user->userPersonalData->gender = strtolower($request->gender);
                        $user->userPersonalData->sex = strtolower($request->sex);
                        $user->userPersonalData->address = strtolower($request->address);
                        $user->userPersonalData->save();
                        return response()->json([
                            'status' => 200,
                            'message' => 'Datos actualizados exitosamente.',
                            'success' => true,
                            'data' => null,
                            'errors' => null
                        ], 200);
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
                    'ID usuario' => 'No corresponde a un perfil de paciente.'
                ]
            ], 400);
        }
    }

    public function deletePatient()
    {   
        $userDeleted = User::where('id', auth()->user()->id)->first();
        if($userDeleted->emergencyContact != null)
        {
            $userDeleted->emergencyContact->each(function ($contact){
                $contact->delete();
            });
        }
        if($userDeleted->medicalHistory != null)
        {
            $userDeleted->medicalHistory->delete();
        }
        if($userDeleted->userLocation != null)
        {
            $userDeleted->userLocation->delete();
        }
        if($userDeleted->userPersonalData != null)
        {
            $userDeleted->userPersonalData->delete();
        }
        $userType = (auth()->user()->profile_id == '2') ? 'patient' : 'psychologist';
        $appointments = Appointment::where($userType.'_user_id', auth()->user()->id)->get();
        if($appointments != null)
        {
            $appointments->each(function ($appointment){
                $appointment->delete();
            });
        }
        $userDeleted->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Usuario eliminado correctamente.',
            'success' => true,
            'data' => null,
            'errors' => null
        ], 200);
    }
}
