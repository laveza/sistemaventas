<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model{
    protected  $table ="proveedores";
    protected  $primaryKey = "idpersona";
    protected  $fillable = [
      'idpersona',
      'contacto',
      'telefono_contacto',
    ];
    public $timestamps = false;
    public  function  Persona(){
        return $this->belongsTo("App\Persona");
    }
}
