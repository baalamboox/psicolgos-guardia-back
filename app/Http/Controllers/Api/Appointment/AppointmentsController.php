<?php

namespace App\Http\Controllers\Api\Appointments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Appointment;
use App\Models\AppointmentLog;

class AppointmentsController extends Controller
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
            'message' => 'Ocurrió un error en la validación de datos.',
            'success' => false,
            'data' => null,
            'errors' => $validator->errors()
            ], 400);
        }
        $createdAppointment = Appointment::create([
            'psychologist_user_id' => $request->psychologist_user_id,
            'patient_user_id' => auth()->user()->id,
            'reason_inquiry' => $request->reason_inquiry,
            'note' => $request->note,
            'preferred_datetime' => $request->preferred_datetime,
            'way_pay' => $request->way_pay,
            'state' => 'enviado'
        ]);
        AppointmentLog::create([
            'appointment_id' => $createdAppointment->id,
            'user_id' => auth()->user()->id,
            'action' => 'creación de cita',
            'details' => 'creó una cita de forma correcta.'
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Se ha creado una cita correctamente.',
            'success' => true,
            'data' => $createdAppointment,
            'errors' => null
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $user_id)
    {
        $appointment = Appointment::where('patient_user_id', $user_id)->get();
        if($appointment->isEmpty())
        {
            return response()->json([
                'status' => 200,
                'message' => 'No se ha encontrado cita.',
                'success' => true,
                'data' => null,
                'errors' => null
            ], 200);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Se ha encontrado cita.',
            'success' => true,
            'data' => $appointment,
            'errors' => null
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $rules = [
            'reason_inquiry' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ., ]+$/|max:255',
            'note' => 'nullable|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ.,():"" ]+$/|max:255',
            'preferred_datetime' => 'required',
            'way_pay' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ., ]+$/|max:64',
        ];
        $messages = [
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
            'message' => 'Ocurrió un error en la validación de datos.',
            'success' => false,
            'data' => null,
            'errors' => $validator->errors()
            ], 400);
        }
        $updatedAppointment = Appointment::where('id', $id)->update([
            'reason_inquiry' => $request->reason_inquiry,
            'note' => $request->note,
            'preferred_datetime' => $request->preferred_datetime,
            'way_pay' => $request->way_pay,
            'state' => $request->state ?? 'enviado'
        ]);
        AppointmentLog::create([
            'appointment_id' => $id,
            'user_id' => auth()->user()->id,
            'action' => 'actualización de cita',
            'details' => 'actualizó una cita de forma correcta.'
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Se ha actualizado una cita correctamente.',
            'success' => true,
            'data' => $updatedAppointment,
            'errors' => null
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $deletedAppointment = Appointment::findOrFail($id);
        $deletedAppointment->delete();
        AppointmentLog::create([
            'appointment_id' => $id,
            'user_id' => auth()->user()->id,
            'action' => 'eliminación de cita',
            'details' => 'eliminó una cita de forma correcta.'
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Eliminación exitosa de cita.',
            'success' => true,
            'data' => $deletedAppointment,
            'errors' => null
        ], 200);
    }
}
