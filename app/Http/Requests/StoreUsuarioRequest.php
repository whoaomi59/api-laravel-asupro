<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required',
            'last_name'=>'nullable',
            'email'=>'required',
            'telefono'=>'nullable',
            'direccion'=>'nullable',
            'img'=>'nullable|mimes:png,jpeg,jpg,jfif,webp',
        ];
    }
}
