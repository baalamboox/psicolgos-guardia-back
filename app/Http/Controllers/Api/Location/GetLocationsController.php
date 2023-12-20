<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GetLocationsController extends Controller
{

    public function getLocationsPsychologists(Request $request)
    {
        $rule = [
            'zone' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:32'
        ];
        $message = [
            'zone.required' => 'Zona: Requerida.',
            'zone.regex' => 'Zona: Debe contener solo letras.',
            'zone.max' => 'Zona: Demasiado larga.'
        ];
        $validator = Validator::make($request->query(), $rule, $message);
        if($validator->fails())
        {
            return response()->json([
                'status' => '400',
                'message' => 'Error al obtener ubicaciones de pacientes.',
                'success' => false,
                'data' => null,
                'errors' => $validator->errors()
            ], 400);
        }
        $locations = DB::table('users')
            ->where('profile_id', 3)
            ->where('state', 'activo')
            ->where('zone', strtolower($request->query('zone')))
            ->join('user_personal_data', 'users.id', '=', 'user_personal_data.user_id')
            ->join('user_locations', 'users.id', '=', 'user_locations.user_id')
            ->select(
                'users.id',
                'users.email',
                'users.profile_photo',
                'user_personal_data.names',
                'user_personal_data.first_surname',
                'user_personal_data.address',
                'user_personal_data.phone',
                'user_personal_data.type',
                'user_personal_data.title',
                'user_personal_data.specialty',
                'user_personal_data.professional_license',
                'user_locations.latitude',
                'user_locations.length',
                'user_locations.zone'
            )
            ->get();
        return response()->json([
            'status' => '200',
            'message' => 'Se encontraron ubicaciones de psicólogos.',
            'success' => true,
            'data' => $locations,
            'errors' => null
        ], 200);
    }    
}
