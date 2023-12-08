<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserLocation;

class UpdateLocationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric',
            'latitude' => 'required|decimal:4,16',
            'length' => 'required|decimal:4,16',
            'zone' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:32'
        ];
        $messages = [
            'user_id.required' => 'ID usuario: Requerido.',
            'user_id.numeric' => 'ID usuario: Debe ser númerico.',
            'user_id.unique' => 'ID usuario: Ya se ha registrado su ubicación.',
            'latitude.required' => 'Latitud: Requerida.',
            'latitude.decimal' => 'Latitud: Formato incorrecto.',
            'length.required' => 'Longitud: Requerida.',
            'length.decimal' => 'Latitud: Formato incorrecto.',
            'zone.required' => 'Zona: Requerida.',
            'zone.regex' => 'Zona: Debe contener solo letras.',
            'zone.max' => 'Zona: Demasiado larga.'
        ];
        $validotor = Validator::make($request->all(), $rules, $messages);
        if($validotor->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Error de datos de ubicación.',
                'success' => false,
                'data' => null,
                'errors' => $validotor->errors()
            ], 400);
        }
        UserLocation::where('user_id', $request->user_id)->update([
            'latitude' => $request->latitude,
            'length' => $request->length,
            'zone' => strtolower($request->zone)
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Se ha actualizado correctamente la ubicación.',
            'success' => true,
            'data' => null,
            'errors' => null 
        ], 200);
    }
}
