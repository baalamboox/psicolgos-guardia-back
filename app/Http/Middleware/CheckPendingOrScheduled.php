<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Appointment;

class checkPendingOrScheduled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $pendingAppointment = Appointment::where([
            'patient_user_id' => auth()->user()->id,
            'state' => 'pendiente'
        ])->get();
        $scheduledAppointment = Appointment::where([
            'patient_user_id' => auth()->user()->id,
            'state' => 'agendada'
        ])->get();
        if(!$pendingAppointment->isEmpty())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrió un error en la creación de la cita.',
                'success' => false,
                'data' => null,
                'errors' => ['Cita:' => 'Pendiente.'],
                'details' => 'Debes cancelar la cita pendiente para poder crear otra.'
            ], 400);
        } elseif(!$scheduledAppointment->isEmpty()) {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrió un error en la creación de la cita.',
                'success' => false,
                'data' => null,
                'errors' => ['Cita:' => 'Agendada.'],
                'details' => 'Debes cancelar la cita agendada ó esperar a que sea atendida para poder crear otra.'
            ], 400);
        }
        return $next($request);
    }
}
