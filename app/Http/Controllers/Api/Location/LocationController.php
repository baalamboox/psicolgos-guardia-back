<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserLocation;

class LocationController extends Controller
{

    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'unique:user_locations',
            'latitude' => 'required|decimal:15,16',
            'length' => 'required|decimal:15,16',
            'zone' => 'required|regex:/^[a-záéíóúñ\s]+$/|max:32'
        ];
        $messages = [
            'user_id.unique' => 'ID usuario: Ya se ha registrado su ubicación.',
            'latitude.required' => 'Latitud: Requerida.',
            'latitude.decimal' => 'Latitud: Formato incorrecto.',
            'length.required' => 'Longitud: Requerida.',
            'length.decimal' => 'Latitud: Formato incorrecto.',
            'zone.required' => 'Zona: Requerida.',
            'zone.regex' => 'Zona: Debe contener solo letras minúsculas y espacios.',
            'zone.max' => 'Zona: Demasiado larga.'
        ];
        if(auth()->user()->profile_id != '1')
        {
            $validator = Validator::make([
                'user_id' => auth()->user()->id,
                'latitude' => $request->latitude,
                'length' => $request->length,
                'zone' => $request->zone
            ], $rules, $messages);
            if($validator->fails())
            {
                return response()->json([
                'status' => 400,
                'message' => 'Ocurrió un error en la validación de datos.',
                'success' => false,
                'data' => null,
                'errors' => $validator->errors()
                ], 400);
            } else {
                $user = User::findOrFail(auth()->user()->id);
                $locationData = new UserLocation($request->all());
                $user->userLocation()->save($locationData);
                return response()->json([
                    'status' => 200,
                    'message' => 'Ubicación registrada exitosamente.',
                    'success' => true,
                    'data' => $locationData,
                    'errors' => null
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrió un error de usuario.',
                'success' => false,
                'data' => null,
                'errors' => ['ID perfil:' => 'No pertenece a nigún paciente o psicólogo.']
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $rules = [
            'latitude' => 'required|decimal:15,16',
            'length' => 'required|decimal:15,16',
            'zone' => 'required|regex:/^[a-záéíóúñ\s]+$/|max:32'
        ];
        $messages = [
            'latitude.required' => 'Latitud: Requerida.',
            'latitude.decimal' => 'Latitud: Formato incorrecto.',
            'length.required' => 'Longitud: Requerida.',
            'length.decimal' => 'Latitud: Formato incorrecto.',
            'zone.required' => 'Zona: Requerida.',
            'zone.regex' => 'Zona: Debe contener solo letras minúsculas y espacios.',
            'zone.max' => 'Zona: Demasiado larga.'
        ];
        if(auth()->user()->profile_id != '1')
        {
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails())
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'Ocurrió un error en la validación de datos.',
                    'success' => false,
                    'data' => null,
                    'errors' => $validator->errors()
                ], 400);
            } else {
                $userLocation = UserLocation::where('user_id', auth()->user()->id)->first();
                if($userLocation)
                {
                    $userLocation->update($request->all());
                    return response()->json([
                        'status' => 200,
                        'message' => 'Ubicación actualizada exitosamente.',
                        'success' => true,
                        'data' => $userLocation,
                        'errors' => null
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Ocurrió un error al actualizar la ubicación.',
                        'success' => false,
                        'data' => null,
                        'errors' => ['ID usuario:' => 'No se ha encontrado ninguna ubicación.']
                    ], 400);
                }
            }
        } else {
            return response()->json([
            'status' => 400,
            'message' => 'Ocurrió un error de usuario.',
            'success' => false,
            'data' => null,
            'errors' => ['ID perfil:' => 'No pertenece a nigún paciente o psicólogo.']
            ], 400);
        }
    }
}
