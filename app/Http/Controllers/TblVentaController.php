<?php

namespace App\Http\Controllers;

use App\Models\tbl_venta;
use Illuminate\Http\Request;

class TblVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.ventas.ventas.index', ['active' => 'ventas']);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tbl_venta  $tbl_venta
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_venta $tbl_venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_venta  $tbl_venta
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_venta $tbl_venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_venta  $tbl_venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_venta $tbl_venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_venta  $tbl_venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_venta $tbl_venta)
    {
        //
    }

    public function getVentas(){
        $ventas = tbl_venta::selectRaw("tbl_ventas.*, concat_ws(' ',users.name, users.apellidos) as encargado")->
        leftJoin('users','users.id','=','tbl_ventas.id_usuario_reg')->
        get();

        return response()->json([
            'data' => $ventas ?? []
        ]);
    }
}
