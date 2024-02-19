<?php

namespace App\Http\Controllers\Api\Psychologist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MedicalHistory;
use App\Models\MedicalHistoryLog;

class MedicalHistoryController extends Controller
{
    //
    public function create(Request $request, int $idPatient)
    {
        $rules = [
            'user_id' => 'required|integer|unique:medical_histories',
            'treatment_plan' => 'required|',
            'admission_date' => 'required|',
            'clinical_evaluation' => 'required|',
            'current_problematic_description' => 'required|',
            'medical_history' => 'required|',
            'psychological_history' => 'required|',
            'medication' => 'require|json',
            'provisional_diagnosis' => 'required|',
            'traumatic_experiences' => 'required|json',
            'psychosocial_history' => 'required|',
            'substance_consumption' => 'required|json',
            'ailments' => 'required|json'
        ];
        $messages = [
            'user_id' => 'required|integer|unique:medical_histories',
            'treatment_plan' => 'required|',
            'admission_date' => 'required|',
            'clinical_evaluation' => 'required|',
            'current_problematic_description' => 'required|',
            'medical_history' => 'required|',
            'psychological_history' => 'required|',
            'medication' => 'require|json',
            'provisional_diagnosis' => 'required|',
            'traumatic_experiences' => 'required|json',
            'psychosocial_history' => 'required|',
            'substance_consumption' => 'required|json',
            'ailments' => 'required|json'
        ];
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

        }
        return response()->json([
            'data' =>  $request->all()
        ], 200);
    }
    public function show($idPatient)
    {
        return response()->json([
            'status' => 200,
            'message' => 'Genial',
            'success' => true,
            'data' => null, 
            'errors' => null
        ], 200);
    }
}
