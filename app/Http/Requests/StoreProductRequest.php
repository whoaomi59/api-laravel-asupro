<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'id_category' => 'required',
            'nombrePro' => 'required',
            'codigoPro' => 'required',
            'descripPro' => 'required',
            'precioPro' => 'required',
            'stockPro' => 'required',
            'categorias' => 'required',
            'img' => 'nullable|mimes:png,jpeg,jpg,jfif,webp',
        ];
    }
}
