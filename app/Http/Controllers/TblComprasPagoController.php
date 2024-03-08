<?php

namespace App\Http\Controllers;

use App\Models\tbl_compras_pago;
use Illuminate\Http\Request;
use App\Models\tbl_archivo;
use App\Models\tbl_compras;
use App\Models\tbl_proveedores;

use Auth;
use Str;
use Storage;
use DateTime;
use DB;

class TblComprasPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = $request->all();
        $store['id_usuario_registro'] = Auth::user()->id;

        if($request->img_comprobantes){
            $image = $request->img_comprobantes;
            $imageName = Str::uuid(). '.' . $image->extension();

            $img = tbl_archivo::create(['tabla' => 'tbl_compras_pago', 'id_asociado' => $store['id_compra'], 'nombre' => $imageName, 'nombre_original' => $image->getClientOriginalName(),
            'tamano' => $image->getSize(), 'tipo' => $image->extension(), 'direccion' => 'comprobantes/'.$imageName,
            'id_usuario_reg' => auth()->user()->id, 'id_cat_folder_personal' => 0]);

            Storage::disk('comprobantes')->put($imageName, file_get_contents($request->img_comprobantes));

            $store['img_comprobantes'] = 'comprobantes/'.$imageName;
        }

        if($request->img_recibo){
            $image = $request->img_recibo;
            $imageName = Str::uuid(). '.' . $image->extension();

            $img = tbl_archivo::create(['tabla' => 'tbl_compras_pago', 'id_asociado' => $store['id_compra'], 'nombre' => $imageName, 'nombre_original' => $image->getClientOriginalName(),
            'tamano' => $image->getSize(), 'tipo' => $image->extension(), 'direccion' => 'recibos/'.$imageName,
            'id_usuario_reg' => auth()->user()->id, 'id_cat_folder_personal' => 0]);

            Storage::disk('recibos')->put($imageName, file_get_contents($request->img_recibo));

            $store['img_recibo'] = 'recibos/'.$imageName;
        }
        
        $pago = tbl_compras_pago::updateOrCreate(['id' => $store['id'] ?? null], $store);

        return response()->json(
            [
                'respuesta' => true,
                'mensaje' => "Acción realizada correctamente",
                'pagos' => $this->pagos($store['id_compra'])
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tbl_compras_pago  $tbl_compras_pago
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_compras_pago $tbl_compras_pago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_compras_pago  $tbl_compras_pago
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_compras_pago $tbl_compras_pago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_compras_pago  $tbl_compras_pago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_compras_pago $tbl_compras_pago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_compras_pago  $tbl_compras_pago
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_compras_pago $tbl_compras_pago)
    {
        //
    }

    public function getPagos($id){
        $seguimiento = $this->pagos($id);
        $compra = tbl_compras::find($id);
        $proveedor = tbl_proveedores::find($compra->id_proveedor);

        return response()->json([
            'respuesta' => true,
            'pagos' => $seguimiento,
            'nombre' => $proveedor->nombre,
        ], 200);
    }

    private function pagos($id){

        return tbl_compras_pago::selectRaw("tbl_compras_pagos.id,  tbl_compras_pagos.folio,  tbl_compras_pagos.cantidad,  tbl_compras_pagos.fecha, tbl_compras_pagos.comentario, 
        tbl_compras_pagos.img_comprobantes, tbl_compras_pagos.img_recibo, cat_pagos_metodos.nombre as metodo")->
        leftJoin('cat_pagos_metodos', 'tbl_compras_pagos.id_pago_metodo', '=', 'cat_pagos_metodos.id')->
        where('id_compra',$id)->get();

    }
}
