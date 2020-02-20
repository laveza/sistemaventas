<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
class RolController extends Controller{
     public  function __construct () {

     }
     public  function  index(Request $request){
         if(!$request->ajax()) \redirect("/admin");
         $search = isset($request->search) ? $request->seatch : '';
         $criterio = isset($request->criterio) ? $request->criterio : '';
         $tamanio = isset($request->tamanio) ? intval($request->tamanio) : 5;
         $roles = Rol::where("condicion",'=',1)
             ->orderBy("id",'desc')
             ->paginate();
         return response()->json($roles);
     }
}
