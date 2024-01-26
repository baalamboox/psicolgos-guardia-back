<?php

namespace App\Http\Controllers\Api\Psychologists;

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
        if($psychologists->isEmpty())
        {
            return response()->json([
                'status' => 200,
                'message' => 'No hay psicólogos aún.',
                'success' => true,
                'data' => $psychologists,
                'errors' => null
            ], 200);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Estos son todos los Psicólogos encontrados.',
                'success' => true,
                'data' => $psychologists,
                'errors' => null
            ], 200);
        }
    }
}
