<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;

class tbl_egreso extends Model
{
    use HasFactory;
    use SoftDeletes, Uuids;

    protected $fillable = [
        'id_usuario_firma',
        'id_usuario_registro',
        'id_banco',
        'id_pago_metodo',
        'id_pago_concepto',
        'folio',
        'cantidad', 
        'clave_rastreo',
        'comentario',
        'efectivo', 
        'banco', 
        'fecha',
        'fecha_aplicacion',
        'img_recibo',
        'img_comprobantes',
    ];
}
