<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class PsychologistLocationsController extends Controller
{

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $rule = [
            'zone' => 'required|regex:/^[a-záéíóúñ\s]+$/|max:32'
        ];
        $message = [
            'zone.required' => 'Zona: Requerida.',
            'zone.regex' => 'Zona: Debe contener solo letras minúsculas y espacios.',
            'zone.max' => 'Zona: Demasiado larga.'
        ];
        $validator = Validator::make([
            'zone' => $request->query('zone')
        ], $rule, $message);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrión un error en la validación de datos.',
                'success' => false,
                'data' => null,
                'errors' => $validator->errors()
            ], 400);
        } else {
            $psychologistLocations = DB::table('users')
            ->where('profile_id', 3)
            ->whereNull('users.deleted_at')
            ->where('zone', strtolower($request->query('zone')))
            ->join('user_locations', 'users.id', '=', 'user_locations.user_id')
            ->select(
                'users.id',
                'user_locations.latitude',
                'user_locations.length',
                'user_locations.zone'
            )->get();
            if($psychologistLocations->isEmpty())
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'No se encontraron psicólogos en la zona.',
                    'success' => false,
                    'data' => null,
                    'errors' => null
                ], 400);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Se encontraron los siguientes psicólogos en la zona.',
                    'success' => true,
                    'data' => $psychologistLocations,
                    'errors' => null
                ], 200);
            }
        }
    }
}
