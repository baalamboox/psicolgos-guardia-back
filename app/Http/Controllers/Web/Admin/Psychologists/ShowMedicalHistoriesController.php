<?php

namespace App\Http\Controllers\Web\Admin\Psychologists;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\UserPersonalData;

class ShowMedicalHistoriesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(int $id)
    {
        $psychologist = UserPersonalData::where('user_id', $id)->first();
        $patients = DB::table('medical_histories_log')
        ->where('medical_histories_log.user_id', $id)
        ->where('action', 'creación de historial clínico')
        ->whereNull('users.deleted_at')
        ->join('medical_histories', 'medical_histories_log.medical_history_id', '=', 'medical_histories.id')
        ->join('user_personal_data', 'medical_histories.user_id', '=', 'user_personal_data.user_id')
        ->join('users', 'user_personal_data.user_id', '=', 'users.id')
        ->select(
            'users.id',
            'users.profile_photo',
            'user_personal_data.names',
            'user_personal_data.first_surname',
            'user_personal_data.age',
            'user_personal_data.sex'
        )
        ->get();
        return view('admin.psychologists.medical-histories', ['psychologist' => $psychologist, 'patients' => $patients]);
    }
}
