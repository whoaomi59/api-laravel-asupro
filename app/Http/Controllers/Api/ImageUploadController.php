<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{

    public function upload(Request $request)
    {
        // Valida que se haya enviado un archivo de imagen
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajusta las reglas según tus necesidades
        ]);
        // Obtiene el archivo de imagen
        $image = $request->file('image');

        // Obtiene el nombre enviado desde React
        $nombre = $request->input('nombre'); // Asegúrate de que 'nombre' coincida con el nombre que estás enviando desde React

        //RUTA DONDE SE ALMACENA LAS IMG
        $routes = $request->input('route');
        // Genera un nombre único para la imagen (puedes personalizar esto según tus necesidades)
        $nombreImagen = time() . '_' . $nombre . '.' . $image->getClientOriginalExtension();

        // Guarda la imagen en una ubicación específica (por ejemplo, storage/app/public)
        $path  = $image->move(public_path('img/' . $routes), $nombreImagen);

        // Devuelve la URL pública de la imagen
        $url = asset('img/' . $routes . '/' . $nombreImagen);

        return response()->json(['url' => $url, 'data' => $path]);
    }
}
