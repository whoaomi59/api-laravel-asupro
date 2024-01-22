<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioRequest;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $user = Usuario::all();
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $user = new Usuario();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = $request->role;
        $user->status = $request->status;
        // Guardar el usuario en la base de datos
        $user->save();

        // Devolver una respuesta JSON con un mensaje de éxito
        return response()->json(['message' => 'success']);
    }

    public function show($id)
    {
        $user = Usuario::find($id);
        return response()->json($user);
    }

    public function update(StoreUsuarioRequest $request, $id)
    {
        $usuario = Usuario::find($id);

        $image = $request->file('img');
        if ($image) {

            $nombreImagen = time() . '_' . $request->name . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/usuario'), $nombreImagen);

            $url = asset('img/usuario/' . $nombreImagen);
        } else {
            $url = $usuario->img;
        }

        $usuario->update(
            array_merge($request->validated(), ['img' => $url])
        );

        return response()->json(['message' => 'Actually']);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $usuario = Usuario::find($id);
            $usuario->status = $request->status;
            $usuario->save();
            return response()->json(['message' => 'Update', 'data' => $usuario]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    public function ValidateEmail(Request $request, $email)
    {
        try {
            // Buscar el usuario por correo electrónico
            $usuario = Usuario::where('email', $email)->first();

            // Si se encuentra el usuario, devolver el ID
            if ($usuario) {
                $id = $usuario->id;
                return response()->json([
                    'status' => 200,
                    'message' => 'Correo Encontrado.',
                    'data' => $id
                ], 200);
            }

            // Si el usuario no se encuentra
            return response()->json([
                'status' => 404,
                'message' => 'Correo no Encontrado.'
            ], 404);
        } catch (\Throwable $th) {
            // Error durante la validación del correo
            return response()->json([
                'status' => 500,
                'message' => 'Error al validar el correo: ' . $th->getMessage(),
            ], 500);
        }
    }


    public function UpdatePassword(Request $request, $id)
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                'password' => ['required', 'min:8',],
            ]);

            // Encontrar el usuario por ID
            $usuario = Usuario::find($id);

            // Si el usuario existe, actualizar la contraseña
            if ($usuario) {
                $usuario->password = Hash::make($request->password);
                $usuario->save();

                // Contraseña actualizada con éxito
                return response()->json([
                    'status' => 'success',
                    'message' => 'Se actualizó su contraseña con éxito.',
                    'user' => $usuario
                ], 200);
            }

            // Usuario no encontrado
            return response()->json([
                'status' => 'error',
                'message' => 'Usuario no encontrado.'
            ], 404);
        } catch (\Throwable $th) {
            // Error en la actualización de la contraseña
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar la contraseña: ' . $th->getMessage(),
            ], 500);
        }
    }
}
