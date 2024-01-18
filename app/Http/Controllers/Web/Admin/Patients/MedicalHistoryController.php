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
        $medicalHistory = User::where('id', $id)->with('medicalHistory')->with('userPersonalData')->get();
        // return response()->json($medicalHistory[0]->medicalHistory, 200);
        return view('admin.patients.medical-history', ['data' => $medicalHistory]);
    }
}
