<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;

class tbl_banco extends Model
{
    use HasFactory;

    use SoftDeletes, Uuids;

    protected $fillable = [
        'cuenta',
        'clve_interbancaria',
        'clve_swift',
        'nombre_titular',
        'institucion',
        'no_tarjeta',
        'moneda'
    ];
}
