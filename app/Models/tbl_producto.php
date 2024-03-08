<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria

class tbl_producto extends Model
{
    use HasFactory;
    use SoftDeletes, Uuids;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'unidad_medida',
        'cantidad_disponible',
        'codigo_barras',
        'codigo_general'
    ];

}
