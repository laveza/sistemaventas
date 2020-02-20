<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Paginador;
use Illuminate\Support\Facades\Redirect;

class CategoriaController extends Controller
{
    //
    private $respuesta;
    public  function  __construct(){
            $this->respuesta = new  \stdClass();
            $this->respuesta->errores = [];
            $this->respuesta->estado = 1;
            $this->respuesta->mensaje = "";
    }

    public  function  index(Request $request){

        if(!$request->ajax()) \redirect("/admin");
        $search = isset($request->nombre) ? $request->nombre : "";
        $estado = isset($request->estado) ? $request->estado : "";
        $tamanio = isset($request->tamanio) ? intval($request->tamanio) : 5;

        $categoria = Categoria::where("nombre","LIKE","%{$search}%")
            ->where("condicion","LIKE","%{$estado}%")
            ->orderBy("id","desc")
            ->paginate($tamanio);

        return response()->json([
            "paginacion" =>[
                'total_registros'=>$categoria->total(),
                'pagina_actual'=>$categoria->currentPage(),
                'registro_pagina'=>$categoria->perPage(),
                'ultima_pagina'=>$categoria->lastPage(),
                "desde_pagina"=>$categoria->firstItem() > 0 ? $categoria->firstItem() : 0,
                "hasta_pagina"=>$categoria->lastItem() > 0 ? $categoria->lastItem() : 0,
                "NumeroPaginas"=> $categoria->total() > 0 ? Paginador::paginate($categoria->currentPage(),$categoria->lastPage()) : [],
                "mensaje"=> $categoria->total() > 0 ? '' : 'No hay datos'
            ],
            "categoria"=>$categoria,

        ]);
    }
    public  function  store(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try {

            $validado = $this->Validar(["nombre"=>$request->nombre,"descripcion"=>$request->descripcion]);
            if(!$validado)
                  throw new \Exception("Verificar Errores", 1);

            $categoria = new Categoria();
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->condicion = 1;
            $rpta = $categoria->save();
            if(!$rpta)
                throw  new \Exception("Categoria No registrado");
            $this->respuesta->mensaje = "Categoria Registrada Correctamente";
        }catch (\Exception $ex){
            $this->respuesta->estado = 2;
            $this->respuesta->mensaje = $ex->getMessage();
        }

        return response()->json($this->respuesta);
    }
    public  function  update(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try {
            $validado = $this->Validar(["nombre"=>$request->nombre,"descripcion"=>$request->descripcion]);
            if(!$validado)
                throw new \Exception("Verificar Errores", 1);

            $categoria = Categoria::findOrFail($request->id);
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->condicion = 1;
            $rpta = $categoria->update();
            if(!$rpta)
                throw  new \Exception("Categoria No Actualizada");
            $this->respuesta->mensaje = "Categoria Actualizada Correctamente";
        }catch (\Exception $ex){
            $this->respuesta->estado = 2;
            $this->respuesta->mensaje = $ex->getMessage();
        }

        return response()->json($this->respuesta);
    }
    public function  Activar(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try {
            $categoria = Categoria::findOrFail($request->id);
            $categoria->condicion = "1";
            $rpta = $categoria->update();
            if(!$rpta)
                throw  new \Exception("Categoria No Activada");
            $this->respuesta->mensaje = "Categoria Activada Correctamente";
        }catch (\Exception $ex){
            $this->respuesta->estado = 2;
            $this->respuesta->mensaje = $ex->getMessage();
        }

        return response()->json($this->respuesta);
    }
    public  function  Desactivar(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try {
            $categoria = Categoria::findOrFail($request->id);
            $categoria->condicion = "0";
            $rpta = $categoria->update();
            if(!$rpta)
                throw  new \Exception("La Categoria No se pudo Inactivar");
            $this->respuesta->mensaje = "Categoria Inactivada Correctamente";
        }catch (\Exception $ex){
            $this->respuesta->estado = 2;
            $this->respuesta->mensaje = $ex->getMessage();
        }

        return response()->json($this->respuesta);
    }
    public function Validar(array $datos){
          $rt=[];
          $rpta= false;
          if(empty($datos["nombre"])){
                array_push($this->respuesta->errores,"nombre de categoria obligatorio.");
                $rt[0]=false;
          }else{
              if(preg_match("/^[a-zA-ZÁÉÍÓÚñáéíóúñ ]+$/",$datos["nombre"])){
                  array_push($this->respuesta->errores,"");
                  $rt[0]=true;
              }else{
                  array_push($this->respuesta->errores,"este campo solo acepta letras.");
                  $rt[0]=false;
              }
          }

          if(empty($datos["descripcion"])){
              array_push($this->respuesta->errores,"");
              $rt[1]= true;
          }else{
              if(preg_match("/^[0-9a-zA-ZÁÉÍÓÚÑáéíóúñ ]+$/",$datos["descripcion"])){
                  array_push($this->respuesta->errores,"");
                  $rt[1]= true;
              }else{
                  array_push($this->respuesta->errores,"solo acepta números y letras.");
                  $rt[1]= false;
              }

          }

          if($rt[0] && $rt[1]){
              $rpta = true;
          }
          return $rpta;
    }

}
