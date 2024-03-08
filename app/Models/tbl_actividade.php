<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;

class tbl_actividade extends Model
{
    use HasFactory;
    use SoftDeletes, Uuids;

    protected $fillable = [
        'id_lead',
        'id_asesor',
        'id_usuario_reg',
        'fecha_hora_inicio',
        'fecha_hora_fin',
        'instruccion',
        'id_actividad',
        'des_actividad',
        'finalizar',
        'id_tbl_seguimiento',
        'id_tbl_lugar',
        'otro_lugar',
        'id_usuario_asignado'
    ];
}
