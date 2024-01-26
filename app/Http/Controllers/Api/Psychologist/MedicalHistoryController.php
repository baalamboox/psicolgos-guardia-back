<?php

namespace App\Http\Controllers\Api\Psychologists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MedicalHistory;
use App\Models\MedicalHistoryLog;
use App\Models\User;

class MedicalHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required|unique:medical_histories|integer',
            'treatment_plan' => 'required',
            'admission_date' => 'required',
            'clinical_evaluation' => 'required',
            'current_problematic_description' => 'required',
            'medical_history' => 'required',
            'psychological_history' => 'required',
            'medication' => 'required',
            'provisional_diagnosis' => 'required',
            'traumatic_experiences' => 'required',
            'psychosocial_history' => 'required',
            'substance_consumption' => 'required',
            'ailments' => 'required'
        ];
        $messages = [
            'user_id.required' => 'ID usuario: Requerido.',
            'user_id.unique' => 'ID usuario: Ya se ha creado un historial relacionado con el ID del paciente.',
            'user_id.integer' => 'ID usuario: Debe ser un número entero positivo.',
            'treatment_plan.required' => 'Plan de tratamiento: Requerido.',
            'admission_date.required' => 'Fecha de ingreso: Requerido.',
            'clinical_evaluation.required' => 'Evaluación clínica: Requerida.',
            'current_problematic_description.required' => 'Descripción de la problemática actual: Requerida.',
            'medical_history.required' => 'Historial médico: Requerido.',
            'psychological_history.required' => 'Historial psicólogico: Requerido.',
            'medication.required' => 'Medicación: Requerida.',
            'provisional_diagnosis.required' => 'Diagnóstico provisional: Requerido.',
            'traumatic_experiences.required' => 'Experiencias traumaticas: Requeridas.',
            'psychosocial_history.required' => 'Historial psicosocial: Requerido.',
            'substance_consumption.required' => 'Consumo de sustancias: Requerido.',
            'ailments.required' => 'Padecimientos: Requeridos.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrió un error de validación de datos.',
                'success' => true,
                'data' => null,
                'errors' => $validator->errors()
            ], 400);
        }
        User::findOrFail($request->user_id);
        $createdMedicalHistory = MedicalHistory::create($request->all());
        MedicalHistoryLog::create([
            'medical_history_id' => $createdMedicalHistory->id,
            'user_id' => auth()->user()->id,
            'action' => 'creación de historial clínico',
            'details' => 'creó un nuevo historial clínico para un paciente'
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Creación exitosa del historial clínico.',
            'success' => true,
            'data' => $createdMedicalHistory,
            'errors' => null
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $user_id)
    {
        $medicalHistory = MedicalHistory::where('user_id', $user_id)->get();
        if($medicalHistory->isEmpty())
        {
            return response()->json([
                'status' => 200,
                'message' => 'No se ha encontrado historial clínico.',
                'success' => true,
                'data' => null,
                'errors' => null
            ], 200);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Se ha encontrado historial clínico.',
            'success' => true,
            'data' => $medicalHistory,
            'errors' => null
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $rules = [
            'treatment_plan' => 'required',
            'clinical_evaluation' => 'required',
            'current_problematic_description' => 'required',
            'medical_history' => 'required',
            'psychological_history' => 'required',
            'medication' => 'required',
            'provisional_diagnosis' => 'required',
            'traumatic_experiences' => 'required',
            'psychosocial_history' => 'required',
            'substance_consumption' => 'required',
            'ailments' => 'required'
        ];
        $messages = [
            'clinical_evaluation.required' => 'Evaluación clínica: Requerida.',
            'current_problematic_description.required' => 'Descripción de la problemática actual: Requerida.',
            'medical_history.required' => 'Historial médico: Requerido.',
            'psychological_history.required' => 'Historial psicólogico: Requerido.',
            'medication.required' => 'Medicación: Requerida.',
            'provisional_diagnosis.required' => 'Diagnóstico provisional: Requerido.',
            'traumatic_experiences.required' => 'Experiencias traumaticas: Requeridas.',
            'psychosocial_history.required' => 'Historial psicosocial: Requerido.',
            'substance_consumption.required' => 'Consumo de sustancias: Requerido.',
            'ailments.required' => 'Padecimientos: Requeridos.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrió un error de validación de datos.',
                'success' => true,
                'data' => null,
                'errors' => $validator->errors()
            ], 400);
        }
        MedicalHistory::findOrFail($id);
        $updatedMedicalHistory = MedicalHistory::where('id', $id)->update($request->all());
        MedicalHistoryLog::create([
            'medical_history_id' => $id,
            'user_id' => auth()->user()->id,
            'action' => 'actualización del historial clínico',
            'details' => 'actualizó un historial clínico de un paciente'
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Actualización exitosa del historial clínico.',
            'success' => true,
            'data' => $updatedMedicalHistory,
            'errors' => null
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $deletedMedicaHistory = MedicalHistory::findOrFail($id);
        $deletedMedicaHistory->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Eliminación exitosa del historial clínico.',
            'success' => true,
            'data' => $deletedMedicaHistory,
            'errors' => null
        ], 200);
    }
}
