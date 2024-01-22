<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMyDalyRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_product' => 'required',
            'Ven_usuario' => 'required',
            'Com_usuario' => 'required',
            'Dire_envio' => 'required',
            'Numero_telefono' => 'required',
            'Total_Pagos' => 'required',
            'TypeService' => 'required',
            'Codigo_ven' => 'required',
            'Codigo_pro' => 'required',
            'ico' => 'required',
            'img' => 'nullable',
        ];
    }
}
