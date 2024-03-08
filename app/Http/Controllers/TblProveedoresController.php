<?php

namespace App\Http\Controllers;

use App\Models\tbl_proveedores;
use Illuminate\Http\Request;
use App\Models\cat_cp;

use Auth;
use Illuminate\Support\Facades\Hash;
use Str;
use Storage;
use DB;

class TblProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.catalogos.proveedores.index', ['active' => 'proveedores']);
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
            $correo = tbl_proveedores::where('email', $store['email'])->first();
        } else {
            $correo = tbl_proveedores::where('email', $store['email'])->whereNotIn('id', [$store['id']])->first();
        }
        if($store['id_colonia'] != 0){ $store['colonia'] = NULL;}

        $store['email'] = strtolower($store['email']);
        $store['correo2'] = strtolower($store['correo2']);
        if($store['id_cliente_tipo'] == 2){
            $store['rl_email'] = strtolower($store['rl_email']);
        }

        if($correo){
            return response()->json(
                [
                    'respuesta' => false,
                    'mensaje' => "Este correo fue asignado a otro proveedor, es importante que ingrese un correo valido para este proveedor.",
                    'titulo' => "Correo asignado a otro proveedor"
                ]
            );
        }

        $cliente = tbl_proveedores::updateOrCreate(['id' => $store['id'] ?? null], $store);

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
     * @param  \App\Models\tbl_proveedores  $tbl_proveedores
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_proveedores $tbl_proveedores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_proveedores  $tbl_proveedores
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_proveedores $tbl_proveedores,$id , Request $request)
    {
        $data =tbl_proveedores::find($id);
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
     * @param  \App\Models\tbl_proveedores  $tbl_proveedores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_proveedores $tbl_proveedores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_proveedores  $tbl_proveedores
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_proveedores $tbl_proveedores, $id)
    {
        $user = tbl_proveedores::withTrashed()->find($id);
        $user ->delete();
        \Notificaciones::agregarLog('Registro eliminado', $id, "tbl_proveedores");

        return response()->json([
            'respuesta' => true,
        ], 200);
    }

    public function getProveedores(){

        $user = tbl_proveedores::get();


        if($user) {

            return response()->json([
                'data' => $user
            ]);
        }

        return response()->json([
            'data' => [],
        ], 200);

    }

    public function getProveedor($key){
        $data = $this -> searchProveedor($key);

        return response()->json([
            'incomplete_results' => false,
            'items' => $data,
            'total_count' => 1
        ]);
    }

    private function searchProveedor ($key){

        $client = tbl_proveedores::selectRaw("id, concat_ws(' ', nombre, apellido_paterno, apellido_materno) as nombre, rfc")
            ->where('nombre', 'iLIKE', "%$key%")
            ->orWhere('apellido_paterno', 'iLIKE', "%$key%")
            ->orWhere('apellido_materno', 'iLIKE', "%$key%")
            ->orWhere('rfc', 'iLIKE', "%$key%")
            ->get();

        return $client;
    }
}
