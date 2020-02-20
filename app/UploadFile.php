<?php

namespace App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
class UploadFile{
      private static $texto;
      private static $url;
      public static function setImage($foto,$carpeta,$subcarpeta,$codigo,$actual = false){
            if($foto){
                  if($actual){
                        Storage::disk("public")->delete("img/$carpeta/$subcarpeta/$actual");
                  }
                  $imageName = "$codigo.jpg";
                  $imagen = Image::make($foto)->encode("jpg",100);
                  $imagen->resize(600,600,function($constraint){
                     $constraint->upsize();
                  });
                  Storage::disk('public')->put("img/$carpeta/$subcarpeta/$imageName",$imagen->stream());
                  if(empty($imageName)){
                        return false;
                  }else{
                        return $imageName;
                  }
            }else{
                  return false;
            }
      }
      public static function getImage($url){
            return Storage::url("img/$url");
      }
      public static function LimpiarTexto($texto){
            $_producto = strtolower($texto);
            $__producto = explode(" ", $_producto);
            $___producto = \join($__producto, "-");
            self::$texto = $___producto;
            return  new UploadFile();
      }
      public static function get(){
            return self::$texto;     
      }
      public static function UrlImagen(){
            $params = func_get_args();
            $d = [];
            foreach($params as $key=>$value){
                  if($key ==1){
                        $d[]= self::LimpiarTexto($value)->get();
                  }else{
                        $d[]=$value;
                  }
            }
              
            $url = \join($d,"/");
            return Storage::url("img/$url");
      }
}
