<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;
    protected $fillable = ['user_venta', 'user_compra', 'direccion', 'user_telefono', 'tipo_servicio', 'Total_Pago', 'status_venta', 'img'];
}
