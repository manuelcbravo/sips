<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;

class Empresa extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'nombre',
        'rfc',
        'calle',
        'cp',
        'colonia',
        'estado',
        'localidad',
        'municipio',
        'numeroExterior',
        'numeroInterior',
        'mail',
        'regimenfiscal',

        'certificado',
        'archivokey',
        'clave',
        'serie',
        'llaveprivada',
        'tipoFactura',
        'almacen',
        'latitud',
        'longitud',
    ];
}
