<?php

namespace App\Http\Controllers\Api\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EmergencyContact;

class EmergencyContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $requests)
    {
        $rule = [
            'user_id' => 'required|integer'
        ];
        $message = [
            'user_id.required' => 'ID usuario: Requerido.',
            'user_id.integer' => 'ID usuario: Debe ser un número entero positivo.'
        ];
        $validator = Validator::make($requests->all(), $rule, $message);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrió un error de validación de datos.',
                'success' => true,
                'data' => null,
                'errors' => $validator->errors()
            ], 400);
        }
        $emergencyContacts = EmergencyContact::where('user_id', $requests->query('user_id'))->get();
        if($emergencyContacts->isEmpty())
        {
            return response()->json([
                'status' => 200,
                'message' => 'No se encontrarón contactos de emergencia.',
                'success' => true,
                'data' => null,
                'errors' => null
            ], 200);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Se encontrarón los siguientes contactos de emergencia.',
            'success' => true,
            'data' => $emergencyContacts,
            'errors' => null
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer',
            'names' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:32',
            'first_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:16',
            'second_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:16',
            'relationship' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:16',
            'address' => 'required|max:255',
            'phone' => 'required|regex:/^[0-9]+$/|min:10|max:10',
            'whatsapp' => 'required|regex:/^[0-9]+$/|min:10|max:10'
        ];
        $messages = [
            'user_id.required' => 'ID usuario: Requirido.',
            'user_id.integer' => 'ID usuario: Debe ser un número entero positivo.',
            'names.required' => 'Nombre(s): Requirido.',
            'names.regex' => 'Nombre(s): Debe contener solo letras.',
            'names.max' => 'Nombre(s): Demasiado largo.',
            'first_surname.required' => 'Apellido paterno: Requirido.',
            'first_surname.regex' => 'Apellido paterno: Debe contener solo letras.',
            'first_surname.max' => 'Apellido paterno: Demasiado largo.',
            'second_surname.required' => 'Apellido materno: Requirido.',
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
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrió un error en la validación de datos.',
                'success' => true,
                'data' => null,
                'errors' => $validator->errors()
            ], 400);
        }
        $createdEmergencyContact = EmergencyContact::create($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Creación exitosa de contacto de emergencia.',
            'success' => true,
            'data' => $createdEmergencyContact,
            'errors' => null
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $rules = [
            'names' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:32',
            'first_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:16',
            'second_surname' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:16',
            'relationship' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/|max:16',
            'address' => 'required|max:255',
            'phone' => 'required|regex:/^[0-9]+$/|min:10|max:10',
            'whatsapp' => 'required|regex:/^[0-9]+$/|min:10|max:10'
        ];
        $messages = [
            'names.required' => 'Nombre(s): Requirido.',
            'names.regex' => 'Nombre(s): Debe contener solo letras.',
            'names.max' => 'Nombre(s): Demasiado largo.',
            'first_surname.required' => 'Apellido paterno: Requirido.',
            'first_surname.regex' => 'Apellido paterno: Debe contener solo letras.',
            'first_surname.max' => 'Apellido paterno: Demasiado largo.',
            'second_surname.required' => 'Apellido materno: Requirido.',
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
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrió un error en la validación de datos.',
                'success' => true,
                'data' => null,
                'errors' => $validator->errors()
            ], 400);
        }
        $updatedEmergencyContact = EmergencyContact::where('id', $id)->update($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Actualización exitosa de contacto de emergencia.',
            'success' => true,
            'data' => $updatedEmergencyContact,
            'errors' => null
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $deletedEmergencyContact = EmergencyContact::findOrFail($id);
        $deletedEmergencyContact->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Eliminación exitosa de contacto de emergencia.',
            'success' => true,
            'data' => $deletedEmergencyContact,
            'errors' => null
        ], 200);
    }
}
