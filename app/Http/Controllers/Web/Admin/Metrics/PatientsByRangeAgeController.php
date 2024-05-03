<?php

namespace App\Http\Controllers\Web\Admin\Metrics;

use App\Http\Controllers\Controller;
use App\Models\UserPersonalData;

class PatientsByRangeAgeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $children = UserPersonalData::whereBetween('age', [0, 12])->count();
        $teenagers = UserPersonalData::whereBetween('age', [13, 19])->count();
        $adults = UserPersonalData::whereBetween('age', [20, 59])->count();
        $greater = UserPersonalData::whereBetween('age', [60, 100])->count();
        return response()->json([
            'status' => 200,
            'message' => 'Estos son los rangos de edades para pacientes.',
            'success' => true,
            'data' => [
                'children' => $children,
                'teenagers' => $teenagers,
                'adults' => $adults,
                'greater' => $greater
            ],
            'errors' => null
        ], 200);;
    }
}
