<?php


namespace App\Helpers;
use Request;
use App\Models\tbl_notificacione as NotificacionesModel;
use App\Models\LogActivity as LogActivityModel;
use App\Models\User;
use App\Models\tbl_device_tokens;

use Auth;

class Notificaciones
{


    public static function agregarLog($subject, $id_registro, $tabla)
    {
        $log = [];
        $log['accion'] = $subject;
        $log['url'] = Request::fullUrl();
        $log['metodo'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agente'] = Request::header('user-agent');
        $log['id_user'] = auth()->check() ? auth()->user()->id : null;
        $log['id_afectado'] = $id_registro ?? null;
        $log['tabla'] = $tabla ?? null;
        LogActivityModel::create($log);
    }


    public static function addNotificacion($id_emisor, $id_receptor, $notificacion, $url)
    {
        $log = [];
        $log['id_emisor'] = $id_emisor;
        $log['id_receptor'] = $id_receptor;
        $log['notificacion'] = $notificacion;
        $log['url'] = $url;
        NotificacionesModel::create($log);
    }

    public static function sendNotification($title, $body, $tipo, $id)
    {
        $tipo;

        $SERVER_API_KEY = 'AAAAB91GtR8:APA91bEEF-UvPHpCwfStnm_JwVINndafJKe-3FMTMPU6fnydsM6xODftI8d6VI_xdXqMBOSr8OAP53wwAmlaZMHGeT-mbfLWZFL9aHBK5ZWSVVULn3m-tMAp1WMydfFZftpiQ0z5tpIe';

        $devices = tbl_device_tokens::where('id_asesor',$id)->pluck('device_token')->all();
        User::where('id',$id)->update(['visto'=>0]);

        if($devices) {
//            dd($devices);
            $data = [
                "registration_ids" => $devices,
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                    "icon" => 'https://fielgroup.com.mx/lemusDev/material/lemus/logos/logo-light.svg',
                    'click_action' => 'https://habitatlemus.mx/plataforma/'
                ]
            ];
            $dataString = json_encode($data);

            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];
//            dd($dataString, $headers);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            curl_exec($ch);

        }

        return response()->json([
            'status' => true,
        ], 200);

    }


}
