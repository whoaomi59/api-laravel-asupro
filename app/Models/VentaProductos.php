<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VentaProductos extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['venta_id', 'producto_id', 'cantidad', 'precio'];
}
