<template>
    <main class="form-group animated fadeIn">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card card-primary card-outline card-outline-tabs nav-justified">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a href="javascript:void(0)" @click="listado()" class="nav-link" :class="{'active':!tabs.active}">
                                    Listado
                                </a>

                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0)" @click="mantenimiento(`usuario`,`store`,null)" class="nav-link" :class="{'active':tabs.active}">
                                    Mantenimiento
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body" :class="{'p-0':tabs.active}">
                        <div class="tab-content">
                            <div class="tab-pane fade" :class="{'active':!tabs.active,'show':!tabs.show}">
                                <div class="row">
                                    <div class="col-md-6 col-sm-7 form-group">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <select class="input-group-text custom-select" v-model="busquedas.criterio">
                                                    <option value="nombre">Nombre</option>
                                                    <option value="num_documento">Nº Documento</option>
                                                    <option value="telefono">Teléfono</option>
                                                    <option value="email">Email</option>
                                                </select>
                                            </div>
                                            <input type="text" v-model="busquedas.search" class="form-control" placeholder="buscar texto..."
                                                   @keyup="all(1,`${busquedas.search}`,`${busquedas.criterio}`,`${busquedas.tamanio}`)">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-success btn-sm">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-5 d-flex align-items-center justify-content-end form-group">
                                        <label for="" class="col-md-4 col-sm-9 text-sm" style="margin:0">Registros por Páginas:</label>
                                        <select class="col-md-2 col-3 col-sm-3 custom-select" v-model="busquedas.tamanio"
                                                @change="all(1,`${busquedas.search}`,`${busquedas.criterio}`,`${busquedas.tamanio}`)">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="25">25</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive-sm table-responsive table-responsive-lg table-responsive-xl table-responsive-md">
                                            <table class="table table-sm table-hover table-striped table-bordered">
                                                <thead class="bg-info text-sm text-white text-center text-uppercase">
                                                    <tr>
                                                        <th>Accion</th>
                                                        <th>Nombres</th>
                                                        <th>Nº Doc.</th>
                                                        <th>direccion</th>
                                                        <th>teléfono</th>
                                                        <th>Usuario</th>
                                                        <th>Rol</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <template v-if="listArray.length > 0">
                                                    <tr v-for="row in listArray" :key="row.id">
                                                        <td>
                                                            <div class="btn-group-vertical">
                                                                <div class="btn-group">
                                                                    <button type="button" data-toggle="dropdown" class="btn btn-sm btn-default  btn-flat dropdown-toggle dropdown-icon">
                                                                        <span class="mr-2">Accion</span>
                                                                        <div role="menu" class="dropdown-menu">
                                                                            <a href="javascript:void(0)" @click="mantenimiento('usuario','update',row)" class="dropdown-item text-primary">
                                                                                <i class="fas fa-edit"></i>
                                                                                <span>Editar</span>
                                                                            </a>
                                                                            <a href="javascript:void(0)" class="dropdown-item text-danger">
                                                                                <i class="fas fa-eye "></i>
                                                                                <span>Ver Más..</span>
                                                                            </a>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="ellipses" v-text="row.nombre"></span>
                                                        </td>
                                                        <td>
                                                            <span  v-text="row.tipo_documento+'-'+row.num_documento"></span>
                                                        </td>
                                                        <td>
                                                            <span class="ellipses ellipses-sm" v-text="row.direccion"></span>
                                                        </td>
                                                        <td>
                                                            <span  v-text="row.telefono"></span>
                                                        </td>
                                                        <td>
                                                            <span class="ellipses ellipses-sm" v-text="row.usuario"></span>
                                                        </td>
                                                        <td>
                                                            <span class="ellipses ellipses-sm" v-text="row.nombre_rol"></span>
                                                        </td>
                                                        <td>
                                                            <template  v-if="row.condicion">
                                                                <span class="badge-success badge">Activo</span>
                                                            </template>
                                                            <template v-else>
                                                                <span class="badge badge-danger">Inactivo</span>
                                                            </template>
                                                        </td>
                                                    </tr>
                                                </template>
                                                <template v-else>
                                                    <tr>
                                                        <td colspan="8" class="text-center text-uppercase" v-text="paginacion.mensaje"></td>
                                                    </tr>
                                                </template>
                                                <template v-if="body_item">
                                                    <tr class="body-item">
                                                        <td colspan="8"></td>
                                                    </tr>
                                                </template>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <nav class="d-flex align-items-center flex-wrap">
                                            <div class="col-md-7">
                                                <ul class="pagination float-left m-0">
                                                    <li class="page-item" :class="[isActived > 1 ? '' : 'disabled']">
                                                        <a href="javascript:void(0)" @click.prevent="cambiarPage(isActived - 1)" class="page-link">Anterior</a>
                                                    </li>
                                                    <li class="page-item" :key="page" v-for="page in  paginacion.NumeroPaginas" :class="{'active': page === isActived}">
                                                        <a href="javascript:void(0)" @click.prevent="cambiarPage(page)" class="page-link" v-text="page"></a>
                                                    </li>
                                                    <li class="page-item" :class="[isActived < paginacion.ultima_pagina ? '' : 'disabled']">
                                                        <a href="javascript:void(0)" @click.prevent="cambiarPage(isActived + 1)" class="page-link">Siguiente</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-5 d-flex justify-content-end align-items-center">
                                                <div class="">
                                                    <label for="">Mostrando</label>
                                                    <label for="" v-text="desde"></label>
                                                    <label for="">Hasta</label>
                                                    <label for="" v-text="hasta"></label>
                                                    <label for="">de</label>
                                                    <label for="" v-text="totalRegistros"></label>
                                                    <label for="">Registros</label>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" :class="{'active':tabs.active,'show':tabs.show}">
                                <div class="card mt-2" v-bind:style="[tabs.active ? {marginBottom:0} : '']">
                                    <div class="card-header  bg-info" v-bind:style="[tabs.active ? {borderTopLeftRadius:0,borderTopRightRadius:0} : '']">
                                        <template v-if="tabs.mantenimiento">
                                            <h4 class="card-title text-sm text-uppercase" v-text="tabs.title" ></h4>
                                        </template>
                                        <template v-else>
                                            <h4 class="card-title text-sm text-uppercase" v-text="tabs.title" ></h4>
                                        </template>
                                    </div>
                                    <template v-if="tabs.mantenimiento">
                                        <div class="card-body">
                                            <form>
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-append">
                                                                <select v-model="consulta.tipo" class="input-group-text custom-select">
                                                                    <option value="dni">DNI</option>
                                                                    <option value="ruc">RUC</option>
                                                                </select>
                                                            </div>
                                                            <input type="text" v-model="consulta.numero" class="form-control" placeholder="buscar...">
                                                            <div class="input-group-prepend">
                                                                <template v-if="consulta.buscar">
                                                                    <button class="btn btn-success" type="button" @click.prevent="consultar()">
                                                                        <i class="fas fa-search"></i>
                                                                    </button>
                                                                </template>
                                                                <template v-else>
                                                                    <button class="btn btn-success" type="button"  disabled >
                                                                        buscando.....
                                                                    </button>
                                                                </template>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="text-uppercase">Nombres</label>
                                                        <input v-model="usuarios.nombre" type="text" class="form-control" placeholder="nombres.." readonly>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="text-uppercase">Dirección</label>
                                                        <input type="text" class="form-control" placeholder="ingresar direccion..." v-model="usuarios.direccion">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label  class="text-uppercase">tipo documento</label>
                                                        <select  v-model="usuarios.tipo_documento" class="custom-select">
                                                            <option value="DNI">DNI</option>
                                                            <option value="RUC">RUC</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label  class="text-uppercase">N° de documento</label>
                                                        <input type="text" class="form-control" placeholder="numero de documento" v-model="usuarios.num_documento" readonly>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label  class="text-uppercase">Teléfono</label>
                                                        <input type="text" class="form-control" placeholder="numero de teléfono" v-model="usuarios.telefono">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label  class="text-uppercase">Email</label>
                                                        <input type="text" class="form-control" placeholder="ingres su email" v-model="usuarios.email">
                                                    </div>
                                                </div>
                                                <template v-if="tabs.cuenta">

                                                    <label for="" class="text-uppercase text-danger">Crear Cuenta</label>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4 form-group">
                                                            <label class="text-uppercase">Usuario</label>
                                                            <input type="text" v-model="usuarios.usuario" class="form-control" placeholder="* usuario">
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label class="text-uppercase">Contraseña</label>
                                                            <input type="text" v-model="usuarios.password" class="form-control" placeholder="* contraseña">
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label class="text-uppercase">Roles</label>
                                                            <select v-model="usuarios.idrol" class="custom-select">
                                                                <option value="0">Seleccionar</option>
                                                                <option v-for="rol in listRol" :key="rol.id" :value="rol.id" v-text="rol.nombre"></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="col-md-4 form-group">
                                                        <label class="text-uppercase">Roles</label>
                                                        <select v-model="usuarios.idrol" class="custom-select">
                                                            <option value="0">Seleccionar</option>
                                                            <option v-for="rol in listRol" :key="rol.id" :value="rol.id" v-text="rol.nombre"></option>
                                                        </select>
                                                    </div>
                                                </template>
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <div class="d-flex justify-content-end">
                                                            <div>
                                                                <button type="button" @click="listado()" class="btn btn-danger">
                                                                    Cancelar
                                                                </button>
                                                                <template v-if="accion">
                                                                    <button type="button" @click.prevent="store()" class="btn btn-success">
                                                                        Guardar
                                                                    </button>
                                                                </template>
                                                                <template v-else>
                                                                    <button type="button" @click.prevent="update()" class="btn btn-success">
                                                                        Actualizar
                                                                    </button>
                                                                </template>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="card-body">
                                            <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                                                Tooltip on top
                                            </button>
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
   export default {
       data(){
           return{
               listArray:[],
               usuarios:{
                   nombre:'',
                   tipo_documento:'DNI',
                   num_documento:'',
                   direccion:'',
                   telefono:'',
                   email:'',
                   usuario:'',
                   password:'',
                   idrol:0,
                   id:0,
                   idpersona:0,
               },
               paginacion:{
                   total_registros:0,
                   pagina_actual:0,
                   registro_pagina:0,
                   ultima_pagina:0,
                   desde_pagina:0,
                   hasta_pagina:0,
                   NumeroPaginas:0,
                   mensaje:'',
               },
               busquedas:{
                   search:'',
                   criterio:'nombre',
                   tamanio:5,
               },
               tabs:{
                   active:0,
                   show:0,
                   mantenimiento:1,
                   title:'',
                   cuenta:1,

               },
               consulta:{
                   tipo:'dni',
                   numero:'',
                   buscar:1,
               },
               body_item:0,
               accion:1,
               listRol:[],
           }
       },
       computed:{
           isActived:function () {
               return this.paginacion.pagina_actual;
           },
           desde: function () {
               return this.paginacion.desde_pagina;
           },
           hasta: function () {
               return this.paginacion.hasta_pagina;
           },
           totalRegistros: function () {
               return this.paginacion.total_registros;
           },
       },
       methods:{
           all(page,search,criterio,tamanio){
               this.body_item = 1;
               axios.get(`/admin/usuarios?page=${page}&search=${search}&criterio=${criterio}&tamanio=${tamanio}`)
               .then(r=>{
                   this.listArray = r["data"]["usuarios"]["data"];
                   this.paginacion = r["data"]["paginacion"];
                   this.body_item = 0;
               }).catch(e=>{
                   this.success("Ocurrió un error en la peticion,revise la consola del navegador");
                   console.log(e);
               })
           },
           store(){
               axios.post("/admin/usuarios/registrar",this.campos())
               .then(r=>{
                   switch (r["data"]["estado"]) {
                       case  1:{
                            this.cancelar();
                            this.success(r["data"]["mensaje"]);
                           break;
                       }
                       case 2:{
                           this.error(r["data"]["mensaje"]);
                           break;
                       }
                   }
               })
           },
           update(){
               axios.put("/admin/usuarios/editar",this.campos())
               .then(r=>{
                   switch (r["data"]["estado"]) {
                       case 1:{
                           this.cancelar();
                           this.success(r["data"]["mensaje"]);
                            break;
                       }
                       case 2:{
                           this.error(r["data"]["mensaje"]);
                           break;
                       }
                   }
               }).catch(e=>{
                  console.log(e);
               });
           },
           roles(){
               axios.get("/admin/roles-usuarios")
               .then(r=>{
                   this.listRol = r["data"];
               }).catch(e=>{
                   this.error('Error en el Servidor Revise la consola');
                   console.log("Error en =>",e);
               })
           },
           cambiarPage(page){
               this.all(`${page}`,`${this.busquedas.search}`,`${this.busquedas.criterio}`,`${this.busquedas.tamanio}`);
           },
           listado(){
               this.tabs.active = 0;
               this.tabs.show = 0;
               this.limpiar();
           },
           mantenimiento(modelo,accion,data=[]){
               switch(modelo) {
                   case 'usuario':{
                       switch (accion) {
                           case 'store':{
                               this.tabs.active = 1;
                               this.tabs.show = 1;
                               this.tabs.title = 'Registrar Usuario';
                               this.tabs.cuenta=1;
                               this.accion = 1;
                               this.limpiar();
                               break;
                           }
                           case  'update':{
                               this.tabs.active = 1;
                               this.tabs.show = 1;
                               this.tabs.cuenta=0;
                               this.tabs.title = "Actualizar Usuario";
                               this.accion = 0;
                               this.usuarios.id = data.id;
                               this.usuarios.idpersona = data.id;
                               this.usuarios.nombre = data.nombre;
                               this.usuarios.tipo_documento = data.tipo_documento;
                               this.usuarios.num_documento = data.num_documento;
                               this.usuarios.direccion = data.direccion;
                               this.usuarios.telefono = data.telefono;
                               this.usuarios.email = data.email;
                               this.usuarios.idrol = data.idrol;
                               break;
                           }
                           case 'information':{
                               break;
                           }

                       }
                       break;
                   }
               }
           },
           cancelar(){
               this.listado();
               this.all(1,`${this.busquedas.search}`,`${this.busquedas.criterio}`,`${this.busquedas.tamanio}`);
           },
           consultar(){
               this.consulta.buscar = 0;
               axios.get(`/admin/cliente/consulta?tipo=${this.consulta.tipo}&numero=${this.consulta.numero}`)
                   .then(response=>{
                       this.consulta.buscar = 1;
                       let data=response["data"]["datos"];
                       switch (response.data.estado) {
                           case 1:{
                               this.usuarios.nombre = data['result']["razon"];
                               this.usuarios.num_documento = data['result']["numero"];
                               this.usuarios.tipo_documento = data['tipo'];
                               break;
                           }
                           case 2:{
                               this.error(response["data"]["mensaje"]);
                               break;
                           }
                       }
                   }).catch(error=>{
                   console.log(error);
               });
           },
           campos(){
               return{
                   nombre : this.usuarios.nombre,
                   tipo_documento : this.usuarios.tipo_documento,
                   num_documento : this.usuarios.num_documento,
                   direccion : this.usuarios.direccion,
                   telefono : this.usuarios.telefono,
                   email : this.usuarios.email,
                   usuario : this.usuarios.usuario,
                   password : this.usuarios.password,
                   idrol : this.usuarios.idrol,
                   id : this.usuarios.id,
                   idpersona : this.usuarios.idpersona,
               }
           },
           success(sms){
               toastr.success(sms);
           },
           error(sms){
               toastr.error(sms);
           },
           limpiar(){
               this.usuarios.nombre = '';
               this.usuarios.tipo_documento = 'DNI';
               this.usuarios.num_documento='';
               this.usuarios.direccion='';
               this.usuarios.telefono='';
               this.usuarios.email="";
               this.usuarios.usuario="";
               this.usuarios.password="";
               this.usuarios.idrol=0;
               this.usuarios.id=0;
               this.usuarios.idpersona=0;
               this.consulta.numero = '';
               this.consulta.tipo = 'dni';
           }
       },
       mounted() {
           this.roles();
           this.all(1,`${this.busquedas.search}`,`${this.busquedas.criterio}`,`${this.busquedas.tamanio}`);
       }
   }
</script>

<style scoped>

</style>
