<?php
namespace App\Http\Traits;

use Illuminate\Encryption\Encrypter;

use Auth;
use DB;
use Storage;
use Config;
use Str;

trait SecurityTrait{

    private $cipher;

    function __construct()
    {
        return $this->cipher = 'AES-128-CBC';
    }

    public function encryptName($array, $request){
        $token = Str::substr($request->session()->get('_token'),0, 16);
        $encrypter = new Encrypter($token, $this->cipher);
        $arreglo_encriptado = array();

        foreach($array as $key=>$model){
            $arreglo_encriptado[$key] = new \stdClass();
            foreach($model->getFillable() as $input){
                $arreglo_encriptado[$key]->$input = $this->base64url_encode($encrypter->encrypt($input));
            }
            $arreglo_encriptado[$key]->id = $this->base64url_encode($encrypter->encrypt('id'));
        }

        return $arreglo_encriptado;
    }

    public function encryptSingle($single, $request){
        $token = Str::substr($request->session()->get('_token'),0, 16);
        $encrypter = new Encrypter($token, $this->cipher);

        return $this->base64url_encode($encrypter->encrypt($single));
    }
    
    public function decryptStore($array, $request){
        $token = Str::substr($request->session()->get('_token'),0, 16);
        $encrypter = new Encrypter($token, $this->cipher);
        $arreglo_desencriptado = [];

        foreach($array as $key=>$value){
            $key = $encrypter->decrypt($this->base64url_decode($key));
            $arreglo_desencriptado[$key] =$value;
        }
        // dd($arreglo_desencriptado);
        return $arreglo_desencriptado;
    }

    public function encryptShow($array, $request){
        $token = Str::substr($request->session()->get('_token'),0, 16);
        $encrypter = new Encrypter($token, $this->cipher);
        $arreglo_encriptado = new \stdClass();

        foreach($array->getAttributes() as $key=>$value){
            $key = $this->base64url_encode($encrypter->encrypt($key));
            $arreglo_encriptado->$key = $value;
        }
        
        return $arreglo_encriptado;
    }

    private function base64url_encode($bin) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($bin));
    }
    
    private function base64url_decode($str) {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $str));
    }
}