<?php

namespace App\Http\Controllers\Web\Admin\Psychologists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ListAllPsychologistsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $psychologists = User::where('profile_id', 3)->with('userPersonalData')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Se encontraron los siguientes psicólogos.',
            'success' => true,
            'data' => $psychologists,
            'errors' => null
        ], 200);
    }
}
