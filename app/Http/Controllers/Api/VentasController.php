<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVentasRequest;
use App\Models\Product;
use App\Models\VentaProductos;
use App\Models\Ventas as ModelVentas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentasController extends Controller
{
    public function index()
    {
        try {
            $data = DB::table('ventas')
                ->select('*')
                ->orderBy('id', 'desc')
                ->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function store(StoreVentasRequest $request)
    {

        DB::beginTransaction();

        try {
            $ventas = ModelVentas::create($request->validated());

            $image = $request->file('img');
            if ($image) {

                $nombreImagen = time() . '_' . $request->name . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img/product'), $nombreImagen);

                $url = asset('img/product/' . $nombreImagen);
                $ventas->img = $url;
            }

            $total_venta = 0;
            foreach ($request->productos as  $value) {
                $producto = Product::find($value['id']);
                $total_venta += $producto->precioPro * $value['cantidad'];
                VentaProductos::create([
                    'venta_id' => $ventas->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $value['cantidad'],
                    'precio' => $producto->precioPro
                ]);
                $producto->stockPro -= $value['cantidad'];
                $producto->save();
            }
            $ventas->Total_Pago = $total_venta;
            $ventas->save();

            DB::commit();
            return response()->json(['message' => 'success', 'data' => $ventas]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function show($user)
    {
        try {
            $data = DB::table('ventas')
                ->select('id', 'user_venta', 'user_compra', 'tipo_servicio', 'Total_Pago', 'status_venta', 'created_at')
                ->where('user_compra', '=', $user)
                ->orderBy('id', 'desc')
                ->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $ventas = ModelVentas::find($id);
            $ventas->status_venta = $request->status_venta;
            $ventas->save();
            return response()->json(['message' => 'Update', 'data' => $ventas]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    public function listOneVenta($id)
    {
        $ventas = ModelVentas::find($id);
        return response()->json($ventas);
    }
    public function listAllventasStatus($id)
    {
        try {
            $data = DB::table('ventas')
                ->select('*')
                ->where('status_venta', '=', $id)
                ->orderBy('id', 'desc')
                ->limit('1')
                ->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
