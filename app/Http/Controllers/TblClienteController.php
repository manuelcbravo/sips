<?php

namespace App\Http\Controllers;

use App\Models\tbl_cliente;
use App\Models\tbl_seguimiento;
use App\Models\cat_cp;
use App\Models\tbl_venta;
use App\Models\tbl_cliente_trabajo;
use App\Models\tbl_user_clientes;
use Illuminate\Http\Request;
use App\Http\Mail\WelcomeEmail;
use App\Models\tbl_ahorro;
use App\Models\tbl_inversion;
use App\Models\tbl_credito;

use Auth;
use Illuminate\Support\Facades\Hash;
use Str;
use Storage;
use DB;

class TblClienteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view('pages.clientes.clientes.index', ['active' => 'clientes']);
    }

    public function index_perfil(Request $request, $id)
    {

        return view('pages.singles.perfil', ['active' => 'clientes', 'id' => $id]);
    }

    public function index_lista(Request $request)
    {

        return view('pages.clientes.lista_negra.index', ['active' => 'lista']);
    }

    public function getPerfil($id){
        $credito_solicitudes =tbl_credito::selectRaw("tbl_creditos.*, concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre,
        cat_credito_estatus.nombre as estatus, tbl_productos.nombre as producto")->
        join('tbl_clientes','tbl_clientes.id','=','tbl_creditos.id_cliente')->
        join('cat_credito_estatus','cat_credito_estatus.id','=','tbl_creditos.id_estatus')->
        join('tbl_productos','tbl_productos.id','=','tbl_creditos.id_producto')->
        whereIn('id_estatus',[1,3])->get();

        $creditos = tbl_credito::selectRaw("tbl_creditos.*, concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre,
        cat_credito_estatus.nombre as estatus, tbl_productos.nombre as producto")->
        join('tbl_clientes','tbl_clientes.id','=','tbl_creditos.id_cliente')->
        join('cat_credito_estatus','cat_credito_estatus.id','=','tbl_creditos.id_estatus')->
        join('tbl_productos','tbl_productos.id','=','tbl_creditos.id_producto')->
        whereIn('tbl_creditos.id_estatus',[2, 6, 5])->get();

        $inversion = tbl_inversion::selectRaw("tbl_inversions.*, concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre,
        tbl_inversion_tipos.nombre as ahorro_tipo, concat_ws(' ', users.name, users.apellidos) as asesor")->
        join('tbl_clientes','tbl_clientes.id','=','tbl_inversions.id_cliente')->
        join('tbl_inversion_tipos','tbl_inversion_tipos.id','=','tbl_inversions.id_producto')->
        join('users','users.id','=','tbl_inversions.id_usuario_registro')->
        latest()->
        get();

        $ahorro =tbl_ahorro::selectRaw("tbl_ahorros.*, concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre,
        tbl_ahorro_tipos.nombre as ahorro_tipo, tbl_ahorro_tipos.plazo as plazo, concat_ws(' ', users.name, users.apellidos) as asesor,
        (select count(id) from tbl_ahorro_fecha_pagos where tbl_ahorro_fecha_pagos.fecha_pago <= CURRENT_DATE and tbl_ahorro_fecha_pagos.id_credito = tbl_ahorros.id) as plazo_actual")->
        join('tbl_clientes','tbl_clientes.id','=','tbl_ahorros.id_cliente')->
        join('tbl_ahorro_tipos','tbl_ahorro_tipos.id','=','tbl_ahorros.id_producto')->
        join('users','users.id','=','tbl_ahorros.id_usuario_registro')->
        latest()->
        get();

        $cliente = tbl_credito::selectRaw("tbl_clientes.*,
        concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre_cliente,
        concat_ws(' ',tbl_clientes.nombre) as nombre_empresa,cat_estados.estado, cat_municipios.municipio,
        cat_cps.nombre as colonia")->
        leftJoin('cat_estados','cat_estados.id','=','tbl_clientes.id_domicilio_estado')->
        leftJoin('cat_municipios', function($join)
        {
            $join->on('tbl_clientes.id_domicilio_estado', '=', 'cat_municipios.id_estado');
            $join->on('tbl_clientes.id_domicilio_municipio','=','cat_municipios.id');
        })->
        leftJoin('cat_cps','cat_cps.id','=','tbl_clientes.id_colonia')->
        where('tbl_clientes.id',$id)->first();

        $trabajos = tbl_cliente_trabajo::selectRaw("tbl_clientes.*,
        concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre_cliente,
        concat_ws(' ',tbl_clientes.nombre) as nombre_empresa,cat_estados.estado, cat_municipios.municipio,
        cat_cps.nombre as colonia")->
        leftJoin('cat_estados','cat_estados.id','=','tbl_clientes.id_trabajo_estado')->
        leftJoin('cat_municipios', function($join)
        {
            $join->on('tbl_clientes.id_trabajo_estado', '=', 'cat_municipios.id_estado');
            $join->on('tbl_clientes.id_trabajo_municipio','=','cat_municipios.id');
        })->
        leftJoin('cat_cps','cat_cps.id','=','tbl_clientes.id_trabajo_colonia')->
        where('id_cliente', $id)->get();

        return response()->json([
            'cliente' => $cliente,
            'credito_solicitudes' => $credito_solicitudes,
            'creditos' => $creditos,
            'inversiones' => $inversion,
            'ahorros' => $ahorro,
            'trabajos' => $trabajos,
        ]);

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

        if(!$store['id']){
            $store['id_usuario_reg'] = Auth::id();
            $correo = tbl_cliente::where('email', $store['email'])->first();
        } else {
            $correo = tbl_cliente::where('email', $store['email'])->whereNotIn('id', [$store['id']])->first();
        }

        if($store['id_colonia'] != 0){ $store['colonia'] = NULL;}

        $store['email'] = strtolower($store['email']);
        $store['correo2'] = strtolower($store['correo2']);

        if($correo){
            return response()->json(
                [
                    'respuesta' => false,
                    'mensaje' => "Este correo fue asignado a otro cliente, es importante que ingrese un correo valido para dar seguimiento a sus productos.",
                    'titulo' => "Correo asignado a otro cliente"
                ]
            );
        }

        $cliente = tbl_cliente::updateOrCreate(['id' => $store['id'] ?? null], $store);

        return response()->json(
            [
                'respuesta' => true,
                'mensaje' => "Acción realizada correctamente"
            ]
        );
    }

    public function setImageProfile(Request $request){

        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = Str::uuid(). '.' . $image->extension();

            $lead = tbl_cliente::where('id',$request->id_image)->update(['imagen_perfil' => 'perfil/'.$imageName]);

            Storage::disk('perfil')->put($imageName, file_get_contents($request->file('file')));

            return response()->json([
                'respuesta' => true,
                'imagen' => 'perfil/'.$imageName
            ]);
        }

        return response()->json([
            'respuesta' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tbl_cliente  $tbl_cliente
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_cliente $tbl_cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_cliente  $tbl_cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_cliente $tbl_cliente,$id , Request $request)
    {
        $data =tbl_cliente::find($id);
        $show = $data;

        return response()->json([
            'respuesta' => true,
            'colonias' => cat_cp::where('cp',$data->cp)->orderBy('nombre','asc')->get(),
            'posts' => $show,
            'nombre' => $data->nombre.' '.$data->apellido_paterno.' '.$data->apellido_materno
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_cliente  $tbl_cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_cliente $tbl_cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_cliente  $tbl_cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_cliente $tbl_cliente, $id)
    {
        $user = tbl_cliente::withTrashed()->find($id);
        $user ->delete();
        \Notificaciones::agregarLog('Registro eliminado', $id, "tbl_leads");

        return response()->json([
            'respuesta' => true,
        ], 200);
    }

    public function getClientes(){

        $user = tbl_cliente::get();


        if($user) {

            return response()->json([
                'data' => $user
            ]);
        }

        return response()->json([
            'data' => [],
        ], 200);

    }

    public function getCLientesData($id){
        $credito_solicitudes =tbl_credito::selectRaw("tbl_creditos.*, concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre,
        cat_credito_estatus.nombre as estatus, tbl_productos.nombre as producto")->
        join('tbl_clientes','tbl_clientes.id','=','tbl_creditos.id_cliente')->
        join('cat_credito_estatus','cat_credito_estatus.id','=','tbl_creditos.id_estatus')->
        join('tbl_productos','tbl_productos.id','=','tbl_creditos.id_producto')->
        whereIn('tbl_clientes.id_estatus',[1,3])->get();

        $creditos = tbl_credito::selectRaw("tbl_creditos.*, concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre,
        cat_credito_estatus.nombre as estatus, tbl_productos.nombre as producto")->
        join('tbl_clientes','tbl_clientes.id','=','tbl_creditos.id_cliente')->
        join('cat_credito_estatus','cat_credito_estatus.id','=','tbl_creditos.id_estatus')->
        join('tbl_productos','tbl_productos.id','=','tbl_creditos.id_producto')->
        whereIn('tbl_creditos.id_estatus',[2, 6, 5])->get();

        $inversion = tbl_inversion::selectRaw("tbl_inversions.*, concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre,
        tbl_inversion_tipos.nombre as ahorro_tipo, concat_ws(' ', users.name, users.apellidos) as asesor")->
        join('tbl_clientes','tbl_clientes.id','=','tbl_inversions.id_cliente')->
        join('tbl_inversion_tipos','tbl_inversion_tipos.id','=','tbl_inversions.id_producto')->
        join('users','users.id','=','tbl_inversions.id_usuario_registro')->
        latest()->
        get();

        $ahorro =tbl_ahorro::selectRaw("tbl_ahorros.*, concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre,
        tbl_ahorro_tipos.nombre as ahorro_tipo, tbl_ahorro_tipos.plazo as plazo, concat_ws(' ', users.name, users.apellidos) as asesor,
        (select count(id) from tbl_ahorro_fecha_pagos where tbl_ahorro_fecha_pagos.fecha_pago <= CURRENT_DATE and tbl_ahorro_fecha_pagos.id_credito = tbl_ahorros.id) as plazo_actual")->
        join('tbl_clientes','tbl_clientes.id','=','tbl_ahorros.id_cliente')->
        join('tbl_ahorro_tipos','tbl_ahorro_tipos.id','=','tbl_ahorros.id_producto')->
        join('users','users.id','=','tbl_ahorros.id_usuario_registro')->
        latest()->
        get();

        $cliente = tbl_cliente::selectRaw("tbl_clientes.*,
        concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre_cliente,
        concat_ws(' ',tbl_clientes.nombre) as nombre_empresa,cat_estados.estado, cat_municipios.municipio,
        cat_cps.nombre as colonia")->
        leftJoin('cat_estados','cat_estados.id','=','tbl_clientes.id_domicilio_estado')->
        leftJoin('cat_municipios', function($join)
        {
            $join->on('tbl_clientes.id_domicilio_estado', '=', 'cat_municipios.id_estado');
            $join->on('tbl_clientes.id_domicilio_municipio','=','cat_municipios.id');
        })->
        leftJoin('cat_cps','cat_cps.id','=','tbl_clientes.id_colonia')->
        where('tbl_clientes.id',$id)->first();

        $trabajos = tbl_cliente_trabajo::selectRaw("tbl_cliente_trabajos.*,
        cat_estados.estado, cat_municipios.municipio,
        cat_cps.nombre as colonia")->
        leftJoin('cat_estados','cat_estados.id','=','tbl_cliente_trabajos.id_trabajo_estado')->
        leftJoin('cat_municipios', function($join)
        {
            $join->on('tbl_cliente_trabajos.id_trabajo_estado', '=', 'cat_municipios.id_estado');
            $join->on('tbl_cliente_trabajos.id_trabajo_municipio','=','cat_municipios.id');
        })->
        leftJoin('cat_cps','cat_cps.id','=','tbl_cliente_trabajos.id_trabajo_colonia')->
        where('tbl_cliente_trabajos.id_cliente', $id)->get();

        return response()->json([
            'cliente' => $cliente,
            'credito_solicitudes' => $credito_solicitudes,
            'creditos' => $creditos,
            'inversiones' => $inversion,
            'ahorros' => $ahorro,
            'trabajos' => $trabajos,
            'seguimiento' => $this->seguimiento_lista($id),

        ]);
    }

    private function seguimiento_lista($id){
        return tbl_seguimiento::selectRaw("tbl_seguimientos.*, concat_ws(' ', users.name, apellidos) as usuario, cat_medio_contactos.nombre as contacto")->where('id_lead',$id)->
        join('users','users.id','=','tbl_seguimientos.id_usuario_reg')->
        join('cat_medio_contactos','cat_medio_contactos.id','=','tbl_seguimientos.id_cat_medio_contactos')->
        orderBy('fecha','desc')->get();
    }

    public function getCliente($key){
        $data = $this -> searchCliente($key);

        return response()->json([
            'incomplete_results' => false,
            'items' => $data,
            'total_count' => 1
        ]);
    }

    private function searchCliente ($key){

        $client = tbl_cliente::selectRaw("id, concat_ws(' ', nombre, apellido_paterno, apellido_materno) as nombre, rfc")
            ->where('nombre', 'iLIKE', "%$key%")
            ->orWhere('apellido_paterno', 'iLIKE', "%$key%")
            ->orWhere('apellido_materno', 'iLIKE', "%$key%")
            ->orWhere('rfc', 'iLIKE', "%$key%")
            ->get();

        return $client;
    }

}
