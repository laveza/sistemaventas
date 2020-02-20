<?php

namespace App\Http\Controllers;

use App\EsSalud\EsSalud;
use Illuminate\Http\Request;
use App\Paginador;
use App\Ruc;
use App\Proveedor;
use App\Persona;
use Illuminate\Support\Facades\DB;
class ProveedorController extends Controller{
    private  $fz;
    public  function  __construct(){
        $this->fz = new \stdClass();
        $this->fz->estado = 1;
        $this->fz->mensaje="";
        $this->fz->datos = [];
        $this->fz->errores=[];
    }
    public  function  index(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        $search = isset($request->search) ? $request->search : "";
        $criterio = isset($request->criterio) ? $request->criterio : "";
        $tamanio = isset($request->tamanio) ? intval($request->tamanio) : 5;

        if($search === ""){
            $proveedor = Proveedor::join("personas","proveedores.idpersona","=","personas.id")
                ->select('personas.id','personas.nombre','personas.tipo_documento','personas.num_documento','personas.direccion',
                    'personas.telefono','personas.email','proveedores.contacto','proveedores.telefono_contacto')
                ->orderBy("personas.id",'desc')
                ->paginate($tamanio);
        }else{
            $proveedor = Proveedor::join("personas","proveedores.idpersona","=","personas.id")
                ->select('personas.id','personas.nombre','personas.tipo_documento','personas.num_documento','personas.direccion',
                    'personas.telefono','personas.email','proveedores.contacto','proveedores.telefono_contacto')
                ->where("$criterio",'like',"%$search%")
                ->orderBy("personas.id",'desc')
                ->paginate($tamanio);
        }
        return  response()->json([
            "paginacion"=>[
                'total_registros' => $proveedor->total(),
                'pagina_actual' => $proveedor->currentPage(),
                'registro_pagina' => $proveedor->perPage(),
                'ultima_pagina' => $proveedor->lastPage(),
                "desde_pagina" => $proveedor->firstItem() > 0 ? $proveedor->firstItem() : 0,
                "hasta_pagina" => $proveedor->lastItem() > 0 ? $proveedor->lastItem() : 0,
                "NumeroPaginas" => $proveedor->total() > 0 ? Paginador::paginate($proveedor->currentPage(), $proveedor->lastPage()) : [],
                "mensaje" => $proveedor->total() > 0 ? '' : 'No hay datos',
            ],
            "proveedor"=>$proveedor
        ]);
    }
    public function store(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try{
            DB::beginTransaction();
                $persona = new Persona();
                $persona->nombre = $request->nombre;
                $persona->tipo_documento = $request->tipo_documento;
                $persona->num_documento = $request->num_documento;
                $persona->direccion = $request->direccion;
                $persona->email = $request->email;
                $persona->telefono = $request->telefono;
                $rptap = $persona->save();
                $proveedor = new Proveedor();
                $proveedor->contacto = $request->contacto;
                $proveedor->telefono_contacto = $request->telefono_contacto;
                $proveedor->idpersona  = $persona->id;
                $rptapro = $proveedor->save();

                if(!$rptap || !$rptapro)
                    throw new \Exception("No pude Registrar al Proveedor");
                $this->fz->mensaje = "Proveedor Registrado Correctamente";
            DB::commit();
        }catch(\Exception $exception){
            DB::rollBack();
            $this->fz->estado = 2;
            $this->fz->mensaje = $exception->getMessage();
        }
        return response()->json($this->fz);
    }
    public function update(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try{
            DB::beginTransaction();
                $proveedor = Proveedor::findOrFail($request->idpersona);
                $persona = Persona::findOrFail($request->id);
                $persona->nombre = $request->nombre;
                $persona->tipo_documento = $request->tipo_documento;
                $persona->num_documento = $request->num_documento;
                $persona->direccion = $request->direccion;
                $persona->email = $request->email;
                $persona->telefono = $request->telefono;
                $rptap = $persona->update();

                $proveedor->contacto = $request->contacto;
                $proveedor->telefono_contacto = $request->telefono_contacto;
                $rptapr = $proveedor->update();

                if(!$rptap || !$rptapr)
                    throw  new \Exception("Error al modificar");
                $this->fz->mensaje = "Proveedor Actualizado Correctamente";

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            $this->fz->estado = 2;
            $this->fz->mensaje = $exception->getMessage();
        }
        return response()->json($this->fz);
    }
    public  function  consulta(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try{
            switch ($request->tipo){
                case  'dni':{
                    if(count($this->dni($request->numero)) ===0)
                        throw new \Exception("No se encontro dicha consulta");
                    $this->fz->datos["result"] = $this->dni($request->numero);
                    $this->fz->datos["tipo"] = strtoupper($request->tipo);
                    break;
                }
                case 'ruc':{
                    if(count(Ruc::search($request->numero)) ===0)
                        throw new \Exception("No se encontro dicha consulta");
                    $this->fz->datos['result'] = Ruc::search($request->numero);
                    $this->fz->datos["tipo"] = strtoupper($request->tipo);
                    break;
                }
            }
        }catch (\Exception $exception){
            $this->fz->estado = 2;
            $this->fz->mensaje = $exception->getMessage();
        }

        return response()->json($this->fz);
    }
    private  function dni($dni){

        $essalud= new EsSalud();
        $search = $essalud->search($dni);
        $data = get_object_vars($search->result);
        if(count($data) > 0){
            return [
                "numero"=>"{$data['dni']}",
                "razon"=>"{$data['nombre']} {$data['paterno']} {$data['materno']}",
                "direccion"=>"",
            ];
        }else{
            return [];
        }
    }
}
