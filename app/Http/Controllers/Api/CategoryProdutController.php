<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryProductRequest;
use App\Models\categoryProduct;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryProdutController extends Controller
{
    public function index()
    {
        try {
            $category = categoryProduct::all();
            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function store(StoreCategoryProductRequest $request)
    {
        $category = new categoryProduct($request->validated());

        $image = $request->file('img');
        if ($image) {

            $nombreImagen = time() . '_' . $request->name . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/categoryProd'), $nombreImagen);

            $url = asset('img/categoryProd/' . $nombreImagen);
            $category->img = $url;
        }

        $category->save();

        return response()->json(['message' => 'success']);
    }
    public function show($id)
    {
        $category = categoryProduct::find($id);
        return $category;
    }

    public function update(StoreCategoryProductRequest $request, $id)
    {
        $category = categoryProduct::find($id);

        $image = $request->file('img');
        if ($image) {

            $nombreImagen = time() . '_' . $request->name . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/categoryProd'), $nombreImagen);

            $url = asset('img/categoryProd/' . $nombreImagen);
        } else {
            $url = $category->img;
        }

        $category->update(
            array_merge($request->validated(), ['img' => $url])
        );

        return response()->json(['message' => 'Actually']);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $category = categoryProduct::find($id);
            $category->state = $request->state;
            $category->save();
            return response()->json(['message' => 'Update', 'data' => $category]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function listActiveCategory()
    {
        try {
            $data = categoryProduct::where('state', 0)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('products')
                    ->whereColumn('category_products.id', 'products.id_category');
            })
            ->get();
        
            return response()->json($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
