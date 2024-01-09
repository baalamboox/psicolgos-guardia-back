<?php

namespace App\Http\Controllers\Api\Appointments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Appointment;

class AppointmentsController extends Controller
{
    
    public function create(Request $request)
    {
        $rules = [
            'psychologist_user_id' => 'required|integer',
            'reason_inquiry' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ., ]+$/|max:255',
            'note' => 'nullable|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ.,():"" ]+$/|max:255',
            'preferred_datetime' => 'required',
            'way_pay' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ., ]+$/|max:64',
        ];
        $messages = [
            'psychologist_user_id.required' => 'ID de psicólogo: Requerido.',
            'psychologist_user_id.integer' => 'ID de psicólogo: Debe ser número entero positivo.',
            'reason_inquiry.required' => 'Razón de la cita: Requerida.',
            'reason_inquiry.regex' => 'Nota: Se encontraron caracteres inválidos.',
            'reason_inquiry.max' => 'Razón de la cita: No debe sobrepasar de los 255 caracteres.',
            'note.required' => 'Nota: Requerida.',
            'note.regex' => 'Nota: Se encontraron caracteres inválidos.',
            'note.max' => 'Razón de la cita: No debe sobrepasar de los 255 caracteres.',
            'preferred_datetime.required' => 'Fecha y hora de la cita: Requerida.',
            'way_pay.required' => 'Forma de pago: Requerido.',
            'way_pay.regex' => 'Forma de pago: Se encontraron caracteres inválidos.',
            'way_pay.max' => 'Forma de pago: No debe sobrepasar de los 64 caracteres.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Error de datos de la cita a crear.',
                'success' => false,
                'data' => null,
                'errors' => $validator->errors()
            ], 400);
        }
        Appointment::create([
            'psychologist_user_id' => $request->psychologist_user_id,
            'patient_user_id' => auth()->user()->id,
            'reason_inquiry' => $request->reason_inquiry,
            'note' => $request->note,
            'preferred_datetime' => $request->preferred_datetime,
            'way_pay' => $request->way_pay,
            'state' => 'enviado'
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Se creó cita correctamente.',
            'success' => true,
            'data' => null,
            'errors' => null
        ], 200);
    }
}
