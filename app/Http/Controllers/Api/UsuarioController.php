<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioRequest;
use Illuminate\Http\Request;
use App\Models\Usuario;

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
}
