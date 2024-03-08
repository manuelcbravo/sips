<?php

namespace App\Http\Controllers;

use App\Models\tbl_inventario_sucursale;
use App\Models\tbl_sucursal;
use Illuminate\Http\Request;

use DataTables;

class TblInventarioSucursaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sucursales =  tbl_sucursal::get();

        return view('pages.inventario.inventarios.index', ['active' => 'inventarios', 'sucursales' => $sucursales ]);

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
       
        tbl_inventario_sucursale::updateOrCreate(['id' => $store['id'] ?? null], $store);

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
     * @param  \App\Models\tbl_inventario_sucursale  $tbl_inventario_sucursale
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_inventario_sucursale $tbl_inventario_sucursale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_inventario_sucursale  $tbl_inventario_sucursale
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_inventario_sucursale $tbl_inventario_sucursale, $id)
    {
        $show = tbl_inventario_sucursale::selectRaw('tbl_inventario_sucursales.*, tbl_articulos.articulo as articulo')
        ->join('tbl_articulos','tbl_articulos.id','=','tbl_inventario_sucursales.id_articulo')
        ->find($id);

        return response()->json([
            'respuesta' => true,
            'posts' => $show
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_inventario_sucursale  $tbl_inventario_sucursale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_inventario_sucursale $tbl_inventario_sucursale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_inventario_sucursale  $tbl_inventario_sucursale
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_inventario_sucursale $tbl_inventario_sucursale)
    {
        //
    }

    public function getData(Request $request, $id_sucursal, $id_almacen){

        if($id_sucursal == 0){
            return response()->json([
                'data' => [],
            ], 200);
        }

        if($id_sucursal != 0){

            $data = tbl_inventario_sucursale::selectRaw("tbl_inventario_sucursales.*, tbl_articulos.*,
            concat(cat_presentaciones.codigo, ' - ', cat_presentaciones.nombre) as presentacion, tbl_inventario_sucursales.id")
            ->join('tbl_articulos','tbl_articulos.id','=','tbl_inventario_sucursales.id_articulo')
            ->join('cat_presentaciones','cat_presentaciones.codigo','=','tbl_articulos.id_presentacion')
            ->where('id_sucursal',$id_sucursal);

        }

        if($id_almacen != 0){
            $data -> where('id_almacen',$id_almacen);
        }

        if ($request->ajax()) {

            // Aplicar búsqueda
            if ($request->has('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $data->where(function ($query) use ($search) {
                    $query->whereRaw('LOWER(articulo) LIKE ?', ['%' . strtolower($search) . '%']);
                        // ->orWhere('descripcion', 'like', '%' . $search . '%');
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
}
