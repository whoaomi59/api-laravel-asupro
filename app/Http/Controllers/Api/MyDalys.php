<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMyDalyRequest;
use App\Models\MyDaly;
use Illuminate\Http\Request;

class MyDalys extends Controller
{
    public function index()
    {
        try {
            $products = MyDaly::all();
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function store(StoreMyDalyRequest $request)
    {
        $products = new MyDaly($request->validated()); 

        $image = $request->file('img');
        if ($image) {

            $nombreImagen = time() . '_' . $request->name . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/mydaly'), $nombreImagen);

            $url = asset('img/mydaly/' . $nombreImagen);
            $products->img = $url;
        }

        $products->save();

        return response()->json(['message' => 'success']);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
