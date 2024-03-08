<?php
namespace App\Http\Traits;

use Illuminate\Encryption\Encrypter;
use Milon\Barcode\Utils\BarcodeGenerator;
use Milon\Barcode\Utils\QrCode;
use Milon\Barcode\BarcodeGeneratorPNG;

use App\Models\tbl_producto;

use Auth;
use DB;
use Storage;
use Config;
use Str;

trait BarCodeTrait{
    
    public function generar_codigo ($id){
        $producto = tbl_producto::find($id);

        
        $barcodeText = $producto->codigo_barras;

        $d = new DNS1D();
        return  base64_decode((new DNS1D())->getBarcodePNG($barcodeText, 'C39'));
       
    }

}