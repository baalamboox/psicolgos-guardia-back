<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserLog;

class AuthController extends Controller
{
    public function showSignin() {
        return view('auth.signin');
    }
    public function signin(Request $request)
    {
        $rules = [
            'email' => 'required|unique:users|email|max:128',
            'password' => 'required|min:8|max:10'
        ];
        $validator = Validator::make($request->all(), $rules);
        $profile = User::where('email', $request->email)->first()->profile_id;
        if($profile != 1)
        {
            return redirect()->route('signin');
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            $userLog = new UserLog([
                'user_id' => $request->user()->id,
                'action' => 'Inicio de sesión.',
                'details' => 'Haz iniciado sesión de forma correcta.'
            ]);
            $userLog->save();
            return redirect()->route('home');
        }
        return redirect()->route('signin');
    }
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $userLog = new UserLog([
            'user_id' => $request->user()->id,
            'action' => 'Sesión cerrada.',
            'details' => 'Haz cerrado sesión de forma correcta.'
        ]);
        $userLog->save();
        Auth::logout();
        return redirect()->route('signin');
    }
}
