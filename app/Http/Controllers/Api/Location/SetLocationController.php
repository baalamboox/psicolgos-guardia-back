<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SetLocationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'latitude' => 'required|decimal:2,5',
            'length' => 'required|decimal:2,5',
            'zone' => 'required'
        ];
        $messages = [
            'user_id.required' => 'ID usuario: Requerido.',
            'latitude.required' => 'Latitud: Requerida.',
            'latitude.decimal' => 'Latitud: Formato incorrecto.',
            'length.required' => 'Longitud: Requerida.',
            'length.decimal' => 'Latitud: Formato incorrecto.',
            'zone' => 'Zona: Requerida.'
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
        return response()->json([
            'request' => $request->all()
        ], 200);
    }
}
