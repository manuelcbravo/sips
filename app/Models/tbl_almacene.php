<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria

use App\Http\Traits\Uuids;

class tbl_almacene extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'nombre',
        'direccion',
        'latitud',
        'longitud',
        'comentario',
        'id_sucursal',
        'id_encargado'
    ];
}
