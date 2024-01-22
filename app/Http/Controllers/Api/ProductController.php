<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//! CONTROLADOR DE LOS PRODUCTOS

class ProductController extends Controller
{

    //!LISTA TODO LOS PRODUCTOS
    public function index()
    {
        try {
            $data = DB::table('products')
                ->select(
                    'products.id',
                    'id_category',
                    'nombrePro',
                    'codigoPro',
                    'descripPro',
                    'precioPro',
                    'stockPro',
                    'products.img',
                    'status',
                    'quantity',
                    'oferta',
                    'categorias',
                    'products.created_at',
                    'name',
                    'color'
                )
                ->join('category_products', 'category_products.id', '=', 'id_category')
                ->orderBy('products.id', 'desc')
                ->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    //? INSERTA LOS PRODUCTOS
    public function store(StoreProductRequest $request)
    {
        $products = new Product($request->validated());

        $image = $request->file('img');
        if ($image) {

            $nombreImagen = time() . '_' . $request->name . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/product'), $nombreImagen);

            $url = asset('img/product/' . $nombreImagen);
            $products->img = $url;
        }

        $products->save();

        return response()->json(['message' => 'success']);
    }
    //* LISTA UNO POR UNO
    public function show($id)
    {
        $product = Product::find($id);
        return $product;
    }
    //TODO: ACTUALIZA LOS PRODUCTOS
    public function update(StoreProductRequest $request, $id)
    {
        $product = Product::find($id);
        $image = $request->file('img');
        if ($image) {

            $nombreImagen = time() . '_' . $request->name . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/product'), $nombreImagen);

            $url = asset('img/product/' . $nombreImagen);
        } else {
            $url = $product->img;
        }

        $product->update(
            array_merge($request->validated(), ['img' => $url])
        );

        return response()->json(['message' => 'Actually']);
    }
    //! ELIMINA LOS PRODUCTOS

    public function destroy(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            $product->status = $request->status;
            $product->save();
            return response()->json(['message' => 'Update', 'data' => $product]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function listActiveProducts()
    {
        try {
            $data = DB::table('products')
                ->select('*')
                ->where('status', '=', '0')
                ->orderBy('id', 'desc')
                ->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function producOferta()
    {
        try {
            $data = DB::table('products')
                ->select('*')
                ->where('status', '=', '0')
                ->where('oferta', '=', '1')
                ->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function listCategoriPro($id)
    {
        try {
            $data = DB::table('products')
                ->select('*')
                ->where('id_category', '=', $id)
                ->where('status', '=', '0')
                ->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
