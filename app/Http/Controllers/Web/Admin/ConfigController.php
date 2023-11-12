<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserPersonalData;
use App\Models\UserLog;

class ConfigController extends Controller
{
    
    public function showViewConfig(Request $request)
    {
        $getUserData = User::where('id', $request->user()->id)->with('userPersonalData')->first();
        $data = [
            'profile_photo' => $getUserData->profile_photo,
            'names' => ucwords($getUserData->userPersonalData->names),
            'first_surname' => ucwords($getUserData->userPersonalData->first_surname),
            'second_surname' => ucwords($getUserData->userPersonalData->second_surname),
            'email' => $getUserData->email,
            'phone' => $getUserData->userPersonalData->phone
        ];
        return view('admin.config', $data);
    }

    public function updateProfilePhoto(Request $request)
    {
        $rule = [
            'profile_photo' => 'required|mimes:jpeg,jpg,png|max:2048'
        ];
        $messages = [
            'profile_photo.required' => 'Foto de perfil requerida.',
            'profile_photo.mimes' => 'Foto de perfil solo puede ser de tipo: JPG, PNG ó JPEG.',
            'profile_photo.max' => 'Foto de perfil no debe pesar más de 2 MB.',
        ];
        $validator = Validator::make($request->only('profile_photo'), $rule, $messages);
        if($validator->fails())
        {
            return redirect()->route('config')->withErrors($validator)->withInput();
        }
        if(!$request->hasFile('profile_photo'))
        {
            return redirect()->route('config')->withErrors(['profile_photo' => 'Foto de perfil no existe.'])->withInput();
        }
        $profile_photo = $request->file('profile_photo');
        $user = User::find($request->user()->id);
        $user->profile_photo = 'img/profiles/admins/' . $profile_photo->storeAs($request->user()->email, strtolower(str_replace(' ', '', $profile_photo->getClientOriginalName())), 'admins');
        $user->save();
        UserLog::create([
            'user_id' => $request->user()->id,
            'action' => 'actualización de foto de perfil',
            'details' => 'actualizó foto de perfil correctamente'
        ]);
        return redirect()->route('config')->with('success', 'Actualizó foto de perfil.');
    }

    public function updatePersonalContactData(Request $request)
    {
        $rules = [
            'names' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:32',
            'first_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:16',
            'second_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:16',
            'phone' => 'required|digits:10'
        ];
        $messages = [
            'names.required' => 'Nombre(s) requerido(s).',
            'names.regex' => 'Nombre(s) debe contener solo letras.',
            'names.max' => 'Nombre(s) demasiado largo.',
            'first_surname.required' => 'Apellido paterno requerido.',
            'first_surname.regex' => 'Apellido paterno debe contener solo letras.',
            'first_surname.max' => 'Apellido paterno demasiado largo.',
            'second_surname.required' => 'Apellido materno requerido.',
            'second_surname.regex' => 'Apellido materno debe contener solo letras.',
            'second_surname.max' => 'Apellido materno demasiado largo.',
            'phone.required' => 'Teléfono requerido.',
            'phone.digits' => 'Teléfono invalido.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect()->route('config')->withErrors($validator)->withInput();
        }
        UserPersonalData::where('user_id', $request->user()->id)->update([
            'names' => strtolower($request->names),
            'first_surname' => strtolower($request->first_surname),
            'second_surname' => strtolower($request->second_surname),
            'phone' => $request->phone
        ]);
        UserLog::create([
            'user_id' => $request->user()->id,
            'action' => 'actualización de datos personales',
            'details' => 'actualizó datos personales correctamente'
        ]);
        return redirect()->route('config')->with('success', 'Datos actualizados.');
    }
    public function updatePassword(Request $request)
    {
        $rule = [
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,:?(){}<>"])[A-Za-z\d!@#$%^&*.,:?(){}<>"]{8,10}$/|confirmed',
        ];
        $messages = [
            'password.required' => 'Contraseña requerida.',
            'password.regex' => 'Contraseña debe tener al menos una letra minúscula, al menos una letra mayúscula, al menos un caracter especial, al menos un número y una longitud entre 8 y 10 caracteres.',
            'password.confirmed' => 'Contraseñas no coinciden.'
        ];
        $validator = Validator::make($request->all(), $rule, $messages);
        if($validator->fails())
        {
            $password = $request->old('password');
            $password_confirmation = $request->old('password_confirmation');
            return redirect()->route('config')->withErrors($validator)->withInput();
        }
        User::where('id', $request->user()->id)->update([
            'password' => Hash::make($request->password)
        ]);
        UserLog::create([
            'user_id' => $request->user()->id,
            'action' => 'actualización de contraseña',
            'details' => 'actualizó contraseña correctamente'
        ]);
        return redirect()->route('config')->with('success', 'Contraseña actualizada.');
    }
}
