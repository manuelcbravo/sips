<?php

namespace App\Http\Controllers;

use App\Models\tbl_compras;
use App\Models\tbl_proveedores;
use App\Models\tbl_compras_detalle;
use App\Models\tbl_articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleXMLElement;

use Auth;
use DB;
use File;
use Response;
use Carbon\Carbon;

class TblComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.compras.compras.index', ['active' => 'compras']);

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
            $store['id_usuario_registro'] = Auth::id();
            $store['tipo_compra'] = 2;
        }
        // dd($store);

        tbl_compras::updateOrCreate(['id' => $store['id'] ?? null], $store);

        return response()->json(
            [
                'respuesta' => true,
                'mensaje' => "Acción realizada correctamente"
            ]
        );
    }

    public function setXML(Request $request)
    {
        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = Str::uuid(). '.' . $image->extension();

            Storage::disk('compras_xml')->put($imageName, file_get_contents($request->file('file')));

            $filePath = storage_path('app/xml/'.$imageName);
            $xmlString = File::get($filePath);
            $xml = new SimpleXMLElement($xmlString);

            // dd($xml->xpath('//cfdi:Emisor')[0]->attributes()->Rfc);

            $img = tbl_compras::create(['nombre_archivo' => $imageName,
                'nombre_original' => $image->getClientOriginalName(),
                'direccion' => 'xml/'.$imageName,
                'id_usuario_registro' => auth()->user()->id,
                'id_proveedor'=> $request->id_proveedor,
                'tipo_compra' => 1,
                'folio'=> (string) $xml['Folio'],
                'serie'=> (string) $xml['Serie'],
                'monto_total'=> (string) $xml['Total'],
                'sub_total' => (string) $xml['SubTotal'],
                'impuestos'=> (string) $xml->xpath('//cfdi:Comprobante/cfdi:Impuestos')[0]->attributes()->TotalImpuestosTrasladados,
                'moneda'=> (string) $xml['Moneda'],
                'descuento' => (((string) $xml['Descuento'])? (string) $xml['Descuento'] : 0),
                'fecha_compra' => Carbon::parse((string) $xml['Fecha'])->format('Y-m-d H:i'),
                'rfc_emisor' => (string) $xml->xpath('//cfdi:Emisor')[0]->attributes()->Rfc,
                'nombre_emisor' => (string) $xml->xpath('//cfdi:Emisor')[0]->attributes()->Nombre,
                'regimen_fiscal_emisor' => (string) $xml->xpath('//cfdi:Emisor')[0]->attributes()->RegimenFiscal,
                'uso_cfdi' => (string) $xml->xpath('//cfdi:Receptor')[0]->attributes()->UsoCFDI,
                'nombre_receptor' => (string) $xml->xpath('//cfdi:Receptor')[0]->attributes()->Nombre,
                'rfc_receptor' => (string) $xml->xpath('//cfdi:Receptor')[0]->attributes()->Rfc,
                'metodo_pago' => (string) $xml['MetodoPago'],
            ]);

            foreach ($xml->xpath('//cfdi:Concepto') as $concepto) {
                $conceptoData = [
                    'id_compra' => $img->id,
                    'cantidad' => (float)$concepto['Cantidad'],
                    'cantidad_det' => (float)$concepto['Cantidad'],
                    'unidad' => (string)$concepto['Unidad'],
                    'no_identificacion' => (string)$concepto['NoIdentificacion'],
                    'descripcion' => (string)$concepto['Descripcion'],
                    'valor_unitario' => (float)$concepto['ValorUnitario'],
                    'importe' => (float)$concepto['Importe'],
                    'clave_prod_serv' => (string)$concepto['ClaveProdServ'],
                    'clave_unidad' => (string)$concepto['ClaveUnidad'],
                    'objeto_imp' => (string)$concepto['ObjetoImp'],
                ];

                // Extraer información de los Traslados
                $traslados = [];

                foreach ($concepto->xpath('.//cfdi:Traslado') as $traslado) {
                    $conceptoData['impuestos'] = (float)$traslado['Importe'];
                }

                $articulo = tbl_articulo::where('articulo_limpio', Str::slug(preg_replace('/[^a-zA-Z0-9]/', '',(string)$concepto['NoIdentificacion'])))->get();

                if($articulo->count() > 0){
                    $conceptoData['id_estatus'] = 1;
                }

                tbl_compras_detalle::create($conceptoData);
            }

            return response()->json(['respuesta' => true, 'id' => $img->id]);
        }

        return response()->json(['respuesta' => false]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tbl_compras  $tbl_compras
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_compras $tbl_compras)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tbl_compras  $tbl_compras
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_compras $tbl_compras, $id)
    {
        $show = tbl_compras::find($id);

        // if($show->tipo_compra == 1 && $show->monto_total == ''){
        //     $filePath = storage_path('app/'.$show->direccion);
        //     $xmlString = File::get($filePath);
        //     $xml = new SimpleXMLElement($xmlString);

        //     // dd($xml->xpath('//cfdi:Comprobante/cfdi:Impuestos')[0]->attributes()->TotalImpuestosTrasladados[0]);

        //     $show->folio = (string) $xml['Folio'];
        //     $show->serie = (string) $xml['Serie'];
        //     $show->monto_total = (string) $xml['Total'];
        //     $show->impuestos = (string) $xml->xpath('//cfdi:Comprobante/cfdi:Impuestos')[0]->attributes()->TotalImpuestosTrasladados;
        //     $show->sub_total = (string) $xml['SubTotal'];
        //     $show->moneda = (string) $xml['Moneda'];
        //     $show->descuento = (string) $xml['Descuento'];

        //     $carbonFecha = Carbon::parse((string) $xml['Fecha']);
        //     $show->fecha_compra = $carbonFecha->format('Y-m-d H:i');
        // }

        return response()->json([
            'respuesta' => true,
            'proveedores' => tbl_proveedores::selectRaw("id, concat_ws(' ', nombre, apellido_paterno, apellido_materno) as nombre, rfc")->find($show->id_proveedor),
            'posts' => $show
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tbl_compras  $tbl_compras
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_compras $tbl_compras)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tbl_compras  $tbl_compras
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_compras $tbl_compras, $id)
    {
        $user = tbl_compras::withTrashed()->find($id);

        if($user){
            tbl_compras_detalle::where('id_compra',$id)->delete();
        }

        $user ->delete();

        return response()->json([
            'respuesta' => true,
        ], 200);
    }

    public function getCompras(){
        $compras = tbl_compras::selectRaw('tbl_compras.*, tbl_proveedores.nombre,
        SUM(tbl_compras_detalles.cantidad) as suma_detalles, count(tbl_compras_detalles.id) as cantidad_detalles')
        ->join('tbl_proveedores', 'tbl_proveedores.id', '=', 'tbl_compras.id_proveedor')
        ->leftJoin('tbl_compras_detalles', 'tbl_compras_detalles.id_compra', '=', 'tbl_compras.id')
        ->groupBy('tbl_compras.id','tbl_proveedores.nombre')
        ->orderBy('tbl_compras.fecha_compra','asc')
        ->get();

        return response()->json([
            'data' => $compras
        ]);
    }

}
