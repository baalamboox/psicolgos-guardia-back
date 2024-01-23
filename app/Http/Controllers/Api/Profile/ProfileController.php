<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::where('id', $id)->with('userPersonalData')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Datos relacionados con el usuario.',
            'success' => true,
            'data' => $user,
            'errors' => null
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $rule = [
            'id' => 'required|integer'
        ];
        $message = [
            'id.required' => 'ID usuario: Requerido.',
            'id.integer' => 'ID usuario: Debe ser un número entero positivo.'
        ];
        $validator = Validator::make(['id' => $id], $rule, $message);
        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'message' => 'Ocurrión un error en la validación de datos.',
                'success' => true,
                'data' => null,
                'errors' => $validator->errors()
            ], 400);
        }
        $deletedUser = User::findOrFail($id);
        $deletedUser->userPersonalData()->delete();
        $deletedUser->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Se ha eliminado exitosamente el usuario.',
            'success' => true,
            'data' => $deletedUser,
            'errors' => null
        ], 200);
    }
}
