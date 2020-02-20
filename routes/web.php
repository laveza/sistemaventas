<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']],function (){
    Route::get("/logeo","Auth\LoginController@init")->name("logeo");
    Route::get("/","Auth\LoginController@showLoginForm");
    Route::post("/iniciar-sesion","Auth\LoginController@iniciarsesion");
});
Route::group(['middleware' => ['auth']],function (){

    //CERRAR SESSION
    Route::post("/logout","Auth\LoginController@cerraSession")->name("logout");
    Route::get('/admin', function () {
        return view('layouts.contenido.contenido');
    })->name("admin");

    /** RUTA PARA EL ALMACENERO */
    Route::group(["middleware" => ['Almacenero']],function (){

        /** MODELO CATEGORIA */
        Route::get("/admin/categoria",'CategoriaController@index');
        Route::post("/admin/categoria/registrar","CategoriaController@store");
        Route::put("/admin/categoria/editar","CategoriaController@update");
        Route::put("/admin/categoria/activar","CategoriaController@Activar");
        Route::put("/admin/categoria/desactivar","CategoriaController@Desactivar");

        /** MODELO ARTICULOS */
        Route::get("/admin/articulos",'ArticuloController@index');
        Route::post("admin/articulos/registrar",'ArticuloController@store');
        Route::post("/admin/articulos/editar", 'ArticuloController@update');
        Route::put("/admin/articulos/activar","ArticuloController@activar");
        Route::put("/admin/articulos/desactivar","ArticuloController@desactivar");
        Route::get("/admin/categorias/lista","ArticuloController@categorias");

        /** MODELO INGRESO */
        Route::get("/admin/ingreso","IngresoController@index");
        Route::post("/admin/ingreso/registrar","IngresoController@store");
        Route::put("/admin/ingreso/desactivar","IngresoController@desactivar");
        /** MODELO  PROVEEDOR-PERSONA */
        Route::get("/admin/proveedor","ProveedorController@index");
        Route::get("/admin/proveedor/consulta","ProveedorController@consulta");
        Route::post("/admin/proveedor/registrar","ProveedorController@store");
        Route::put("/admin/proveedor/editar","ProveedorController@update");
    });

    Route::group(["middleware" => ['Vendedor']],function (){
        /** MODELO CLIENTE-PERSONA */
        Route::get("/admin/cliente","ClienteController@index");
        Route::post("/admin/cliente/registrar","ClienteController@store");
        Route::put("/admin/cliente/editar","ClienteController@update");
        Route::get("/admin/cliente/consulta","ClienteController@consulta");
    });

    Route::group(['middleware' => ["Administrador"]],function (){
        /** MODELO CATEGORIA */
        Route::get("/admin/categoria",'CategoriaController@index');
        Route::post("/admin/categoria/registrar","CategoriaController@store");
        Route::put("/admin/categoria/editar","CategoriaController@update");
        Route::put("/admin/categoria/activar","CategoriaController@Activar");
        Route::put("/admin/categoria/desactivar","CategoriaController@Desactivar");

        /** MODELO ARTICULOS */
        Route::get("/admin/articulos",'ArticuloController@index');
        Route::post("admin/articulos/registrar",'ArticuloController@store');
        Route::post("/admin/articulos/editar", 'ArticuloController@update');
        Route::put("/admin/articulos/activar","ArticuloController@activar");
        Route::put("/admin/articulos/desactivar","ArticuloController@desactivar");
        Route::get("/admin/categorias/lista","ArticuloController@categorias");

        /** MODELO  PROVEEDOR-PERSONA */
        Route::get("/admin/proveedor","ProveedorController@index");
        Route::get("/admin/proveedor/consulta","ProveedorController@consulta");
        Route::post("/admin/proveedor/registrar","ProveedorController@store");
        Route::put("/admin/proveedor/editar","ProveedorController@update");

        /** MODELO INGRESO */
        Route::get("/admin/ingreso","IngresoController@index");
        Route::post("/admin/ingreso/registrar","IngresoController@store");
        Route::put("/admin/ingreso/desactivar","IngresoController@desactivar");

        /** MODELO CLIENTE-PERSONA */
        Route::get("/admin/cliente","ClienteController@index");
        Route::post("/admin/cliente/registrar","ClienteController@store");
        Route::put("/admin/cliente/editar","ClienteController@update");
        Route::get("/admin/cliente/consulta","ClienteController@consulta");
        /** MODELO USUARIOS-PERSONA */
        Route::get("/admin/usuarios","UserController@index")->name("users");
        Route::get("/admin/roles-usuarios","UserController@Roles");
        Route::post("/admin/usuarios/registrar","UserController@store");
        Route::put("/admin/usuarios/editar","UserController@update");
        Route::put("/admin/usuarios/activar","UserController@activar");
        Route::put("/admin/usuarios/desactivar","UserController@desactivar");
        Route::get("/admin/roles","RolController@index");
        Route::get("/reload","Auth\LoginController@reload");
    });
});
