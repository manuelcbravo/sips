<?php

namespace App\Http\Controllers;

use App\Models\tbl_articulo;
use App\Models\tbl_proveedores;
use Illuminate\Http\Request;

use App\Http\Traits\BarCodeTrait;
use Milon\Barcode\DNS1D;

use DataTables;
use Str;

class TblArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.inventario.articulos.index', ['active' => 'articulos']);
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
        
        if(!isset($store['importacion'])){
            $store['importacion'] = 0;
        }
        
        if(!isset($store['ensanblado_en_linea'])){
            $store['ensanblado_en_linea'] = 0;
        }

        if(isset($store['articulo'])){
            $store['articulo_limpio'] = Str::slug(preg_replace('/[^a-zA-Z0-9]/', '',$store['articulo']));
        }
        
       
        tbl_articulo::updateOrCreate(['id' => $store['id'] ?? null], $store);

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
     * @param  \App\Models\tbl_articulo  $tbl_articulo
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_articulo $tbl_articulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_articulo  $tbl_articulo
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_articulo $tbl_articulo, $id)
    {
        $show = tbl_articulo::find($id);

        return response()->json([
            'respuesta' => true,
            'posts' => $show
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_articulo  $tbl_articulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_articulo $tbl_articulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_articulo  $tbl_articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_articulo $tbl_articulo, $id)
    {
        $user = tbl_articulo::withTrashed()->find($id);
        $user ->delete();

        return response()->json([
            'respuesta' => true,
        ], 200);
    }

    public function getData(Request $request){

        if ($request->ajax()) {
            $data = tbl_articulo::selectRaw("tbl_articulos.*, concat(cat_presentaciones.codigo, ' - ', cat_presentaciones.nombre) as presentacion")->
            join('cat_presentaciones','cat_presentaciones.codigo','=','tbl_articulos.id_presentacion');

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

    public function getArticulosBuscar($key){
        $data = $this -> searchArticulo($key);

        return response()->json([
            'incomplete_results' => false,
            'items' => $data,
            'total_count' => 1
        ]);
    }

    public function getArticulo(Request $request, $id){
        $productos = $this -> searchArticulo($id);
        
        return response()->json(
            [
                'respuesta' => (($productos)? true : false),
                'productos' => $productos
            ]
        );
    }

    private function searchArticulo ($key){

        $client = tbl_articulo::selectRaw("id, articulo, descripcion, precio")
            ->where('articulo', 'iLIKE', "%$key%")
            ->get();

        return $client;
    }

}
