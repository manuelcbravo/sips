<?php

namespace App\Http\Controllers;

use App\Models\tbl_inventario_movimiento;
use App\Models\tbl_inventario_sucursale;
use App\Models\tbl_articulo;
use App\Models\tbl_sucursal;
use Illuminate\Http\Request;

use Auth;
use DataTables;

class TblInventarioMovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sucursales =  tbl_sucursal::get();

        return view('pages.inventario.movimientos.index', ['active' => 'movimientos', 'sucursales' => $sucursales ]);
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
     * @param  \App\Models\tbl_inventario_movimiento  $tbl_inventario_movimiento
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_inventario_movimiento $tbl_inventario_movimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_inventario_movimiento  $tbl_inventario_movimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_inventario_movimiento $tbl_inventario_movimiento, $id)
    {
        $show = tbl_inventario_movimiento::find($id);

        return response()->json([
            'respuesta' => true,
            'posts' => $show
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_inventario_movimiento  $tbl_inventario_movimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_inventario_movimiento $tbl_inventario_movimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_inventario_movimiento  $tbl_inventario_movimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_inventario_movimiento $tbl_inventario_movimiento)
    {
        //
    }

    public function getData(Request $request, $id_sucursal){

        $data = tbl_inventario_movimiento::selectRaw("tbl_inventario_movimientos.*, tbl_articulos.*,
        concat(cat_presentaciones.codigo, ' - ', cat_presentaciones.nombre) as presentacion, tbl_inventario_movimientos.id,
        cat_movimientos.nombre as movimiento,
        tbl_sucursals.nombre as sucursal")
        ->join('tbl_articulos','tbl_articulos.id','=','tbl_inventario_movimientos.id_articulo')
        ->join('tbl_sucursals','tbl_sucursals.id','=','tbl_inventario_movimientos.id_sucursal')
        ->join('cat_presentaciones','cat_presentaciones.codigo','=','tbl_articulos.id_presentacion')
        ->join('cat_movimientos','cat_movimientos.id','=','tbl_inventario_movimientos.id_movimiento');

        if($id_sucursal != 0){
            $data->where('tbl_inventario_movimientos.id_sucursal',$id_sucursal);
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

            return DataTables::of($data->orderBy('tbl_inventario_movimientos.created_at','desc')->get())
                ->addColumn('acciones', function ($producto) {
                    // Puedes personalizar las acciones según tus necesidades
                    return '<button onclick="editarProducto(' . $producto->id . ')">Editar</button>';
                })
                ->rawColumns(['acciones'])
                ->make(true);
        }

        return abort(404);
        
    }

    public function setAjuste(Request $request){

        $entrada = 0;
        $salida = 0;
        $inv_final = 0;

        $cantidad = $request->cantidad;
        $existencia = 0;

        // dd($request->all());
        $articulo_inventario = tbl_inventario_sucursale::find($request->id);
        // dd($articulo_inventario);
        $id_articulo = $articulo_inventario->id_articulo;
        $inv_inicial = $articulo_inventario->existencia;

        if($request->id_movimiento == 4){
            // suma a la existencia
            $entrada  = $cantidad;
            $inv_final = $inv_inicial + $cantidad;
            $existencia = $inv_inicial + $cantidad;
        }

        if($request->id_movimiento == 5){
            // reset a la existencia
            $inv_final = $cantidad;
            $existencia = $cantidad;

        }

        if($request->id_movimiento == 1 || $request->id_movimiento == 2 || $request->id_movimiento == 3){
            // resta a la existencia
            $salida = $cantidad;
            $inv_final = $inv_inicial - $cantidad;
            $existencia = $inv_inicial - $cantidad;

        }

        $arreglo_movimiento = ['id_movimiento' => $request->id_movimiento,
        'entrada' => $entrada,
        'salida' => $salida,
        'id_sucursal' => $articulo_inventario->id_sucursal,
        'id_usuario_reg' => Auth::id(),
        'inv_inicial' => $inv_inicial,
        'inv_final' => $inv_final,
        'id_articulo' => $id_articulo,
        'comentario' => $request->comentario];

        tbl_inventario_movimiento::create($arreglo_movimiento);

        $articulo_inventario->existencia = $existencia;
        $articulo_inventario->save();


        return response()->json([
            'respuesta' => true,
        ], 200);

    }


    public function setTraspaso(Request $request){
        
        // dd($request->all());

        $articulo_inventario = tbl_inventario_sucursale::find($request->id_art);

        $articulo = tbl_articulo::find($articulo_inventario->id_articulo);
        $id_articulo = $articulo_inventario->id_articulo;

        $sucursal_traspaso = tbl_inventario_sucursale::where('id_articulo', $articulo_inventario->id_articulo)
        ->where('id_sucursal', $request->id_sucursal);

        if($request->id_amacen){
            $sucursal_traspaso->where('id_almaden', $request->id_amacen);
        }

        $sucursal_traspaso->first();


        if($sucursal_traspaso){
            $inv = tbl_inventario_sucursale::where('id', $sucursal_traspaso->id)->update(['existencia' => $request->cantidad +$sucursal_traspaso->existencia]);
        }else{
            $inv = tbl_inventario_sucursale::create(['id_articulo' => $articulo_inventario->id_articulo,
            'id_sucursal' => $request->id_sucursal,
            'id_almacen' => $request->id_almacen ?? null,
            'existencia' => $request->cantidad]);
        }

        $arreglo_movimiento = ['id_movimiento' => 6,
        'entrada' => $request->cantidad,
        'id_sucursal' => $request->id_sucursal,
        'id_sucursal_traspaso' => $articulo_inventario->id_sucursal,
        'id_almacen_traspaso' => $articulo_inventario->id_almacen,
        'id_usuario_reg' => Auth::id(),
        'id_articulo' => $id_articulo,
        'inv_final' => $value + $inv->existencia,
        'comentario' => $request->comentario];

        tbl_inventario_movimiento::create($arreglo_movimiento);

        $articulo_inventario->existencia = $articulo_inventario->existencia - $request->cantidad;
        $articulo_inventario->save();

        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Traspaso realizado correctamente'
        ], 200);

    }
}
