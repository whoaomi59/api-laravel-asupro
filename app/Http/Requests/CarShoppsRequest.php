<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarShoppsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user'=>'required',
            'cantidad'=>'required',
            'idPro'=>'required',
            'nombre'=>'required',
            'img'=>'required',
            'precio'=>'required',
        ];
    }
}
