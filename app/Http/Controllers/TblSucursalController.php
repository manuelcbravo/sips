<?php

namespace App\Http\Controllers;

use App\Models\tbl_sucursal;
use App\Models\cat_cp;
use Illuminate\Http\Request;

use Auth;

class TblSucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.catalogos.sucursales.index', ['active' => 'sucursales']);
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
        }

        if($store['id_colonia'] != 0){ $store['colonia'] = NULL;}

        tbl_sucursal::updateOrCreate(['id' => $store['id'] ?? null], $store);

        return response()->json(
            [
                'respuesta' => true,
                'mensaje' => "Acción realizada correctamente",
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tbl_sucursal  $tbl_sucursal
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_sucursal $tbl_sucursal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_sucursal  $tbl_sucursal
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_sucursal $tbl_sucursal, $id , Request $request)
    {
        $data =tbl_sucursal::find($id);
        $colonias = cat_cp::where('cp',$data->cp)->get();

        return response()->json([
            'respuesta' => true,
            'posts' => $data,
            'colonias' => $colonias
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_sucursal  $tbl_sucursal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_sucursal $tbl_sucursal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_sucursal  $tbl_sucursal
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_sucursal $tbl_sucursal,$id)
    {
        $user = tbl_sucursal::withTrashed()->find($id);
        $user ->delete();
        \Notificaciones::agregarLog('Registro eliminado', $id, "tbl_empresas");

        return response()->json([
            'respuesta' => true,
        ], 200);
    }

    public function getsucursal(){

        $empresas = tbl_sucursal::selectRaw("tbl_sucursals.*, concat_ws(' ',users.name, users.apellidos) as encargado")->
        leftJoin('users','users.id','=','tbl_sucursals.id_encargado')->
        get();

        return response()->json([
            'data' => $empresas ?? []
        ]);
    }
}
