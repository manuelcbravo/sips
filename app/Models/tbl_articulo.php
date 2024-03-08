<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;

class tbl_articulo extends Model
{
    use HasFactory;
    use SoftDeletes, Uuids;

    protected $fillable = [
        'articulo',
        'articulo_limpio',
            'id_linea',
            'id_marca',
           'id_clasificacion',
           'id_unidad_medida',
           'capacidad',
           'id_presentacion',
           'precio',
           'precio_prom_mes',
           'importacion',
           'descripcion',
           'ultima_venta',
           'sucursal',
           'venta_total',
           'venta_mes',
           'autocodigo',
           'ensanblado_en_linea',
        'clave_prodserv',
        'observacion',
        'imagen'
    ];
}
