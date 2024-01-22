<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carShopp extends Model
{
    use HasFactory;
    protected $fillable = ['name','user','cantidad','idPro','img','precio','nombre'];
}
