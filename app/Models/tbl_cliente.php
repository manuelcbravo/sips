<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;

class tbl_cliente extends Model
{
    use HasFactory;
    use SoftDeletes, Uuids;

    protected $fillable = [
        'id',
        'cliente',
        'alias',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'rfc',
        'id_regimen_fiscal',
        'id_cliente_tipo',
        'id_estatus',
        'id_uso_cfdi',
        'fecha_nacimiento',

        //direccion
       'id_estado',
        'otro_estado',
       'id_municipio',
        'otro_municipio',
       'id_colonia',
        'colonia',
        'calle',
        'interior',
        'exterior',
        'cp',

        //contacto
        'celular',
        'oficina',
        'casa',
        'email',
        'correo2',

        //datos tabla
        'credito',
        'dias',
        'precio',
        'saldo',
        //fin

        //datos extra
        'imagen_perfil',
        'id_usuario_reg',
        'comentario_registro',
        'comentario',
        'genero',
        'clasificacion_chalin',
        // fin

        //datos conexión inicio
        'ultimo_contacto',
        'email_verified_at',
        'password',
        'password_plain',
        'activado',
        'aval_activos',
        'creditos',
        'trabajos',
        'token_activation',
        'status_app',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'token_activation'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
