<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserLog;

class MetricsLoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {

        $dataSessionsByDay = [];
        for($i = 1; $i <= 7; $i++)
        {
            $currentDay = Carbon::now();
            $date = $currentDay->subDays($i)->format('Y-m-d');
            $dataSessionsByDay[$date] = [
                'admin' => $this->sessionsLogin(1, $date),
                'patient' => $this->sessionsLogin(2, $date),
                'psychologist' => $this->sessionsLogin(3, $date)
            ];
        }
        return response()->json([
            'status' => 200,
            'message' => 'Estos son los inicios de sesión de todos los usuarios.',
            'success' => true,
            'data' => $dataSessionsByDay,
            'errors' => null
        ], 200);
    }

    public function sessionsLogin($profile, $date)
    {
        $sessionsCounter = DB::table('users')
        ->where('profile_id', $profile)
        ->where('users_log.action', 'inicio de sesión')
        ->whereDate('users_log.created_at', $date)
        ->join('users_log', 'users.id', '=', 'users_log.user_id')
        ->count();
        return $sessionsCounter;
    }
}
