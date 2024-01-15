<?php

namespace App\Http\Controllers\Api\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ListAllPatientsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $patients = User::where('profile_id', 2)->with('userPersonalData')->get();
        if($patients->isEmpty())
        {
            return session(['existPatients' => false]);
        } else {
            session(['existPatients' => true]);
            return response()->json([
                'status' => 200,
                'message' => 'Estos son todos los Pacientes encontrados.',
                'success' => true,
                'data' => $patients,
                'errors' => null
            ], 200);
        }
    }
}
