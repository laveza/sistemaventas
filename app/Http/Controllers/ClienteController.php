<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Persona;
use App\Paginador;
use App\EsSalud\EsSalud;
use App\Ruc;
class ClienteController extends Controller
{
    private  $respuesta;
    public  function __construct(){
        $this->respuesta = new \stdClass();
        $this->respuesta->estado = 1;
        $this->respuesta->mensaje = "";
        $this->respuesta->datos=[];
        $this->respuesta->error=[];
    }

    public function index(Request $request){
        if(!$request->ajax()) \redirect("/admin");

        $search = isset($request->search) ? $request->search : '';
        $criterio = isset($request->criterio) ? $request->criterio : '';
        $tamanio = isset($request->tamanio)  ? intval($request->tamanio) : 5;

        if($search==""){
            $cliente = Persona::orderBy('id','desc')->paginate($tamanio);
        }else{
            $cliente = Persona::where($criterio,'like',"%$search%")
                ->orderBy('id','desc')
                ->paginate($tamanio);
        }
        return  response()->json([
            "paginacion"=>[
                'total_registros' => $cliente->total(),
                'pagina_actual' => $cliente->currentPage(),
                'registro_pagina' => $cliente->perPage(),
                'ultima_pagina' => $cliente->lastPage(),
                "desde_pagina" => $cliente->firstItem() > 0 ? $cliente->firstItem() : 0,
                "hasta_pagina" => $cliente->lastItem() > 0 ? $cliente->lastItem() : 0,
                "NumeroPaginas" => $cliente->total() > 0 ? Paginador::paginate($cliente->currentPage(), $cliente->lastPage()) : [],
                "mensaje" => $cliente->total() > 0 ? '' : 'No hay datos',
            ],
            "clientes"=>$cliente
        ]);
    }

    public function store(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try {
            $cliente = new Persona();
            $cliente->nombre = $request->nombre;
            $cliente->tipo_documento= $request->tipo_documento;
            $cliente->num_documento = $request->num_documento;
            $cliente->direccion = $request->direccion;
            $cliente->telefono = $request->telefono;
            $cliente->email = $request->email;
            $rpta = $cliente->save();
            if(!$rpta)
                throw new \Exception("Cliente no  registrado");

            $this->respuesta->mensaje = "Cliente Registrado Correctamente";

        }catch (\Exception $exception){
            $this->respuesta->estado  = 2;
            $this->respuesta->mensaje = $exception->getMessage();
        }
        return response()->json($this->respuesta);
    }

    public function update(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try {
            $cliente = Persona::findOrFail($request->id);
            $cliente->nombre = $request->nombre;
            $cliente->tipo_documento= $request->tipo_documento;
            $cliente->num_documento = $request->num_documento;
            $cliente->direccion = $request->direccion;
            $cliente->telefono = $request->telefono;
            $cliente->email = $request->email;
            $rpta = $cliente->update();
            if(!$rpta)
                throw new \Exception("Cliente no  Actualizado");

            $this->respuesta->mensaje = "Cliente Actualizado Correctamente";
        }catch (\Exception $exception){
            $this->respuesta->estado  = 2;
            $this->respuesta->mensaje = $exception->getMessage();
        }
        return response()->json($this->respuesta);
    }

    public  function  consulta(Request $request){
        if(!$request->ajax()) return redirect("/");
        try{
            switch ($request->tipo){
                case  'dni':{
                    if(count($this->dni($request->numero)) ===0)
                        throw new \Exception("No se encontro dicha consulta");
                    $this->respuesta->datos["result"] = $this->dni($request->numero);
                    $this->respuesta->datos["tipo"] = strtoupper($request->tipo);
                    break;
                }
                case 'ruc':{
                    if(count(Ruc::search($request->numero)) ===0)
                        throw new \Exception("No se encontro dicha consulta");
                    $this->respuesta->datos['result'] = Ruc::search($request->numero);
                    $this->respuesta->datos["tipo"] = strtoupper($request->tipo);
                    break;
                }
            }
        }catch (\Exception $exception){
            $this->respuesta->estado = 2;
            $this->respuesta->mensaje = $exception->getMessage();
        }

        return response()->json($this->respuesta);
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
