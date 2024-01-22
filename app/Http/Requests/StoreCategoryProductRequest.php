<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name'=>'required',
            'state'=>'required',
            'color'=>'required',
            'ico'=>'required',
            'img'=>'nullable|mimes:jpeg,png,jpg,gif,webp',
        ];
    }
}
