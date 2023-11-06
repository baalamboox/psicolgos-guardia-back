<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLog;

class ProfileController extends Controller
{
    //
    public function showProfile(Request $request)
    {
        $getUserData = User::where('id', $request->user()->id)->with('userPersonalData')->first();
        $data = [
            'profile_photo' => $getUserData->profile_photo,
            'names' => $getUserData->userPersonalData->names,
            'first_surname' => $getUserData->userPersonalData->first_surname,
            'second_surname' => $getUserData->userPersonalData->second_surname,
            'email' => $getUserData->email,
            'phone' => $getUserData->userPersonalData->phone
        ];
        return view('admin.profile', $data);
    }
    public function showActivity(Request $request)
    {
        $getUserLogs = UserLog::where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return view('admin.logs', ['data' => $getUserLogs]);
    }
}
