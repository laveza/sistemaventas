<?php

namespace App\Http\Controllers;

use App\Paginador;
use Illuminate\Http\Request;
use App\Persona;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Rol;
class UserController extends Controller{

    private  $fz;
    public  function  __construct(){
        $this->fz = new \stdClass();
        $this->fz->estado = 1;
        $this->fz->mensaje = "";
        $this->fz->datos = [];
        $this->fz->errores=[];
    }
    public  function index(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        $search = isset($request->search) ? $request->search : '';
        $criterio = isset($request->criterio) ? $request->criterio : '';
        $tamanio = isset($request->tamanio) ? intval($request->tamanio) : 5;
        if($search===""){
            $user = User::join("personas",'users.idpersona','=','personas.id')
            ->join("roles",'users.idrol','=','roles.id')
            ->select('personas.id','personas.nombre','personas.tipo_documento','personas.num_documento',
                'personas.direccion','personas.telefono','personas.email','users.usuario',
                'users.condicion','users.idrol','roles.nombre as nombre_rol')
            ->orderBy("personas.id",'desc')
            ->paginate($tamanio);
        }else{
            $user = User::join("personas",'users.idpersona','=','personas.id')
                ->join("roles",'users.idrol','=','roles.id')
                ->select('personas.id','personas.nombre','personas.tipo_documento','personas.num_documento',
                    'personas.direccion','personas.telefono','personas.email','users.usuario',
                    'users.condicion','users.idrol','roles.nombre as nombre_rol')
                ->where("personas.{$criterio}",'like',"%{$search}%")
                ->orderBy("personas.id",'desc')
                ->paginate($tamanio);
        }

        return response()->json([
            "paginacion"=>[
                'total_registros' => $user->total(),
                'pagina_actual' => $user->currentPage(),
                'registro_pagina' => $user->perPage(),
                'ultima_pagina' => $user->lastPage(),
                "desde_pagina" => $user->firstItem() > 0 ? $user->firstItem() : 0,
                "hasta_pagina" => $user->lastItem() > 0 ? $user->lastItem() : 0,
                "NumeroPaginas" => $user->total() > 0 ? Paginador::paginate($user->currentPage(), $user->lastPage()) : [],
                "mensaje" => $user->total() > 0 ? '' : 'No hay datos',
            ],
            "usuarios"=>$user
        ]);
    }
    public  function  store(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try {
            DB::beginTransaction();
                $personas = new Persona();
                $personas->nombre = $request->nombre;
                $personas->tipo_documento= $request->tipo_documento;
                $personas->num_documento= $request->num_documento;
                $personas->direccion = $request->direccion;
                $personas->telefono = $request->telefono;
                $personas->email = $request->email;
                $rpp = $personas->save();

                $user = new User();
                $user->usuario = $request->usuario;
                $user->password =bcrypt($request->password);
                $user->condicion = 1;
                $user->idrol = $request->idrol;
                $user->idpersona = $personas->id;
                $rppu = $user->save();
                if(!$rpp || !$rppu)
                    throw new \Exception("Error al Registrar");
                $this->fz->mensaje = "Usuario Registrado Correctamente";
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            $this->fz->estado = 2;
            $this->fz->mensaje = $exception->getMessage();
        }
        return response()->json($this->fz);
    }
    public  function  update(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try {
            DB::beginTransaction();
            $personas = Persona::findOrFail($request->id);
            $personas->nombre = $request->nombre;
            $personas->tipo_documento= $request->tipo_documento;
            $personas->num_documento= $request->num_documento;
            $personas->direccion = $request->direccion;
            $personas->telefono = $request->telefono;
            $personas->email = $request->email;
            $rpp = $personas->update();

            $user = User::findOrFail($request->idpersona);
            $user->condicion = 1;
            $user->idrol = $request->idrol;
            $rppu = $user->update();
            if(!$rpp || !$rppu)
                throw  new \Exception("Error Al Actualizar");
            $this->fz->mensaje  = "Usuario Actualizado Correctamente";
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            $this->fz->estado = 2;
            $this->fz->mensaje = $exception->getMessage();
        }
        return response()->json($this->fz);

    }
    public  function  activar(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try {
            $user = User::findOrFail($request->id);
            $user->condicion = 1;
            $rpta = $user->update();
            if(!$rpta)
                throw new \Exception("Error al Activar");
            $this->fz->mensaje ="Usuario Activado Correctamente";
        }catch (\Exception $exception){
            $this->fz->estado = 2;
            $this->fz->mensaje = $exception->getMessage();
        }
        return response()->json($this->fz);

    }
    public  function  Roles(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        $rol = Rol::select('id','nombre')
            ->where("condicion",'=','1')
            ->get();
        return response()->json($rol);
    }
    public  function  desactivar(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try {
            $user = User::findOrFail($request->id);
            $user->condicion = 0;
            $rpta = $user->update();
            if(!$rpta)
                throw new \Exception("Error al Desactivar");
            $this->fz->mensaje ="Usuario Desactivado Correctamente";
        }catch (\Exception $exception){
            $this->fz->estado = 2;
            $this->fz->mensaje = $exception->getMessage();
        }
        return response()->json($this->fz);
    }
}
