<?php

namespace App\Http\Controllers;

use App\Models\tbl_almacene;
use Illuminate\Http\Request;

use Auth;
use DB;

class TblAlmaceneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.catalogos.almacenes.index', ['active' => 'almacen']);

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

        tbl_almacene::updateOrCreate(['id' => $store['id'] ?? null], $store);

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
     * @param  \App\Models\tbl_almacene  $tbl_almacene
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_almacene $tbl_almacene)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_almacene  $tbl_almacene
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_almacene $tbl_almacene, $id)
    {
        $show = tbl_almacene::find($id);

        return response()->json([
            'respuesta' => true,
            'posts' => $show
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_almacene  $tbl_almacene
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_almacene $tbl_almacene)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_almacene  $tbl_almacene
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_almacene $tbl_almacene, $id)
    {
        $user = tbl_almacene::withTrashed()->find($id);
        $user ->delete();

        return response()->json([
            'respuesta' => true,
        ], 200);
    }

    public function getAlmacen(){
        if($bancos = tbl_almacene::get()){
            return response()->json([
                'data' => $bancos
            ]);
        }

        return response()->json([
            'data' => [],
        ], 200);
    }
}
