<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'idconductor',
        'idventa',
        'ubicacion',
        'estado'
    ];
}
