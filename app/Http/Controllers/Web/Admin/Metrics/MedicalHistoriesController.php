<?php

namespace App\Http\Controllers\Web\Admin\Metrics;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MedicalHistoriesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $dataMedicalHistoriesByDay = [];
        for($i = 1; $i <= 7; $i++)
        {
            $currentDay = Carbon::now();
            $date = $currentDay->subDays($i)->format('Y-m-d');
            $dataMedicalHistoriesByDay[$date] = [
                'created' => $this->sessionsLogin('creación de historial clínico', $date),
                'updated' => $this->sessionsLogin('actualización de historial clínico', $date)
            ];
        }
        return response()->json([
            'status' => 200,
            'message' => 'Estas son las actividades de los historiales clínicos.',
            'success' => true,
            'data' => $dataMedicalHistoriesByDay,
            'errors' => null
        ], 200);
    }

    public function sessionsLogin($action, $date)
    {
        $medicalHistoriesCounter = DB::table('medical_histories_log')
        ->where('action', $action)
        ->whereDate('created_at', $date)
        ->count();
        return $medicalHistoriesCounter;
    }
}
