<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PsychologistInfoMapController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $userId)
    {
        $psychologistInfo = DB::table('users')
        ->where('users.id', $userId)
        ->where('profile_id', 3)
        ->whereNull('users.deleted_at')
        ->join('user_personal_data', 'users.id', '=', 'user_personal_data.user_id')
        ->select(
            'users.id',
            'users.profile_photo',
            'user_personal_data.names',
            'user_personal_data.first_surname',
            'user_personal_data.second_surname',
            'user_personal_data.title',
            'user_personal_data.specialty',
            'user_personal_data.phone',
            'user_personal_data.whatsapp'
        )->get();
        if($psychologistInfo->isEmpty())
        {
            return response()->json([
                'status' => 400,
                'message' => 'No se encontró información del psicólogo.',
                'success' => false,
                'data' => null,
                'errors' => ['ID usuario' => 'No existe ó no pertenece a ningún psicólogo.']
            ], 400);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Se encontró la información del psicólogo.',
                'success' => true,
                'data' => $psychologistInfo,
                'errors' => null
            ], 200);
        }
    }
}
