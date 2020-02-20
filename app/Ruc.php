<?php

namespace App;
set_time_limit(60);
class Ruc{
    public static  function search($ruc){

        $url="https://api.sunat.cloud/ruc/$ruc";
        $json = self::getConnect($url);
        $data = json_decode($json,true);
        if($data!==null){
            return [
                "numero" => $data["ruc"],
                "razon" => $data["razon_social"],
                "direccion"=> $data["domicilio_fiscal"] !="-" ? $data["domicilio_fiscal"] : '' ,
            ];
        }else{
            return [];
        }

    }
    public  static  function  getConnect($url){
        $data= [];
        try {
            $conexion=curl_init();
            curl_setopt($conexion,CURLOPT_URL,$url);
            curl_setopt($conexion,CURLOPT_RETURNTRANSFER,true);
            $data=curl_exec($conexion);
            curl_close($conexion);
        } catch (\Exception $ex) {
            array_push($data,$ex->getMessage());
        }
        return $data;
    }
}
