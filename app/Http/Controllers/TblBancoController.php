<?php

namespace App\Http\Controllers;

use App\Models\tbl_banco;
use Illuminate\Http\Request;

use Auth;
use DB;

class TblBancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view('pages.catalogos.bancos.index', ['active' => 'bancos']);
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

        tbl_banco::updateOrCreate(['id' => $store['id'] ?? null], $store);

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
     * @param  \App\Models\tbl_banco  $tbl_banco
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_banco $tbl_banco)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_banco  $tbl_banco
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_banco $tbl_banco, Request $request, $id)
    {
        $show = tbl_banco::find($id);

        return response()->json([
            'respuesta' => true,
            'paquete' => $show
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_banco  $tbl_banco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_banco $tbl_banco)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_banco  $tbl_banco
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_banco $tbl_banco, Request $request, $id)
    {
        $user = tbl_banco::withTrashed()->find($id);
        $user ->delete();

        return response()->json([
            'respuesta' => true,
        ], 200);
    }

    public function getBancos(){
        if($bancos = tbl_banco::get()){
            return response()->json([
                'data' => $bancos
            ]);
        }

        return response()->json([
            'data' => [],
        ], 200);
    }
}
