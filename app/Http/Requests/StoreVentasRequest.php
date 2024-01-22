<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentasRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'user_venta'=>'required',
            'user_compra'=>'required',
            'direccion'=>'required',
            'user_telefono'=>'required',
            'tipo_servicio'=>'required',
            'img'=>'nullable|mimes:png,jpeg,jpg,jfif,webp',
        ];
    }
}

