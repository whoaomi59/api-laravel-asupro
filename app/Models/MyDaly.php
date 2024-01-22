<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyDaly extends Model
{
    use HasFactory;
    protected $fillable = ['id_product','Ven_usuario','Numero_telefono','Total_Pagos','Dire_envio','Com_usuario','TypeService','Codigo_ven','Codigo_pro','img'];
}