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

    public function showViewNewAdmin ()
    {
        return view('admin.new-admin');
    }

    public function createNewAdmin(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users|max:64',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,:?(){}<>"])[A-Za-z\d!@#$%^&*.,:?(){}<>"]{8,10}$/|confirmed',
            'names' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:32',
            'first_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:16',
            'second_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:16',
        ];
        $messages = [
            'email.required' => 'Correo electrónico requerido.',
            'email.unique' => 'Correo electrónico ya registrado.',
            'email.email' => 'Correo electrónico invalido.',
            'email.max' => 'Correo electrónico muy largo.',
            'password.required' => 'Contraseña requerida.',
            'password.regex' => 'Contraseña debe tener al menos una letra minúscula, al menos una letra mayúscula, al menos un caracter especial, al menos un número y una longitud entre 8 y 10 caracteres.',
            'password.confirmed' => 'Contraseñas no coinciden.',
            'names.required' => 'Nombre(s) requerido(s).',
            'names.regex' => 'Nombre(s) debe contener solo letras.',
            'names.max' => 'Nombre(s) demasiado largo.',
            'first_surname.required' => 'Apellido paterno requerido.',
            'first_surname.regex' => 'Apellido paterno debe contener solo letras.',
            'first_surname.max' => 'Apellido paterno demasiado largo.',
            'second_surname.required' => 'Apellido materno requerido.',
            'second_surname.regex' => 'Apellido materno debe contener solo letras.',
            'second_surname.max' => 'Apellido materno demasiado largo.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
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
            'email' => strtolower($request->email),
            'password' => $request->password,
            'state' => 'activo'
        ]);
        $profile->users()->save($user);
        $userPersonalData = new UserPersonalData([
            'names' =>  strtolower($request->names),
            'first_surname' => strtolower($request->first_surname),
            'second_surname' => strtolower($request->second_surname)
        ]);
        $user->userPersonalData()->save($userPersonalData);
        UserLog::create([
            'user_id' => $request->user()->id,
            'action' => 'creación de usuario',
            'details' => 'creó un nuevo perfil de administrador en el sistema'
        ]);
        return redirect()->route('new.admin')->with('success', true);
    } 
}
