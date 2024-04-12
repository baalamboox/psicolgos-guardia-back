<?php

namespace App\Http\Controllers\Api\Appointment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Appointment;
use App\Models\AppointmentLog;


class AppointmentController extends Controller
{

    public function create(Request $request)
    {
        $rules = [
            'psychologist_user_id' => 'required|integer',
            'reason_inquiry' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ,.\s]+$/|max:255',
            'note' => 'required|regex:/^[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ,.\-\"\":;\s]+$/|max:255',
            'preferred_datetime' => 'required|date',
            'way_pay' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ.\s]+$/|max:64'
        ];
        $messages = [
            'psychologist_user_id.required' => 'ID psicólogo: Requerido.',
            'psychologist_user_id.integer' => 'ID psicólogo: Inválido.',
            'reason_inquiry.required' => 'Motivo de cita: Requerido.',
            'reason_inquiry.regex' => 'Motivo de cita: Contine caracteres no soportados.',
            'reason_inquiry.max' => 'Motivo de cita: Demasiado largo.',
            'note.required' => 'Nota: Requerida',
            'note.regex' => 'Nota: Contiene caracteres no soportados.',
            'note.max' => 'Nota: Demasiada larga.',
            'preferred_datetime.required' => 'Fecha y hora: Requerida.',
            'preferred_datetime.date' => 'Fecha y hora: Formato inválido.',
            'way_pay.required' => 'Forma de pago: Requerida.',
            'way_pay.regex' => 'Forma de pago: Contiene caracteres no soportados.',
            'way_pay.max' => 'Forma de pago: Demasiado largo.'
        ];
        if(auth()->user()->profile_id == 2)
        {
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
                $existedPsychologist = User::find($request->psychologist_user_id);
                if($existedPsychologist && $existedPsychologist->profile_id == 3)
                {
                    $createdAppointment = Appointment::create([
                        'psychologist_user_id' => $request->psychologist_user_id,
                        'patient_user_id' => auth()->user()->id,
                        'reason_inquiry' => $request->reason_inquiry,
                        'note' => $request->note,
                        'preferred_datetime' => $request->preferred_datetime,
                        'way_pay' => $request->way_pay,
                        'state' => 'pendiente'
                    ]);
                    AppointmentLog::create([
                        'appointment_id' => $createdAppointment->id,
                        'user_id' => auth()->user()->id,
                        'action' => 'creación de cita',
                        'details' => 'creó una cita con un psicólogo'
                    ]);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Creación existosa de la cita.',
                        'success' => true,
                        'data' => $createdAppointment,
                        'errors' => null
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Ocurrió un error de usuario.',
                        'success' => false,
                        'data' => null,
                        'errors' => ['ID psicólogo:' => 'No existe, a sido eliminado ó no es un psicólogo.']
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Usuario inválido.',
                'success' => false,
                'data' => null,
                'errors' => ['ID perfil:' => 'No corresponde a un perfil de paciente.']
            ], 400);
        }
    }

    public function cancel(int $id)
    {
        if(auth()->user()->profile_id == 2)
        {
            $appointment = Appointment::find($id);
            if($appointment)
            {
                if($appointment->state == 'pendiente' || $appointment->state == 'agendada') {
                    $appointment->state = 'cancelada';
                    $appointment->save();
                    AppointmentLog::create([
                        'appointment_id' => $appointment->id,
                        'user_id' => auth()->user()->id,
                        'action' => 'cancelación de cita',
                        'details' => 'canceló una cita con un psicólogo'
                    ]);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Se ha cancelado la cita exitosamente.',
                        'success' => true,
                        'data' => $appointment,
                        'errors' => null
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Ocurrió un error al cancelar la cita.',
                        'success' => false,
                        'data' => null,
                        'errors' => ['Cita:' => 'No esta pendiente o agendada.']
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Ocurrió un error al encontrar la cita a cancelar.',
                    'success' => false,
                    'data' => null,
                    'errors' => ['ID cita:' => 'No existe ó a sido eliminada.']
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Usuario inválido.',
                'success' => false,
                'data' => null,
                'errors' => ['ID perfil:' => 'No corresponde a un perfil de paciente.']
            ], 400);
        }
    }

    public function schedule(int $id)
    {
        if(auth()->user()->profile_id == 3)
        {
            $appointment = Appointment::find($id);
            if($appointment)
            {
                if($appointment->state == 'pendiente')
                {
                    $appointment->state = 'agendada';
                    $appointment->save();
                    AppointmentLog::create([
                        'appointment_id' => $appointment->id,
                        'user_id' => auth()->user()->id,
                        'action' => 'cita agendada',
                        'details' => 'agendó una cita con un paciente'
                    ]);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Se ha agendado la cita exitosamente.',
                        'success' => true,
                        'data' => $appointment,
                        'errors' => null
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Ocurrió un error al agendar la cita.',
                        'success' => false,
                        'data' => null,
                        'errors' => ['Cita:' => 'No esta pendiente ó ya ha sido agendada.']
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Ocurrió un error al encontrar la cita a agendar.',
                    'success' => false,
                    'data' => null,
                    'errors' => ['ID cita:' => 'No existe ó a sido eliminada.']
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Usuario inválido.',
                'success' => false,
                'data' => null,
                'errors' => ['ID perfil:' => 'No corresponde a un perfil de psicólogo.']
            ], 400);
        }
    }

    public function reject(int $id)
    {
        if(auth()->user()->profile_id == 3)
        {
            $appointment = Appointment::find($id);
            if($appointment)
            {
                if($appointment->state == 'pendiente')
                {
                    $appointment->state = 'rechazada';
                    $appointment->save();
                    AppointmentLog::create([
                        'appointment_id' => $appointment->id,
                        'user_id' => auth()->user()->id,
                        'action' => 'cita rechazada',
                        'details' => 'rechazó una cita de un paciente'
                    ]);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Se ha rechazado la cita exitosamente.',
                        'success' => true,
                        'data' => $appointment,
                        'errors' => null
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Ocurrió un error al rechazar la cita.',
                        'success' => false,
                        'data' => null,
                        'errors' => ['Cita:' => 'Ya ha sido agendada ó rechazada.']
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Ocurrió un error al encontrar la cita a rechazar.',
                    'success' => false,
                    'data' => null,
                    'errors' => ['ID cita:' => 'No existe ó a sido eliminada.']
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Usuario inválido.',
                'success' => false,
                'data' => null,
                'errors' => ['ID perfil:' => 'No corresponde a un perfil de psicólogo.']
            ], 400);
        }
    }

    public function attend(int $id)
    {
        if(auth()->user()->profile_id == 3)
        {
            $appointment = Appointment::find($id);
            if($appointment)
            {
                if($appointment->state == 'agendada')
                {
                    $appointment->state = 'atendida';
                    $appointment->save();
                    AppointmentLog::create([
                        'appointment_id' => $appointment->id,
                        'user_id' => auth()->user()->id,
                        'action' => 'cita atendida',
                        'details' => 'atendió una cita de un paciente'
                    ]);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Se ha atendido la cita exitosamente.',
                        'success' => true,
                        'data' => $appointment,
                        'errors' => null
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Ocurrió un error al atender la cita.',
                        'success' => false,
                        'data' => null,
                        'errors' => ['Cita:' => 'Ya ha sido atendida.']
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Ocurrió un error al encontrar la cita a atender.',
                    'success' => false,
                    'data' => null,
                    'errors' => ['ID cita:' => 'No existe ó a sido eliminada.']
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Usuario inválido.',
                'success' => false,
                'data' => null,
                'errors' => ['ID perfil:' => 'No corresponde a un perfil de psicólogo.']
            ], 400);
        }
    }

    public function showBy(Request $request)
    {
        $profile = '';
        switch (auth()->user()->profile_id)
        {
            case '2':
                $profile = 'patient';
                break;
            case '3':
                $profile = 'psychologist';
                break;
            default:
                break;
        }
        $pending = Appointment::where([
            [$profile . '_user_id', auth()->user()->id],
            ['state', strtolower($request->query('state'))]
        ])->get();
        if($pending->isEmpty())
        {
            return response()->json([
                'status' => 400,
                'message' => 'No se encontrarón citas ' . strtolower($request->query('state')) . 's.',
                'success' => false,
                'data' => null,
                'errors' => null
            ], 400);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Se encontrarón las siguientes citas ' . strtolower($request->query('state')) . 's.',
                'success' => true,
                'data' => $pending,
                'errors' => null
            ], 200);
        }
    }

    public function delete(int $id)
    {
        $profile = '';
        switch (auth()->user()->profile_id) {
            case '2':
                $profile = 'patient';
                break;
            case '3':
                $profile = 'psychologist';
                break;
            default:
                break;
        }
        $appointment = Appointment::where([
            ['id', '=', $id],
            [$profile . '_user_id', '=', auth()->user()->id],
        ])->get();
        if($appointment->isEmpty())
        {
            return response()->json([
                'status' => 400,
                'message' => 'No se encontró la cita relacionada.',
                'success' => false,
                'data' => null,
                'errors' => null
            ], 400);
        } else {
            switch ($appointment[0]->state) {
                case 'cancelada':
                    Appointment::find($appointment[0]->id)->delete();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Se eliminó correctamente la cita.',
                        'success' => true,
                        'data' => null,
                        'errors' => null
                    ], 200);
                    break;
                case 'rechazada':
                    Appointment::find($appointment[0]->id)->delete();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Se eliminó correctamente la cita.',
                        'success' => true,
                        'data' => null,
                        'errors' => null
                    ], 200);
                    break;
                case 'atendida':
                    Appointment::find($appointment[0]->id)->delete();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Se eliminó correctamente la cita.',
                        'success' => true,
                        'data' => null,
                        'errors' => null
                    ], 200);
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
}
