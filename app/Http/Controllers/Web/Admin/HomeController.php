<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    
    public function home(Request $request) {
        $profile_photo = User::find($request->user()->id)->profile_photo;
        $request->session()->put('profile_photo', $profile_photo);
        return view('home');
    }
}
