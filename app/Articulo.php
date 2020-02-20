<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model{  
      protected $fillable =[
            'idcategoria',
            'codigo',
            'nombre',
            'precio_venta',
            'stock',
            'stock_inicial',
            'descripcion',
            'condicion',
            'imagen',
      ];     
      public  function  categoria(){
            return $this->belongsTo("App\Categoria");
      }
}
