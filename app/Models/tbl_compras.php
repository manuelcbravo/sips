<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;

class tbl_compras extends Model
{
    use HasFactory;
    use Uuids;
    use SoftDeletes;

    protected $fillable = [
        'id_proveedor',
        'folio',
        'serie',
        'monto_total',
        'fecha_compra',
        'descripcion',
        'metodo_pago',
        'estado',
        'rfc_emisor',
        'nombre_emisor',
        'rfc_receptor',
        'nombre_receptor',
        'fecha_emision_factura',
        'moneda',
        'forma_pago',
        'condiciones_pago',
        'direccion_emisor',
        'direccion_receptor',
        'tipo_comprobante',
        'uso_cfdi',
        'regimen_fiscal_emisor',
        'nombre_archivo',
        'nombre_original',
        'direccion',
        'id_usuario_registro',
        'tipo_compra',
        'finalizado',
        'sub_total',
        'impuestos',
        'hora_emision_factura',
        'tipo_cambio',
        'fecha_vencimiento',
        'descuento'
    ];
}
