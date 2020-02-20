<?php

namespace App\Http\Controllers;

use App\Ingreso;
use App\DetalleIngreso;
use App\Paginador;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngresoController extends Controller{
    private  $fz;
   public  function  __construct () {
       $this->fz = new \stdClass();
       $this->fz->estado = 2;
       $this->fz->mensaje = "";
       $this->fz->datos= [];
       $this->fz->error = [];
   }
   public  function  index(Request $request){
       if(!$request->ajax()) return redirect("/");
       $search = isset($request->search) ? $request->search : '';
       $criterio = isset($request->criterio) ? $request->criterio : '';
       $tamanio = isset($request->tamanio) ? intval($request->tamanio) : 5;
       $estado = isset($request->estado) ? $request->estado : '';
       if($search === ""){
           $ingreso = Ingreso::join("personas",'ingresos.idproveedor','=','personas.id')
           ->join("users",'ingresos.idusuario','users.idpersona')
           ->select('ingresos.id','ingresos.idproveedor', 'ingresos.idusuario', 'ingresos.tipo_comprobante',
               'ingresos.serie_comprobante', 'ingresos.num_comprobante', 'ingresos.fecha_hora',
               'ingresos.impuesto', 'ingresos.total', 'ingresos.estado','users.usuario as usuario','personas.nombre as proveedor')
           ->orderBy("ingresos.id",'desc')
           ->paginate($tamanio);
       }else{
           $ingreso = Ingreso::join("personas",'ingresos.idproveedor','=','personas.id')
               ->join("users",'ingresos.idusuario','users.idpersona')
               ->select('ingresos.id','ingresos.idproveedor', 'ingresos.idusuario', 'ingresos.tipo_comprobante',
                   'ingresos.serie_comprobante', 'ingresos.num_comprobante', 'ingresos.fecha_hora',
                   'ingresos.impuesto', 'ingresos.total', 'ingresos.estado','users.usuario as usuario','personas.nombre as proveedor')
               ->where("$criterio","like","%$search%")
               ->where("ingreso.estado",'like',"%$estado%")
               ->orderBy("ingresos.id",'desc')
               ->paginate($tamanio);
       }
       return response()->json([
           'paginacion'=>[
                'total_registros'=>$ingreso->total(),
                'pagina_actual'=>$ingreso->currentPage(),
                'registro_pagina'=>$ingreso->perPage(),
                'ultima_pagina'=>$ingreso->lastPage(),
                'desde_pagina'=>$ingreso->firstItem() > 0 ? $ingreso->firstItem() : 0,
                'hasta_pagina'=>$ingreso->lastItem() > 0 ? $ingreso->lastItem() : 0,
                'NumeroPaginas'=> $ingreso->total() > 0  ? Paginador::paginate($ingreso->currentPage(),$ingreso->lastPage()) : [],
                'mensaje' => $ingreso->total() > 0 ? '' : 'No hay Datos',
           ],
           'ingresos'=>$ingreso,


       ]);
   }
   public function  store(Request $request){
       if(!$request->ajax()) return redirect("/");
       try {
           DB::beginTransaction();
                $myfecha = Carbon::now("America/Lima");
                $ingreso = new Ingreso();
                $ingreso->idproveedor = $request->idproveedor;
                $ingreso->idusuario = \Auth::user()->idpersona;
                $ingreso->tipo_comprobante = $request->tipo_comprobante;
                $ingreso->serie_comprobante = $request->serie_comprobante;
                $ingreso->num_comprobante = $request->num_comprobante;
                $ingreso->fecha_hora = $myfecha->toDateString();
                $ingreso->impuesto = $request->impuesto;
                $ingreso->total = $request->total;
                $ingreso->estado = "Registrado";
                $ri = $ingreso->save();
                $detalles = $request->data;
                foreach ($detalles as $key=>$value){
                    $detalle = new DetalleIngreso();
                    $detalle->idingreso = $ingreso->id;
                    $detalle->idarticulo = $value["idarticulo"];
                    $detalle->cantidad = $value["cantidad"];
                    $detalle->precio = $value["precio"];
                    $rd = $detalle->save();
                }
                if(!$ri && !$rd)
                    throw  new \Exception("No se guardo el Ingreso");
                $this->fz->mensaje = "Ingreso Registrado Correctamente";

           DB::commit();
       }catch (\Exception $exception){
           DB::rollBack();
           $this->fz->estado  =2;
           $this->fz->mensaje = $exception->getMessage();
       }
       return response()->json($this->fz);
   }
   public  function  desactivar(Request $request){
       if(!$request->ajax()) return redirect("/");
       try {
           $ingreso = Ingreso::findOrFail($request->id);
           $ingreso->estado = "Anulado";
           $rpta = $ingreso->update();
           if(!$rpta)
               throw  new \Exception("No se pudo Anular el Ingreso");
           $this->fz->mensaje = "Registro Anulado Correctamente";
       }catch(\Exception $exception){
           $this->fz->estado  = 2;
           $this->fz->mensaje = $exception->getMessage();
       }
       return response()->json($this->fz);
   }
}
