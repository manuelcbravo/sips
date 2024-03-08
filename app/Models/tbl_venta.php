<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;

class tbl_venta extends Model
{
    use HasFactory;
    use SoftDeletes, Uuids;

    protected $fillable = [
        'id',
        'sucursal',
        'id_usuario_reg',
        'id_cliente',
        'fecha_venta',
        'total',
        'impuestos',
        'descuento',
        'descuento_por',
        'ticket',
        'id_estatus',
        'seudonimo',
        'facturable',
        'num_productos'
    ];
}
