<?php
namespace App\Http\Traits;

use Illuminate\Encryption\Encrypter;

use Auth;
use DB;
use Storage;
use Config;
use Str;

trait ImageTrait{
    public function reducir_imagen($image, $imageName, $destino){

        if ($image->getSize() > 1494338 && in_array($image->extension(), ['jpeg','png','jpg','gif','svg'])){
            Storage::disk($destino)->put($imageName, \Image::make($image)->encode($image->extension(), 70));
        }else{
            Storage::disk($destino)->put($imageName, file_get_contents($image));
        }

        return true;
    }

    public function guardar_imagen($image, $imageName, $destino){
        Storage::disk($destino)->put($imageName, file_get_contents($image));
        return true;
    }

    public function imagen_alta_baja_calidad($image, $imageName, $destinoAlta, $desinoBaja){

        if ($image->getSize() > 1204338 && in_array($image->extension(), ['jpeg','png','jpg','gif','svg'])){
            Storage::disk($destinoAlta)->put('al'.$imageName, \Image::make($image)->encode($image->extension(), 70));
            Storage::disk($desinoBaja)->put('baj'.$imageName, file_get_contents($image));
        }else{
            Storage::disk($destinoAlta)->put('al'.$imageName, file_get_contents($image));
            Storage::disk($desinoBaja)->put('baj'.$imageName, file_get_contents($image));
        }

        return true;
    }
}
