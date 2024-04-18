<?php

namespace App\Http\Controllers\Web\Admin\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class EmergencyContactsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(int $id)
    {
        $listAllEmergencyContacts = User::where('id', $id)->where('profile_id', 2)->with('emergencyContact')->first();
        if($listAllEmergencyContacts != null)
        {
            return response()->json($listAllEmergencyContacts, 200);
        }else{
            return response()->json('No corresponde a un paciente', 400);
        }
    }
}
