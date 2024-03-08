<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use SimpleXMLElement;

class XmlController extends Controller
{

    public function index()
    {
        $xmlString = file_get_contents(public_path('file.xml'));
        $xmlObject = simplexml_load_string($xmlString);
                   
        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true); 
   
        dd($phpArray);
    }

    public function getXml(){
        $filePath = storage_path('app/xml/ene.xml'); // Update with the actual path to your XML file

        if (File::exists($filePath)) {
            $xmlString = File::get($filePath);
            $xml = new SimpleXMLElement($xmlString);
            
            // Process the XML data as needed
            // Example: Retrieve values from specific elements
            $folio = (string) $xml['Folio'];
            $fecha = (string) $xml['Fecha'];
            $subTotal = (string) $xml['SubTotal'];
            $total = (string) $xml['Total'];

            $emisor = [
                'rfc' => (string)$xml->xpath('//cfdi:Emisor/@Rfc')[0],
                'nombre' => (string)$xml->xpath('//cfdi:Emisor/@Nombre')[0],
                'regimen_fiscal' => (string)$xml->xpath('//cfdi:Emisor/@RegimenFiscal')[0],
            ];

            $conceptos = [];

            foreach ($xml->xpath('//cfdi:Concepto') as $concepto) {
                $conceptoData = [
                    'cantidad' => (float)$concepto['Cantidad'],
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
                    $trasladoData = [
                        'base' => (float)$traslado['Base'],
                        'impuesto' => (string)$traslado['Impuesto'],
                        'tipo_factor' => (string)$traslado['TipoFactor'],
                        'tasa_o_cuota' => (float)$traslado['TasaOCuota'],
                        'importe' => (float)$traslado['Importe'],
                    ];
            
                    $traslados[] = $trasladoData;
                }
            
                $conceptoData['traslados'] = $traslados;
                $conceptos[] = $conceptoData;
            }
            
            // Return the extracted data or perform any further actions
            return response()->json([
                'fecha' => $fecha,
                'folio' => $folio,
                'subTotal' => $subTotal,
                'total' => $total,
                'emisor' => $emisor,
                'conceptos' => $conceptos
            ]);
        }
        
        return response()->json(['error' => 'XML file not found.']);
    }

}
