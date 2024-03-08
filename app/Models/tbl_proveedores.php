<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;

class tbl_proveedores extends Model
{
    use HasFactory;
    use Uuids;

    protected $fillable = [
        'id',
        'proveedor',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'rfc',
        'id_regimen_fiscal',
        'id_cliente_tipo',
        'id_estatus',
        'fecha_nacimiento',
        'externo',

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
        // fin

        'rl_nombre',
        'rl_apellido_paterno',
        'rl_apellido_materno',
        'rl_email',
        'rl_rfc',
        'rl_celular',
        'rl_oficina',
        'rl_casa',
        'cuenta_principal',
        'cuenta_secundaria',

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
