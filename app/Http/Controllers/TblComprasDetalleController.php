<?php

namespace App\Http\Controllers;

use App\Models\tbl_compras_detalle;
use App\Models\tbl_articulo;
use App\Models\tbl_compras;
use App\Models\tbl_inventario_movimiento;
use App\Models\tbl_inventario_sucursale;
use Illuminate\Http\Request;
use SimpleXMLElement;

use Auth;
use DB;
use File;
use Response;
use Carbon\Carbon;

class TblComprasDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\tbl_compras_detalle  $tbl_compras_detalle
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_compras_detalle $tbl_compras_detalle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_compras_detalle  $tbl_compras_detalle
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_compras_detalle $tbl_compras_detalle, $id)
    {
        $data = tbl_compras_detalle::find($id);

        return response()->json([
            'respuesta' => true,
            'posts' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_compras_detalle  $tbl_compras_detalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_compras_detalle $tbl_compras_detalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_compras_detalle  $tbl_compras_detalle
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_compras_detalle $tbl_compras_detalle)
    {
        //
    }

    public function getComprasDetalle($id) {

        $show = tbl_compras::find($id);
        $compras_detalle = tbl_compras_detalle::where('id_compra',$id)->get();
        $compras_detalle_nuevo = tbl_compras_detalle::where('id_compra',$id)->where('id_estatus', 0)->get();

        // if($show->tipo_compra == 1 && $show->finalizado == 0){
        //     $filePath = storage_path('app/'.$show->direccion);
        //     $xmlString = File::get($filePath);
        //     $xml = new SimpleXMLElement($xmlString);

        //     foreach ($xml->xpath('//cfdi:Concepto') as $concepto) {
        //         $conceptoData = [
        //             'cantidad' => (float)$concepto['Cantidad'],
        //             'unidad' => (string)$concepto['Unidad'],
        //             'no_identificacion' => (string)$concepto['NoIdentificacion'],
        //             'descripcion' => (string)$concepto['Descripcion'],
        //             'valor_unitario' => (float)$concepto['ValorUnitario'],
        //             'importe' => (float)$concepto['Importe'],
        //             'clave_prod_serv' => (string)$concepto['ClaveProdServ'],
        //             'clave_unidad' => (string)$concepto['ClaveUnidad'],
        //             'objeto_imp' => (string)$concepto['ObjetoImp'],
        //         ];
            
        //         // Extraer información de los Traslados
        //         $traslados = [];
            
        //         foreach ($concepto->xpath('.//cfdi:Traslado') as $traslado) {
        //             $conceptoData['impuestos'] = (float)$traslado['Importe'];
        //         }
            
        //         $conceptos[] = $conceptoData;
        //     }
        // }

        return response()->json([
            'detalle' => $compras_detalle,
            'nuevos' => $compras_detalle_nuevo->count(),
            'id' => $id
        ]);
    }
    
    
    public function getCompraNuevo($id){
        $show = tbl_compras::find($id);
        $compras_detalle = tbl_compras_detalle::where('id_compra',$id)->where('id_estatus', 1)->get();
        $compras_detalle_nuevo = tbl_compras_detalle::where('id_compra',$id)->where('id_estatus', 0)->get();

        return response()->json([
            'detalle' => $compras_detalle_nuevo,
            'id' => $id
        ]);
    }

    public function setCompraNuevo(Request $request){
        $store = $request->all();   
        
        if(!isset($store['importacion'])){
            $store['importacion'] = 0;
        }
        
        if(!isset($store['ensanblado_en_linea'])){
            $store['ensanblado_en_linea'] = 0;
        }
        
        tbl_articulo::create($store);

        tbl_compras_detalle::where('id', $store['id'])->update(['id_estatus' => 1]);

        return response()->json(
            [
                'respuesta' => true,
                'mensaje' => "Articulo guardado correctamente"
            ]
        );

    }

    public function setCompraCambio(Request $request){
        $store = $request->all();  

        tbl_compras_detalle::where('id', $store['id'])->update(['no_identificacion' => $store['articulo'], 
            'descripcion' => $store['descripcion'] ,
            'cantidad' => $store['cantidad'],
            'cantidad_det' => $store['cantidad'] ,
            'importe' => $store['importe'] ,
            'valor_unitario' => $store['valor_unitario'],
            'impuestos' => $store['impuestos'] 
        ]);
        
        $articulo = tbl_articulo::where('articulo', $store['articulo'])->get();

        if($articulo->count() > 0){
            tbl_compras_detalle::where('id', $store['id'])->update(['id_estatus' => 1]);
           
            return response()->json(
                [
                    'respuesta' => true,
                    'mensaje' => "Articulo encotrado y guardado correctamente"
                ]
            );
        }else{
            tbl_compras_detalle::where('id', $store['id'])->update(['id_estatus' => 0]);
        }

        return response()->json(
            [
                'respuesta' => true,
                'mensaje' => "Articulo no encontrado y guardado correctamente"
            ]
        );
    }
    
    public function setCompraArticulo(Request $request){
        $store = $request->all();  
        
        $articulo = tbl_articulo::selectRaw("tbl_articulos.*, cat_u_medidas.nombre as unidad")
        ->join("cat_u_medidas","cat_u_medidas.id","=","tbl_articulos.id_unidad_medida")
        ->find($store['id_articulo']);

        tbl_compras_detalle::create(['no_identificacion' => $articulo->articulo, 
            'descripcion' => $articulo->descripcion ,
            'cantidad' => $store['cantidad'],
            'cantidad_det' => $store['cantidad'] ,
            'importe' => $store['importe'] ,
            'valor_unitario' => $store['valor_unitario'],
            'impuestos' => $store['impuestos'],
            'id_compra' => $store['id_compra'],
            'clave_unidad' => $articulo->id_presentacion, 
            'objeto_imp' => 02,
            'unidad' => $articulo->unidad,
            'id_estatus' => 1,
            'clave_prod_serv'=> $articulo->clave_prodserv
        ]);


        return response()->json(
            [
                'respuesta' => true,
                'mensaje' => "Articulo no encontrado y guardado correctamente"
            ]
        );
    }

    public function getTraspaso($id){
        $show = tbl_compras::find($id);
        $compras_detalle = tbl_compras_detalle::selectRaw("tbl_compras_detalles.*, 
        tbl_articulos.precio as precio_viejo,
        tbl_articulos.id as id_articulo")
        ->leftJoin('tbl_articulos','tbl_articulos.articulo','=','tbl_compras_detalles.no_identificacion')
        ->where('id_compra',$id)
        ->where('id_estatus', 1)->get();

        $compras_detalle_nuevo = tbl_compras_detalle::where('id_compra',$id)->where('id_estatus', 0)->get();

        return response()->json([
            'detalle' => $compras_detalle,
            'nuevos' => $compras_detalle_nuevo->count(),
            'id' => $id
        ]);
    }
    
    public function setTraspaso(Request $request){

        foreach($request->cantidad as $key => $value){

            $detalle = tbl_compras_detalle::find($key);
            $articulo = tbl_articulo::where('articulo', $detalle->no_identificacion)->first();

            $sucursal_traspaso = tbl_inventario_sucursale::where('id_articulo', $articulo->id)
            ->where('id_sucursal', $request->id_sucursal);

            if($request->id_amacen){
                $sucursal_traspaso->where('id_almaden', $request->id_amacen);
            }

            $sucursal_traspaso->first();

            $sucursal_traspaso = $sucursal_traspaso->first();

            if($sucursal_traspaso){
                tbl_inventario_sucursale::where('id', $sucursal_traspaso->id)->update(['existencia' => $value + $sucursal_traspaso->existencia]);
                $inv = tbl_inventario_sucursale::where('id', $sucursal_traspaso->id)->first();
            }else{
                $inv = tbl_inventario_sucursale::create(['id_articulo' => $articulo->id,
                'id_sucursal' => $request->id_sucursal,
                'id_almacen' => $request->id_almacen ?? null,
                'existencia' => $value]);
            }

            // dd($inv);

            $arreglo_movimiento = ['id_movimiento' => 8,
            'entrada' => $value,
            'id_sucursal' => $request->id_sucursal,
            'id_usuario_reg' => Auth::id(),
            'id_articulo' => $articulo->id,
            'inv_final' => $value + $inv->existencias,
            'comentario' => 'Movimiento por compra'];

            tbl_inventario_movimiento::create($arreglo_movimiento);

            $detalle->cantidad_det = $detalle->cantidad_det - $value;
            $detalle->save();
        }
     
        return response()->json(
            [
                'respuesta' => true,
                'mensaje' => "Traspaso correcto"
            ]
        );
    }

}
