<?php

namespace App\Http\Controllers;

use App\Models\cat_marca;
use Illuminate\Http\Request;

use Auth;
use DB;

class CatMarca extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.catalogos.marcas.index', ['active' => 'marcas']);
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

        cat_marca::updateOrCreate(['id' => $store['id'] ?? null], $store);

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $show = cat_marca::find($id);

        return response()->json([
            'respuesta' => true,
            'posts' => $show
        ], 200);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = cat_marca::withTrashed()->find($id);
        $user ->delete();

        return response()->json([
            'respuesta' => true,
        ], 200);
    }

    public function getData(){
        if($bancos = cat_marca::get()){
            return response()->json([
                'data' => $bancos
            ]);
        }

        return response()->json([
            'data' => [],
        ], 200);
    }
}
