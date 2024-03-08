<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;

class tbl_inventario_movimiento extends Model
{
    use HasFactory;
    use SoftDeletes, Uuids;

    protected $fillable = [
        'id_sucursal',
        'id_sucursal_traspaso',
        'id_sucursal_almacen',
        'id_usuario_reg',
        'id_movimiento',
        'id_articulo',
        'entrada',
        'salida',
        'inv_inicial',
        'inv_final',
        'comentario',
    ];
}
