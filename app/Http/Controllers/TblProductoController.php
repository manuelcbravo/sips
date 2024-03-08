<?php

namespace App\Http\Controllers;

use App\Models\tbl_producto;
use Illuminate\Http\Request;

use App\Http\Traits\BarCodeTrait;
use Milon\Barcode\DNS1D;

use DataTables;

class TblProductoController extends Controller
{
    use BarCodeTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.inventario.productos.index', ['active' => 'productos']);
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
     * @param  \App\Models\tbl_producto  $tbl_producto
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_producto $tbl_producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_producto  $tbl_producto
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_producto $tbl_producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_producto  $tbl_producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_producto $tbl_producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_producto  $tbl_producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_producto $tbl_producto)
    {
        //
    }

    public function getProductosBarcode($id) {

        $d = new DNS1D();
        return  base64_decode((new DNS1D())->getBarcodePNG("wer", 'C39'));
    }

    public function getProductos(Request $request){

    //    $bancos = tbl_producto::get();

    //     return response()->json([
    //         'data' => $bancos
    //     ]);
        if ($request->ajax()) {
            $data = tbl_producto::query();

            // Aplicar búsqueda
            if ($request->has('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $data->where(function ($query) use ($search) {
                    $query->where('nombre', 'like', '%' . $search . '%')
                        ->orWhere('codigo_general', 'like', '%' . $search . '%');
                    // Agrega más columnas según tus necesidades
                });
            }

            return DataTables::of($data->get())
                ->addColumn('acciones', function ($producto) {
                    // Puedes personalizar las acciones según tus necesidades
                    return '<button onclick="editarProducto(' . $producto->id . ')">Editar</button>';
                })
                ->rawColumns(['acciones'])
                ->make(true);
        }

        return abort(404);
        
    }

    // public function getProducto(Request $request, $id){
    //     $productos = tbl_producto::where('codigo_general',$id)->get();
        
    //     return response()->json(
    //         [
    //             'respuesta' => (($productos)? true : false),
    //             'productos' => $productos
    //         ]
    //     );
    // }

    public function getProducto(Request $request, $id){
        $productos = tbl_producto::where('articulo',$id)->get();
        
        return response()->json(
            [
                'respuesta' => (($productos)? true : false),
                'productos' => $productos
            ]
        );
    }
}
