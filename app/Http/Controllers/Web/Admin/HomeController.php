<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    
    public function home(Request $request)
    {
        $profile_photo = User::find($request->user()->id)->profile_photo;
        $request->session()->put('profile_photo', $profile_photo);
        $totalPatients = User::where('profile_id', 2)->count();
        $activePatients = User::where(['state' => 'activo', 'profile_id' => 2])->count();
        $deletedPatients = User::where(['state' => 'eliminado', 'profile_id' => 2])->count();
        $totalPsychologists = User::where('profile_id', 3)->count();
        $activePsychologists = User::where(['state' => 'activo', 'profile_id' => 3])->count();
        $deletedPsychologists = User::where(['state' => 'eliminado', 'profile_id' => 3])->count();
        return view('home', [
            'totalPatients' => $totalPatients,
            'activePatients' => $activePatients,
            'deletedPatients' => $deletedPatients,
            'totalPsychologists' => $totalPsychologists,
            'activePsychologists' => $activePsychologists,
            'deletedPsychologists' => $deletedPsychologists
        ]);
    }

    public function recentUsers()
    {
        $recentUsers = User::where('profile_id', '!=', 1)->whereDate('created_at', date('Y-m-d'))->get();
        return response()->json($recentUsers, 200);
    }
}
