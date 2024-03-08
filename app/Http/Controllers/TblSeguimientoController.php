<?php

namespace App\Http\Controllers;

use App\Models\tbl_seguimiento;
use App\Models\tbl_cliente;
use App\Models\tbl_actividade;
use App\Models\tbl_proveedores;
use App\Models\tbl_oportunidade;
use Illuminate\Http\Request;
use App\Http\Traits\SecurityTrait;

use Auth;

class TblSeguimientoController extends Controller
{
    use SecurityTrait;

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
        $oport = false;
        if($request->id_oportunidad){
            $oport = $request->id_oportunidad;
        }

        $request = $request->except('id_oportunidad'); 
        
        // $request['fecha'] = date("d/m/Y H:i", strtotime($request['fecha']));
        $request['fecha'] = date_format(date_create_from_format('d/m/Y H:i', $request['fecha']), 'Y-m-d H:i');

        if (!$request['id']) {
            $request['id_usuario_reg'] = Auth::user()->id;
        }

        if($request['fecha_seguimiento']){
            $request['fecha_seguimiento'] = date_format(date_create_from_format('d/m/Y H:i', $request['fecha_seguimiento']), 'Y-m-d H:i');
        }

        $id = tbl_seguimiento::updateOrCreate(['id' => $request['id'] ?? null], $request);

        tbl_cliente::where('id', $request['id_lead'] )->update(['ultimo_contacto'=>$request['fecha']]);

        if($oport){
            $oportunidad = tbl_oportunidade::find($oport);
            if($oportunidad->id_cat_estatus_oportunidades == 1 || $oportunidad->id_cat_estatus_oportunidades == 9 ){
                tbl_oportunidade::where('id',$oport)->update(['id_cat_estatus_oportunidades'=> 2]);
            }
        }

        \Notificaciones::agregarLog("Seguimiento registrado", $id->id,"tbl_seguimientos");

        if($request['fecha_seguimiento'] != NULL){
            $act = ['id_lead' => $request['id_lead'],
                'id_asesor' => Auth::user()->id,
                'id_usuario_reg' => Auth::user()->id,
                'id_usuario_asignado' => Auth::user()->id,
                'fecha_hora_inicio' => $request['fecha_seguimiento'],
                'fecha_hora_fin' => $request['fecha_seguimiento'],
                'id_tbl_seguimiento' => $id->id,
                'id_actividad' => 1,
                'des_actividad'=> 'PRÓXIMO CONTACTO: '.$request['acuerdo']];

            $id_act = tbl_actividade::create($act)->id;

            \Notificaciones::agregarLog("Actividad agendada", $id_act, "tbl_actividades");
        }


        return response()->json(
            [
                'respuesta' => true,
                'mensaje' => "Seguimiento realizado correctamente",
                'seguimiento' =>  $this->seguimiento_lista($id -> id_lead),
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tbl_seguimiento  $tbl_seguimiento
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_seguimiento $tbl_seguimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_seguimiento  $tbl_seguimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_seguimiento $tbl_seguimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_seguimiento  $tbl_seguimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_seguimiento $tbl_seguimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_seguimiento  $tbl_seguimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_seguimiento $tbl_seguimiento)
    {
        //
    }

    public function getSeguimiento($id,$table){
        $nombre = ('\App\\Models\\'.$table)::find($id);

        return response()->json([
            'respuesta' => true,
            'seguimiento' => $this->seguimiento_lista($id),
            'nombre' => $nombre->nombre. ' '.  $nombre->apellido_paterno. ' '.  $nombre->apellido_materno
        ], 200);
    }

    private function seguimiento_lista($id){
        return tbl_seguimiento::selectRaw("tbl_seguimientos.*, concat_ws(' ', users.name, apellidos) as usuario, cat_medio_contactos.nombre as contacto")->where('id_lead',$id)->
        join('users','users.id','=','tbl_seguimientos.id_usuario_reg')->
        join('cat_medio_contactos','cat_medio_contactos.id','=','tbl_seguimientos.id_cat_medio_contactos')->
        orderBy('fecha','desc')->get();
    }
}
