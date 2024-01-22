<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarShoppsRequest;
use App\Models\carShopp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarShoppsController extends Controller
{

    public function index($user)
    {
        try {
              $data = DB::table('car_shopps')
                ->select('*')
                ->where('user', '=', $user)
                ->get();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(CarShoppsRequest $request)
    {
        try {
            $shopps = new carShopp($request->validated());

            $shopps->save();

            return response()->json(['message' => 'success', 'data' => $shopps]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function show($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        try {
            $ventas = carShopp::find($id);
            $ventas->cantidad = $request->cantidad;
            $ventas->save();
            return response()->json(['message' => 'Update', 'data' => $ventas]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function destroy($id)
    {
        //
    }
}
