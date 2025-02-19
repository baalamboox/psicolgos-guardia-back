<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserPersonalData;
use App\Models\UserLog;
use App\Mail\PasswordAdminMail;
use App\Events\Admin\SendNotifications;

class NewAdminController extends Controller
{

    private function generateRandomPassword($length = 8, $upperCase = true, $lowerCase = true, $numbers = true, $symbols = true) {
        $password = '';
        $upperLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowerLetters = 'abcdefghijklmnopqrstuvwxyz';
        $symbols = '!@#$%^&*.,:?(){}<>"';
        for($i = 0; $i < $length; $i++)
        { 
            if($upperCase)
            {
                $password .= Str::charAt($upperLetters, random_int(0, Str::length($upperLetters) - 1));
            }
            if($lowerCase)
            {
                $password .= Str::charAt($lowerLetters, random_int(0, Str::length($lowerLetters) - 1));
            }
            if($numbers)
            {
                $password .= random_int(0, 9);
            }
            if($symbols)
            {
                $password .= Str::charAt($symbols, random_int(0, Str::length($symbols) - 1));
            }
        }
        return str_shuffle(substr($password, 0, $length));
    }

    public function showViewNewAdmin()
    {
        return view('admin.new-admin');
    }

    public function createNewAdmin(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users|max:64',
            // 'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,:?(){}<>"])[A-Za-z\d!@#$%^&*.,:?(){}<>"]{8,10}$/|confirmed',
            'names' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:32',
            'first_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:16',
            'second_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:16',
        ];
        $messages = [
            'email.required' => 'Correo electrónico: Requerido.',
            'email.unique' => 'Correo electrónico: Ya registrado.',
            'email.email' => 'Correo electrónico: Inválido.',
            'email.max' => 'Correo electrónico: Muy largo.',
            // 'password.required' => 'Contraseña: Requerida.',
            // 'password.regex' => 'Contraseña: Debe tener al menos una letra minúscula, al menos una letra mayúscula, al menos un caracter especial, al menos un número y una longitud entre 8 y 10 caracteres.',
            // 'password.confirmed' => 'Contraseñas: No coinciden.',
            'names.required' => 'Nombre(s): Requerido(s).',
            'names.regex' => 'Nombre(s): Debe contener solo letras.',
            'names.max' => 'Nombre(s): Demasiado largo.',
            'first_surname.required' => 'Apellido paterno: Requerido.',
            'first_surname.regex' => 'Apellido paterno: Debe contener solo letras.',
            'first_surname.max' => 'Apellido paterno: Demasiado largo.',
            'second_surname.required' => 'Apellido materno: Requerido.',
            'second_surname.regex' => 'Apellido materno: Debe contener solo letras.',
            'second_surname.max' => 'Apellido materno: Demasiado largo.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            $names = $request->old('names');
            $first_surname = $request->old('first_surname');
            $second_surname = $request->old('second_surname');
            $email = $request->old('email');
            // $password = $request->old('password');
            return redirect()->route('new.admin')->withErrors($validator)->withInput();
        }
        $password = $this->generateRandomPassword();
        if(Str::length($password) == 8)
        {
            Mail::to(strtolower($request->email))->send(new PasswordAdminMail(ucwords($request->names . ' ' . $request->first_surname), $password));
            $profile = Profile::find(1);
            $user = new User([
                'email' => strtolower($request->email),
                // 'password' => $request->password,
                'password' => $password,
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
            broadcast(new SendNotifications('Se ha creado un nuevo administrador.'))->toOthers();
            return redirect()->route('new.admin')->with(['success' => true, 'email' => $request->email]);   
        } else {
            return redirect()->route('new.admin')->withErrors(['password_admin' => 'Ocurrió un error, intente de nuevo.']);
        }
    } 
}
