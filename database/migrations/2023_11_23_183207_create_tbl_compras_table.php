<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\Uuids;

class CreateTblComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_compras', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_proveedor');
            $table->uuid('id_usuario_registro')->nullable('');
            $table->string('folio')->nullable();
            $table->string('serie')->nullable();
            $table->decimal('monto_total', 15, 2)->nullable();
            $table->decimal('sub_total', 15, 2)->nullable();
            $table->decimal('impuestos', 15, 2)->nullable();
            $table->decimal('descuento', 15, 2)->nullable();
            $table->dateTime('fecha_compra')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('metodo_pago')->nullable();
            $table->string('estado')->default('pendiente'); // Puede ser 'pendiente', 'pagada', etc.

            // Detalles de la factura
            $table->integer('tipo_compra')->comment('1 xml, 2 a mano');
            $table->integer('finalizado')->default(0);
            $table->string('rfc_emisor')->nullable();
            $table->string('nombre_emisor')->nullable();
            $table->string('rfc_receptor')->nullable();
            $table->string('nombre_receptor')->nullable();
            $table->date('fecha_emision_factura')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->time('hora_emision_factura')->nullable();
            $table->string('moneda')->nullable();
            $table->string('condiciones_pago')->nullable();
            $table->string('nombre_archivo')->nullable();
            $table->string('nombre_original')->nullable();
            $table->string('direccion')->nullable();
            $table->integer('tipo_cambio')->default(1);

            // Direcciones
            $table->string('direccion_emisor')->nullable();

            // Otros detalles
            $table->string('tipo_comprobante')->nullable();
            $table->string('uso_cfdi')->nullable();
            $table->string('regimen_fiscal_emisor')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_compras');
    }
}
