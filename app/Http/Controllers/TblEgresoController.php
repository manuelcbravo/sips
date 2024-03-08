<?php

namespace App\Http\Controllers;

use App\Models\tbl_egreso;
use App\Models\tbl_archivo;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\SecurityTrait;

use Auth;
use Str;
use Storage;

class TblEgresoController extends Controller
{
    use SecurityTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = [ 'egresos' => new tbl_egreso];
        return view('konfido.contabilidad.egresos.index', ['active' => 'egresos', 'inputs' => $this->encryptName($input,$request)]);
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
        $store = $this->decryptStore($request->except(['img_comprobantes','img_recibo']), $request);

        if (!$store['id']) {
            $store['id_usuario_registro'] = Auth::user()->id;
            $store['folio'] = tbl_egreso::max('folio')+1;
            $store['fecha_aplicacion'] = date_format(date_create_from_format('d/m/Y H:i', $store['fecha']), 'Y-m-d H:i');
            $store['fecha'] = date_format(date_create_from_format('d/m/Y H:i', $store['fecha']), 'Y-m-d H:i');
        }

        $egreso = tbl_egreso::updateOrCreate(['id' => $store['id'] ?? null], $store);

        if($request->img_comprobantes){
            $image = $request->img_comprobantes;
            $imageName = Str::uuid(). '.' . $image->extension();

            $img = tbl_archivo::create(['tabla' => 'tbl_egresos', 'id_asociado' => $egreso->id, 'nombre' => $imageName, 'nombre_original' => $image->getClientOriginalName(),
            'tamano' => $image->getSize(), 'tipo' => $image->extension(), 'direccion' => 'comprobantes/'.$imageName,
            'id_usuario_reg' => auth()->user()->id, 'id_cat_folder_personal' => 0]);

            Storage::disk('comprobantes')->put($imageName, file_get_contents($request->img_comprobantes));

            $store['img_comprobantes'] = 'comprobantes/'.$imageName;
            
            tbl_egreso::where('id',$egreso->id)->update(['img_comprobantes'=> $store['img_comprobantes']]); 
        }

        if($request->img_recibo){
            $image = $request->img_recibo;
            $imageName = Str::uuid(). '.' . $image->extension();

            $img = tbl_archivo::create(['tabla' => 'tbl_egresos', 'id_asociado' => $egreso->id, 'nombre' => $imageName, 'nombre_original' => $image->getClientOriginalName(),
            'tamano' => $image->getSize(), 'tipo' => $image->extension(), 'direccion' => 'recibos/'.$imageName,
            'id_usuario_reg' => auth()->user()->id, 'id_cat_folder_personal' => 0]);

            Storage::disk('recibos')->put($imageName, file_get_contents($request->img_recibo));

            $store['img_recibo'] = 'recibos/'.$imageName;
            tbl_egreso::where('id',$egreso->id)->update(['img_recibo'=>$store['img_recibo']]); 

        }

        return response()->json(
            [
                'respuesta' => true,
                'mensaje' => "Acción realizada correctamente"
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tbl_egreso  $tbl_egreso
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_egreso $tbl_egreso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_egreso  $tbl_egreso
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_egreso $tbl_egreso, $id, Request $request)
    {
        $show = $this->encryptShow(tbl_egreso::find($id), $request);

        return response()->json([
            'respuesta' => true,
            'posts' => $show,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_egreso  $tbl_egreso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_egreso $tbl_egreso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_egreso  $tbl_egreso
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_egreso $tbl_egreso, $id)
    {
        $pago = tbl_egreso::withTrashed()->find($id);
        $pago ->delete();

        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Registro eliminado correctamente',
        ], 200);
        //
    }

    public function getEgresos()
    {
        $egreso = tbl_egreso::selectRaw("tbl_egresos.*,
        cat_egresos.nombre as concepto, concat_ws(' ', users.name, users.apellidos) as registro,
        (select concat_ws(' ', a.name, a.apellidos) from users as a where tbl_egresos.id_usuario_firma =  a.id) as autorizo,
        cat_pagos_metodos.nombre as metodo")->
        join('cat_egresos','cat_egresos.id','=','tbl_egresos.id_pago_concepto')->
        join('cat_pagos_metodos','cat_pagos_metodos.id','=','tbl_egresos.id_pago_metodo')->
        join('users','users.id','=','tbl_egresos.id_usuario_registro')->
        latest()->withTrashed()->
        get();

        if($egreso) {
            return response()->json([
                'data' => $egreso ?? []
            ]);
        }
    }
}
