<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserPersonalData;
use App\Models\UserLog;

class NewAdminController extends Controller
{
    //
    public function showViewNewAdmin ()
    {
        return view('admin.new-admin');
    }
    public function createNewAdmin(Request $request)
    {
        $rules = [
            'names' => 'required|string|alpha:ascii|max:32',
            'first_surname' => 'required|string|alpha:ascii|max:16',
            'second_surname' => 'required|string|alpha:ascii|max:16',
            'email' => 'required|email|unique:users|max:128',
            'password' => 'required|min:8|max:10'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            $names = $request->old('names');
            $first_surname = $request->old('first_surname');
            $second_surname = $request->old('second_surname');
            $email = $request->old('email');
            $password = $request->old('password');
            return redirect()->route('new.admin')->withErrors($validator)->withInput();
        }
        $profile = Profile::find(1);
        $user = new User([
            'email' => $request->email,
            'password' => $request->password,
            'state' => 1
        ]);
        $profile->users()->save($user);
        $userPersonalData = new UserPersonalData([
            'names' => $request->names,
            'first_surname' => $request->first_surname,
            'second_surname' => $request->second_surname
        ]);
        $user->userPersonalData()->save($userPersonalData);
        $userLog = new UserLog([
            'user_id' => $request->user()->id,
            'action' => 'Creación de Administrador.',
            'details' => 'Haz creado un nuevo perfil de Administrador en el sistema.'
        ]);
        $userLog->save();
        return redirect()->route('new.admin')->with('success', true);
    } 
}
