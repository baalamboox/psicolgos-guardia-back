<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\EmergencyContact;

class EmergencyContactController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->profile_id == 2)
        {
            $user = User::findOrFail(auth()->user()->id);
            $emergencyContacts = $user->emergencyContact;
            if($emergencyContacts->isEmpty())
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'No se encontrarón contactos de emergencia.',
                    'success' => false,
                    'data' => null,
                    'errors' => null
                ], 400);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Se encontrarón los siguientes contactos de emergencia.',
                    'success' => true,
                    'data' => $emergencyContacts,
                    'errors' => null
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Usuario inválido.',
                'success' => false,
                'data' => null,
                'errors' => ['ID perfil:' => 'No corresponde a un perfil de paciente.']
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'names' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:32',
            'first_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:16',
            'second_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:16',
            'relationship' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:16',
            'address' => 'required|max:255',
            'phone' => 'required|regex:/^[0-9]+$/|min:10|max:10',
            'whatsapp' => 'required|regex:/^[0-9]+$/|min:10|max:10'
        ];
        $messages = [
            'names.required' => 'Nombre(s): Requerido.',
            'names.regex' => 'Nombre(s): Debe contener solo letras.',
            'names.max' => 'Nombre(s): Demasiado largo.',
            'first_surname.required' => 'Apellido paterno: Requerido.',
            'first_surname.regex' => 'Apellido paterno: Debe contener solo letras.',
            'first_surname.max' => 'Apellido paterno: Demasiado largo.',
            'second_surname.required' => 'Apellido materno: Requerido.',
            'second_surname.regex' => 'Apellido materno: Debe contener solo letras.',
            'second_surname.max' => 'Apellido materno: Demasiado largo.',
            'relationship.required' => 'Parentesto: Requerido.',
            'relationship.regex' => 'Parentesco: Debe contener solo letras.',
            'relationship.max' => 'Parentesco: Demasiado largo.',
            'address.required' => 'Dirección: Requerida.',
            'address.max' => 'Dirección: Demasiada larga.',
            'phone.required' => 'Teléfono: Requerido.',
            'phone.regex' => 'Teléfono: Debe tener solo digitos.',
            'phone.min' => 'Teléfono: Debe tener al menos 10 digitos.',
            'phone.max' => 'Teléfono: Debe tener máximo 10 digitos.',
            'whatsapp.required' => 'WhatsApp: Requerido.',
            'whatsapp.regex' => 'WhatsApp: Debe tener solo digitos.',
            'whatsapp.min' => 'WhatsApp: Debe tener al menos 10 digitos.',
            'whatsapp.max' => 'Teléfono: Debe tener máximo 10 digitos.',
        ];
        if(auth()->user()->profile_id == 2)
        {
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails())
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'Ocurrió un error en la validación de datos.',
                    'success' => false,
                    'data' => null,
                    'errors' => $validator->errors()
                ], 400);
            } else {
                $user = User::findOrFail(auth()->user()->id);
                $createdEmergencyContact = new EmergencyContact($request->all());
                $user->emergencyContact()->save($createdEmergencyContact);
                return response()->json([
                    'status' => 200,
                    'message' => 'Creación exitosa del contacto de emergencia.',
                    'success' => true,
                    'data' => $createdEmergencyContact,
                    'errors' => null
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Usuario inválido.',
                'success' => false,
                'data' => null,
                'errors' => ['ID perfil:' => 'No corresponde a un perfil de paciente.']
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        if(auth()->user()->profile_id == 2)
        {
            $user = User::findOrFail(auth()->user()->id);
            $emergencyContact = $user->emergencyContact->where('id', $id);
            if($emergencyContact->isEmpty())
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'Ocurrió un error al mostrar el contacto de emergencia.',
                    'success' => false,
                    'data' => null,
                    'errors' => ['ID' => 'No existe ó ha sido eliminado.']
                ], 400);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Se encontró el contacto de emergencia.',
                    'success' => true,
                    'data' => $emergencyContact,
                    'errors' => null
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Usuario inválido.',
                'success' => false,
                'data' => null,
                'errors' => ['ID perfil:' => 'No corresponde a un perfil de paciente.']
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $rules = [
            'names' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:32',
            'first_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:16',
            'second_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:16',
            'relationship' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:16',
            'address' => 'required|max:255',
            'phone' => 'required|regex:/^[0-9]+$/|min:10|max:10',
            'whatsapp' => 'required|regex:/^[0-9]+$/|min:10|max:10'
        ];
        $messages = [
            'names.required' => 'Nombre(s): Requerido.',
            'names.regex' => 'Nombre(s): Debe contener solo letras.',
            'names.max' => 'Nombre(s): Demasiado largo.',
            'first_surname.required' => 'Apellido paterno: Requerido.',
            'first_surname.regex' => 'Apellido paterno: Debe contener solo letras.',
            'first_surname.max' => 'Apellido paterno: Demasiado largo.',
            'second_surname.required' => 'Apellido materno: Requerido.',
            'second_surname.regex' => 'Apellido materno: Debe contener solo letras.',
            'second_surname.max' => 'Apellido materno: Demasiado largo.',
            'relationship.required' => 'Parentesto: Requerido.',
            'relationship.regex' => 'Parentesco: Debe contener solo letras.',
            'relationship.max' => 'Parentesco: Demasiado largo.',
            'address.required' => 'Dirección: Requerida.',
            'address.max' => 'Dirección: Demasiada larga.',
            'phone.required' => 'Teléfono: Requerido.',
            'phone.regex' => 'Teléfono: Debe tener solo digitos.',
            'phone.min' => 'Teléfono: Debe tener al menos 10 digitos.',
            'phone.max' => 'Teléfono: Debe tener máximo 10 digitos.',
            'whatsapp.required' => 'WhatsApp: Requerido.',
            'whatsapp.regex' => 'WhatsApp: Debe tener solo digitos.',
            'whatsapp.min' => 'WhatsApp: Debe tener al menos 10 digitos.',
            'whatsapp.max' => 'Teléfono: Debe tener máximo 10 digitos.',
        ];
        if(auth()->user()->profile_id == 2)
        {
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails())
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'Ocurrió un error en la validación de datos.',
                    'success' => false,
                    'data' => null,
                    'errors' => $validator->errors()
                ], 400);
            } else {
                $user = User::findOrFail(auth()->user()->id);
                $emergencyContact = $user->emergencyContact->where('id', $id);
                if($emergencyContact->isEmpty())
                {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Ocurrió un error al actualizar el contacto de emergencia.',
                        'success' => false,
                        'data' => null,
                        'errors' => ['ID' => 'No existe ó ha sido eliminado.']
                    ], 400);
                } else {
                    $updatedEmergencyContact = EmergencyContact::where('id', $id)->where('user_id', auth()->user()->id)->update($request->all());
                    return response()->json([
                        'status' => 200,
                        'message' => 'Actualización exitosa del contacto de emergencia.',
                        'success' => true,
                        'data' => null,
                        'errors' => null
                    ], 200);
                }
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Usuario inválido.',
                'success' => false,
                'data' => null,
                'errors' => ['ID perfil:' => 'No corresponde a un perfil de paciente.']
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if(auth()->user()->profile_id == 2)
        {
            $user = User::findOrFail(auth()->user()->id);
            $emergencyContact = $user->emergencyContact->where('id', $id);
            if($emergencyContact->isEmpty())
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'Ocurrió un error al eliminar el contacto de emergencia.',
                    'success' => false,
                    'data' => null,
                    'errors' => ['ID' => 'No existe ó ya ha sido eliminado.']
                ], 400);
            } else {
                $deletedEmergencyContact = EmergencyContact::where('id', $id)->where('user_id', auth()->user()->id)->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Eliminación exitosa del contacto de emergencia.',
                    'success' => true,
                    'data' => null,
                    'errors' => null
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Usuario inválido.',
                'success' => false,
                'data' => null,
                'errors' => ['ID perfil:' => 'No corresponde a un perfil de paciente.']
            ], 400);
        }
    }
}
