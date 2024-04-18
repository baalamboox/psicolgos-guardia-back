<?php

namespace App\Http\Controllers\Web\Admin\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ListAllPatientsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $patients = User::where('profile_id', 2)->with('userPersonalData')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Se encontraron los siguientes pacientes.',
            'success' => true,
            'data' => $patients,
            'errors' => null
        ], 200);
    }
}
