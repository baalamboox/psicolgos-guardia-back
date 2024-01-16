<?php

namespace App\Http\Controllers\Api\Psychologists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicalHistoryController extends Controller
{
    //
    public function search(Request $request)
    {
        return response()->json('Search', 200);
    }
    public function create(Request $request)
    {
        return response()->json('Create', 200);
    }
    public function edit(Request $request)
    {
        return response()->json('Edit', 200);
    }
}
