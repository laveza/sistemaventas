<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\Categoria;
use App\Paginador;
use App\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ArticuloController extends Controller{
    private $variables;
    public  function __construct () {
        $this->variables = new \stdClass();
        $this->variables->estado = 1;
        $this->variables->error = [];
        $this->variables->datos = [];
        $this->variables->mensaje = "";
    }
    public function index(Request $request){
        if(!$request->ajax()) return redirect("/");
        $search = isset($request->search) ? $request->search : "";
        $campos = isset($request->campo) ? $request->campo : "";
        $tamanio = isset($request->tamanio) ? intval($request->tamanio) : 5;
        $categoria = isset($request->categoria) ? $request->categoria : "";
        if ($search == "" && $categoria == "") {
            $articulo = Articulo::join("categorias", 'articulos.idcategoria', '=', 'categorias.id')
                ->select("articulos.id", 'articulos.idcategoria', 'articulos.nombre', 'articulos.codigo',
                    'categorias.nombre as categoria', 'articulos.precio_venta', 'articulos.stock', 'articulos.stock_inicial',
                    'articulos.descripcion', 'articulos.condicion','articulos.imagen')
                ->orderBy("articulos.id", 'desc')
                ->paginate($tamanio);
        } else if ($categoria != "") {
            $articulo = Articulo::join("categorias", 'articulos.idcategoria', '=', 'categorias.id')
                ->select("articulos.id", 'articulos.idcategoria', 'articulos.nombre', 'articulos.codigo',
                    'categorias.nombre as categoria', 'articulos.precio_venta', 'articulos.stock', 'articulos.stock_inicial',
                    'articulos.descripcion', 'articulos.condicion','articulos.imagen')
                ->where("articulos.{$campos}", 'like', "%{$search}%")
                ->where("articulos.idcategoria", 'like', "%{$categoria}%")
                ->orderBy("articulos.id", 'desc')
                ->paginate($tamanio);
        } else {
            $articulo = Articulo::join("categorias", 'articulos.idcategoria', '=', 'categorias.id')
                ->select("articulos.id", 'articulos.idcategoria', 'articulos.nombre', 'articulos.codigo',
                    'categorias.nombre as categoria', 'articulos.precio_venta', 'articulos.stock', 'articulos.stock_inicial',
                    'articulos.descripcion', 'articulos.condicion','articulos.condicion','articulos.imagen')
                ->where("articulos.{$campos}", 'like', "%{$search}%")
                ->orderBy("articulos.id", 'desc')
                ->paginate($tamanio);
        }
        $data = [];
        $img="";
        for ($i=0; $i < count($articulo) ; $i++) {
            if(empty($articulo[$i]->imagen)){
                $img = Storage::url("img/nofoto.png")."?img=".time();
            }else{
                $img = UploadFile::UrlImagen("articulos",$articulo[$i]->nombre,$articulo[$i]->imagen)."?img=".time();
            }
            $data[]=[
                "id"=>$articulo[$i]->id,
                "idcategoria"=>$articulo[$i]->idcategoria,
                "nombre"=>$articulo[$i]->nombre,
                "precio_venta"=>$articulo[$i]->precio_venta,
                "codigo"=>$articulo[$i]->codigo,
                "categoria"=>$articulo[$i]->categoria,
                "stock"=>$articulo[$i]->stock,
                "stock_inicial"=>$articulo[$i]->stock_inicial,
                "descripcion"=>$articulo[$i]->descripcion,
                "condicion"=>$articulo[$i]->condicion,
                "imagen"=>$img,
            ];
        }
        return response()->json([
            "paginacion" => [
                'total_registros' => $articulo->total(),
                'pagina_actual' => $articulo->currentPage(),
                'registro_pagina' => $articulo->perPage(),
                'ultima_pagina' => $articulo->lastPage(),
                "desde_pagina" => $articulo->firstItem() > 0 ? $articulo->firstItem() : 0,
                "hasta_pagina" => $articulo->lastItem() > 0 ? $articulo->lastItem() : 0,
                "NumeroPaginas" => $articulo->total() > 0 ? Paginador::paginate($articulo->currentPage(), $articulo->lastPage()) : [],
                "mensaje" => $articulo->total() > 0 ? '' : 'No hay datos',
            ],
            "articulos" => $data,
        ]);
    }
    public function categorias(Request $request){
        if (!$request->ajax()) return Redirect::to("/admin");


        $categorias = Categoria::select("id", "nombre")->where("condicion", "=", "1")->get();
        return response()->json($categorias);
    }
    public function store(Request $request){
        if(!$request->ajax())return \redirect("/admin");

        try {
            if(!$this->Validar($request))
                throw new \Exception("Verificar Errores", 1);

            $producto = UploadFile::LimpiarTexto($request->producto)->get();
            $img = UploadFile::setImage($request->imagen,"articulos",$producto,$request->codigo);
            if(!$img){
                $img ="";
            }


            $articulo = new Articulo();
            $articulo->nombre=$request->producto;
            $articulo->idcategoria=$request->idcategoria;
            $articulo->precio_venta=$request->precio_venta;
            $articulo->stock=$request->stock;
            $articulo->stock_inicial=$request->stock_inicial;
            $articulo->descripcion=$request->descripcion;
            $articulo->codigo=$request->codigo;
            $articulo->imagen = $img;
            $articulo->condicion=1;
            $rpta = $articulo->save();
            if(!$rpta)
                throw new \Exception("Error al Registrar", 1);

            $this->variables->mensaje ="Articulo Registrado Correctamente";
        } catch (\Exception $ex) {
            $this->variables->estado = 2;
            $this->variables->mensaje = $ex->getMessage();
        }

        return \response()->json($this->variables);
    }
    public function update(Request $request){

        if(!$request->ajax())return \redirect("/admin");
        try {
            if(!$this->Validar($request))
                throw new \Exception("Verificar Errores", 1);
            $articulo = Articulo::findOrFail($request->id);
            $articulo->nombre = $request->producto;
            $articulo->idcategoria = $request->idcategoria;
            $articulo->precio_venta = $request->precio_venta;
            $articulo->stock = $request->stock;
            $articulo->stock_inicial = $request->stock_inicial;
            $articulo->descripcion = $request->descripcion;
            $articulo->codigo = $request->codigo;
            if($request->editar == "true"){
                $producto = UploadFile::LimpiarTexto($request->producto)->get();
                $img = UploadFile::setImage($request->imagen,"articulos",$producto,$request->codigo,true);
                if(!$img)
                    throw new \Exception("No se guardo la Imagen");
                $articulo->imagen = $img;
            }
            $articulo->condicion = 1;
            $rpta = $articulo->update();
            if(!$rpta)
                throw new \Exception("Error al Actualizar", 1);

            $this->variables->mensaje ="Articulo Actualizado Correctamente";
        } catch (\Exception $ex) {
            $this->variables->estado = 2;
            $this->variables->mensaje = $ex->getMessage();
        }
        return \response()->json($this->variables);
    }
    public function activar(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try {
            $articulo = Articulo::findOrFail($request->id);
            $articulo->condicion=1;
            $rpta = $articulo->update();
            if(!$rpta)
                throw new \Exception("No se pudo Activar el Articulo", 1);
            $this->variables->mensaje = "Articulo Activado Correctamente";
        } catch (\Exception $ex) {
            $this->variables->estado = 2;
            $this->variables->mensaje = $ex->getMessage();
        }
        return response()->json($this->variables);
    }
    public function desactivar(Request $request){
        if(!$request->ajax()) \redirect("/admin");
        try {
            $articulo = Articulo::findOrFail($request->id);
            $articulo->condicion=0;
            $rpta = $articulo->update();
            if(!$rpta)
                throw new \Exception("No se pudo Desactivar el Articulo", 1);
            $this->variables->mensaje = "Articulo Desactivado Correctamente";
        } catch (\Exception $ex) {
            $this->variables->estado = 2;
            $this->variables->mensaje = $ex->getMessage();
        }
        return response()->json($this->variables);
    }
    protected function Validar($request){
        $rpta = false;
        $rt = array();
        if(empty($request->producto)){
            array_push($this->variables->error,"campo producto obligatorio");
            $rt[0]=false;
        }else{
            if(\preg_match("/^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]+$/",$request->producto)){
                array_push($this->variables->error,"");
                $rt[0]=true;
            }else{
                array_push($this->variables->error, "campo producto solo letra");
                $rt[0] = false;
            }
        }
        if(empty($request->idcategoria)){
            array_push($this->variables->error,"seleccione una categoria");
            $rt[1]=false;
        }else{
            array_push($this->variables->error,"");
            $rt[1]=true;
        }
        if(empty($request->precio_venta)){
            array_push($this->variables->error,"campo precio de venta obligatorio");
            $rt[2]=false;
        }else{
            if(\preg_match("/^[0-9.]+$/",$request->precio_venta)){
                array_push($this->variables->error,"");
                $rt[2]=true;
            }else{
                array_push($this->variables->error,"campo precio de venta decimal");
                $rt[2]=false;
            }
        }
        if(empty($request->stock)){
            array_push($this->variables->error,"campo stock obligatorio");
            $rt[3]=false;
        }else{
            if(preg_match("/^[0-9]+$/",$request->stock)){
                array_push($this->variables->error,"");
                $rt[3]=true;
            }else{
                array_push($this->variables->error,"campo stock solo permite números");
                $rt[3]=false;
            }

        }
        if(empty($request->stock_inicial)){
            array_push($this->variables->error,"campo stock inicial obligatorio");
            $rt[4]=false;
        }else{
            if(preg_match("/^[0-9]+$/",$request->stock_inicial)){
                array_push($this->variables->error, "");
                $rt[4] = true;
            }else{
                array_push($this->variables->error, "campo stock inicial solo números");
                $rt[4] = false;
            }
        }
        if(empty($request->descripcion)){
            array_push($this->variables->error,"");
            $rt[5]=true;
        }else{
            if(\preg_match("/^[0-9a-zA-ZÁÉÍÓÚÑáéíóúñ ]+$/",$request->descripcion)){
                array_push($this->variables->error,"");
                $rt[5]=true;
            }else{
                array_push($this->variables->error,"no se permiten caracteres especiales.");
                $rt[5]=false;
            }

        }
        if(empty($request->codigo)){
            array_push($this->variables->error,"campo codigo obligatorio");
            $rt[6]=false;
        }else{
            $n = strlen($request->codigo);
            if(intval($n) == 11){
                if(preg_match("/^[0-9]+$/",$request->codigo)){
                    array_push($this->variables->error,"");
                    $rt[6]=true;
                }else{
                    array_push($this->variables->error,"se permite solo números");
                    $rt[6]=false;
                }
            }else{
                array_push($this->variables->error, "El codigo debe ser 11 números");
                $rt[6] = false;
            }

        }
        if($rt[0]  &&  $rt[1] && $rt[2] && $rt[3] && $rt[4] && $rt[5] && $rt[6]){
            $rpta=true;
        }
        return $rpta;
    }
}
