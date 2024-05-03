<?php

namespace App\Http\Controllers\Web\Admin\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class MedicalHistoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $medicalHistory = User::where('id', $id)->where('profile_id', 2)->with('medicalHistory')->with('userPersonalData')->get();
        if($medicalHistory[0]->medicalHistory)
        {
            $medications = json_decode($medicalHistory[0]->medicalHistory->medication);
            $traumatic_experiences = json_decode($medicalHistory[0]->medicalHistory->traumatic_experiences);
            $substances_consumption = json_decode($medicalHistory[0]->medicalHistory->substance_consumption);
            $ailments = json_decode($medicalHistory[0]->medicalHistory->ailments);
            return view('admin.patients.medical-history', [
                'data' => $medicalHistory,
                'medications' => $medications,
                'traumatic_experiences' => $traumatic_experiences,
                'substances_consumption' => $substances_consumption,
                'ailments' => $ailments
            ]);
        } else {
            return view('admin.patients.medical-history', ['data' => $medicalHistory]);
        }
        
    }
}
