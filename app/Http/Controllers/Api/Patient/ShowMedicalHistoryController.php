<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalHistory;

class ShowMedicalHistoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if(auth()->user()->profile_id == 2)
        {
            $medicalHistory = MedicalHistory::where('user_id', auth()->user()->id)->first();
            if($medicalHistory)
            { 
                return response()->json([
                    'status' => 200,
                    'message' => 'Se ha encontrado el historial clínico.',
                    'success' => true,
                    'data' => $medicalHistory,
                    'errors' => null
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Ocurrió un error con historial clínico.',
                    'success' => false,
                    'data' => null,
                    'errors' => [
                        'ID usuario:' => 'No se ha encontrado relación con ningún historial clínico.'
                    ]
                ], 400);
            }
            
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrió un error de usuario.',
                'success' => false,
                'data' => null,
                'errors' => [
                    'ID usuario:' => 'Usuario no corresponde a un paciente o no existe.'
                ]
            ], 400);
        }
    }
}
