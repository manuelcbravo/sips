<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;
class tbl_compras_detalle extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $fillable = [
       'id_compra',
        'cantidad',
        'unidad',
        'no_identificacion',
        'descripcion',
        'valor_unitario',
        'importe',
        'impuestos',
        'clave_prod_serv',
        'clave_unidad',
        'objeto_imp',
        'id_estatus',
        'cantidad_det'
    ];
}
