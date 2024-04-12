<?php

namespace App\Http\Controllers\Api\Psychologist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\MedicalHistory;
use App\Models\MedicalHistoryLog;

class MedicalHistoryController extends Controller
{
    public function create(Request $request, int $id)
    {
        $rules = [
            'user_id' => 'required|integer|unique:medical_histories',
            'treatment_plan' => 'required|',
            'admission_date' => 'required|',
            'clinical_evaluation' => 'required|',
            'current_problematic_description' => 'required|',
            'medical_history' => 'required|',
            'psychological_history' => 'required|',
            'medication' => 'required|json',
            'provisional_diagnosis' => 'required|',
            'traumatic_experiences' => 'required|json',
            'psychosocial_history' => 'required|',
            'substance_consumption' => 'required|json',
            'ailments' => 'required|json'
        ];
        $messages = [
            'user_id.required' => 'ID usuario: Requerido.',
            'user_id.integer' => 'ID usuario: Debe ser entero positivo.',
            'user_id.unique' => 'ID usuario: Ya se ha creado su historial clínico.',
            'treatment_plan.required' => 'Plan tratamiento: Requerido.',
            'admission_date.required' => 'Fecha de ingreso: Requerida.',
            'clinical_evaluation.required' => 'Evaluación clínica: Requerida.',
            'current_problematic_description.required' => 'Descripción problemática actual: Requeridad.',
            'medical_history.required' => 'Historia médica: Requerida.',
            'psychological_history.required' => 'Historia psicológica: Requerida.',
            'medication.required' => 'Medicación: Requerida.',
            'medication.json' => 'Medicación: Formato de datos inválido, debe ser JSON.',
            'provisional_diagnosis.required' => 'Diagnóstico provisional: Requerido.',
            'traumatic_experiences.required' => 'Experiencias traumáticas: Requerida.',
            'traumatic_experiences.json' => 'Experiencias traumáticas: Formato de datos inválido, debe ser JSON.',
            'psychosocial_history.required' => 'Historia psicósocial: Requerida.',
            'substance_consumption.required' => 'Consumo de sustancias: Requerido.',
            'substance_consumption.json' => 'Consumo de sustancias: Formato de datos inválido, debe ser JSON.',
            'ailments.required' => 'Enfermedades ó padecimientos: Requeridos.'
        ];
        $data = ['user_id' => $id, ...$request->all()];
        if(auth()->user()->profile_id == 3)
        {
            $validator = Validator::make($data, $rules, $messages);
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
                $user = User::find($id);
                if($user && $user->profile_id == 2) {
                    $medicalHistoryData = new MedicalHistory($data);
                    $user->medicalHistory()->save($medicalHistoryData);
                    MedicalHistoryLog::create([
                        'medical_history_id' => $medicalHistoryData->id,
                        'user_id' => auth()->user()->id,
                        'action' => 'creación de historial clínico',
                        'details' => 'Psicólogo ha creado un historial clínico de un paciente'
                    ]);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Se ha creado historial clínico exitosamente.',
                        'success' => true,
                        'data' => null, 
                        'errors' => null
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Ocurrió un error de usuario.',
                        'success' => false,
                        'data' => null,
                        'errors' => [
                            'ID usuario:' => 'Usuario no corresponde a un psicólogo o no existe.'
                        ]
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrió un error de usuario.',
                'success' => false,
                'data' => null,
                'errors' => [
                    'ID usuario:' => 'Usuario no corresponde a un psicólogo.'
                ]
            ], 400);
        }
        
    }
    
    public function verify(Request $request)
    {
        if(auth()->user()->profile_id == 3)
        {
            $medicalHistory = MedicalHistory::where('user_id', $request->query('patient_id'))->first();
            if($medicalHistory)
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'Genial, si existe historial clínico.',
                    'success' => true,
                    'data' => null,
                    'errors' => null
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Ocurrió un error de datos.',
                    'success' => false,
                    'data' => null,
                    'errors' => [
                        'ID usuario:' => 'No se encontró historial clínico.'
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
                    'ID usuario:' => 'Usuario no corresponde a un psicólogo.'
                ]
            ], 400);
        }
    }

    public function show($idPatient)
    {
        if(auth()->user()->profile_id == 3)
        {
            $medicalHistory = MedicalHistory::where('user_id', $idPatient)->first();
            if($medicalHistory)
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'Genial, se encontró el historial clínico.',
                    'success' => true,
                    'data' => $medicalHistory,
                    'errors' => null
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Ocurrió un error al encontrar el historial clínico.',
                    'success' => false,
                    'data' => null,
                    'errors' => [
                        'ID usuario:' => 'Aún no se ha creado historial clínico o ha sido eliminado.'
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
                    'ID usuario:' => 'Usuario no corresponde a un psicólogo.'
                ]
            ], 400);
        }
    }

    public function update(Request $request, int $id)
    {
        $rules = [
            'user_id' => 'required|integer',
            'treatment_plan' => 'required|',
            'admission_date' => 'required|',
            'clinical_evaluation' => 'required|',
            'current_problematic_description' => 'required|',
            'medical_history' => 'required|',
            'psychological_history' => 'required|',
            'medication' => 'required|json',
            'provisional_diagnosis' => 'required|',
            'traumatic_experiences' => 'required|json',
            'psychosocial_history' => 'required|',
            'substance_consumption' => 'required|json',
            'ailments' => 'required|json'
        ];
        $messages = [
            'user_id.required' => 'ID usuario: Requerido.',
            'user_id.integer' => 'ID usuario: Debe ser entero positivo.',
            'treatment_plan.required' => 'Plan tratamiento: Requerido.',
            'admission_date.required' => 'Fecha de ingreso: Requerida.',
            'clinical_evaluation.required' => 'Evaluación clínica: Requerida.',
            'current_problematic_description.required' => 'Descripción problemática actual: Requeridad.',
            'medical_history.required' => 'Historia médica: Requerida.',
            'psychological_history.required' => 'Historia psicológica: Requerida.',
            'medication.required' => 'Medicación: Requerida.',
            'medication.json' => 'Medicación: Formato de datos inválido, debe ser JSON.',
            'provisional_diagnosis.required' => 'Diagnóstico provisional: Requerido.',
            'traumatic_experiences.required' => 'Experiencias traumáticas: Requerida.',
            'traumatic_experiences.json' => 'Experiencias traumáticas: Formato de datos inválido, debe ser JSON.',
            'psychosocial_history.required' => 'Historia psicósocial: Requerida.',
            'substance_consumption.required' => 'Consumo de sustancias: Requerido.',
            'substance_consumption.json' => 'Consumo de sustancias: Formato de datos inválido, debe ser JSON.',
            'ailments.required' => 'Enfermedades ó padecimientos: Requeridos.'
        ];
        $data = ['user_id' => $id, ...$request->all()];
        if(auth()->user()->profile_id == 3)
        {
            $validator = Validator::make($data, $rules, $messages);
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
                $user = User::find($id);
                if($user && $user->profile_id == 2) {
                    $medicalHistoryData = MedicalHistory::where('user_id', $id)->first();
                    MedicalHistoryLog::create([
                        'medical_history_id' => $medicalHistoryData->id,
                        'user_id' => auth()->user()->id,
                        'action' => 'actualización de historial clínico',
                        'details' => 'Psicólogo ha actualizado un historial clínico de un paciente'
                    ]);
                    $medicalHistoryData->update($request->all());
                    return response()->json([
                        'status' => 200,
                        'message' => 'Se ha actualizado historial clínico exitosamente.',
                        'success' => true,
                        'data' => null, 
                        'errors' => null
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Ocurrió un error de usuario.',
                        'success' => false,
                        'data' => null,
                        'errors' => [
                            'ID usuario:' => 'Usuario no corresponde a un psicólogo o no existe.'
                        ]
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrió un error de usuario.',
                'success' => false,
                'data' => null,
                'errors' => [
                    'ID usuario:' => 'Usuario no corresponde a un psicólogo.'
                ]
            ], 400);
        }
        
    }
}
