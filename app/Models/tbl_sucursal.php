<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria

class tbl_sucursal extends Model
{
    use HasFactory;
    use SoftDeletes, Uuids;

    protected $fillable = [
        'nombre',
        'id_estado',
        'id_municipio',
        'id_encargado',
        'id_usuario_reg',
        'calle',
        'interior',
        'exterior',
        'cp',
        'latitud',
        'longitud',
        'comentario',
        'prefijo',
        'id_colonia',
        'colonia'
    ];
}
