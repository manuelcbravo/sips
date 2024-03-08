<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;

class tbl_seguimiento extends Model
{
    use HasFactory;
    use SoftDeletes, Uuids;

    protected $fillable = [
        'id_lead',
        'fecha',
        'comentario',
        'id_cat_medio_contactos',
        'contesto',
        'fecha_seguimiento',
        'acuerdo',
        'id_usuario_reg',
        'id_llamada',
        'numero',
        'detalle_llamada'
        ];
}
