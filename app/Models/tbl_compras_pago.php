<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;

class tbl_compras_pago extends Model
{
    use HasFactory;
    use SoftDeletes, Uuids;

    protected $fillable = [
            'id_usuario_registro',
            'id_pago_metodo',
            'id_compra',
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
            'id_seguimiento_credito',
            'id_empresa',
    ];
}
