<?php

namespace App\Http\Controllers\Web\Admin\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLog;

class GeneralDataController extends Controller
{
    
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $patient = User::where('id', $id)->with('userPersonalData')->first();
        $activity = UserLog::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        return view('admin.patients.general-data', ['patient' => $patient, 'activity' => $activity]);
    }
}
