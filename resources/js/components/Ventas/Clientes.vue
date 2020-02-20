<template>
    <main class="animated fadeIn">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs nav-justified" id="custom-tabs-three-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" @click="listado()" :class="[!tabs.active ? 'active':'']"  href="javascript:void(0)" role="tab" aria-controls="custom-tabs-three-home" aria-selected="false">
                                    Listado
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" @click="mantenimiento('cliente','insertar')" :class="[tabs.active ? 'active':'']"  href="javascript:void(0)" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false" >
                                    Mantenimiento
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <div class="tab-pane fade" :class="[!tabs.active ? 'active' : '',!tabs.show ? 'show' : '']"  role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-lg-6 form-group">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <select class="custom-select input-group-text" v-model="criterio" @change="Opciones">
                                                    <option value="nombre">Nombre</option>
                                                    <option value="num_documento">N° de Documento</option>
                                                    <option value="email">Email</option>
                                                    <option value="telefono">Telefono</option>
                                                </select>
                                            </div>
                                            <input :type="options.type" class="form-control" @keyup="all(`${1}`,`${search}`,`${criterio}`,`${tamanio}`)" v-model="search" :placeholder="'buscar por '+ options.placeholder">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-lg-6">
                                        <div class="d-flex justify-content-end">
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Registros Por Paginas :</span>
                                                    </div>
                                                    <select class="custom-select col-4" v-model="tamanio" @change="all(`${1}`,`${search}`,`${criterio}`,`${tamanio}`)">
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="15">15</option>
                                                        <option value="20">20</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-sm table-bordered">
                                                <thead class="bg-info text-white text-uppercase text-center">
                                                <tr>
                                                    <th>Acciones</th>
                                                    <th>Cliente</th>
                                                    <th>T. de doc.</th>
                                                    <th>N. de doc.</th>
                                                    <th>direccion</th>
                                                    <th>teléfono</th>
                                                    <th>email</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <template v-if="listarArray.length > 0">
                                                    <tr v-for="row in listarArray" :key="row.id">
                                                        <td class="text-center">
                                                            <div class="btn-group-vertical">
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-sm btn-default  btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                                        <span class="mr-2">Accion</span>
                                                                        <div class="dropdown-menu" role="menu">
                                                                            <a class="dropdown-item text-primary" href="javascript:void(0)" @click="mantenimiento('cliente','update',row)">
                                                                                <i class="fas fa-edit"></i>
                                                                                <span>Editar</span>
                                                                            </a>
                                                                            <a class="dropdown-item text-danger" @click="mantenimiento('cliente','ver-informacion',row)" href="javascript:void(0)">
                                                                                <i class="fas fa-eye "></i>
                                                                                <span>Ver</span>
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
                                                            <span class="ellipses ellipses-sm"  v-text="row.tipo_documento"></span>
                                                        </td>
                                                        <td>
                                                            <span class="ellipses-sm ellipses" v-text="row.num_documento"></span>
                                                        </td>
                                                        <td>
                                                            <span class="ellipses" v-text="row.direccion"></span>
                                                        </td>
                                                        <td v-text="row.telefono"></td>
                                                        <td >
                                                            <span class="ellipses" v-text="row.email"></span>
                                                        </td>
                                                    </tr>
                                                </template>
                                                <template v-else>
                                                    <tr>
                                                        <td colspan="7" class="text-center" v-text="paginacion.mensaje"></td>
                                                    </tr>
                                                </template>
                                                <template v-if="load">
                                                    <tr class="body-item">
                                                        <td colspan="7"></td>
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
                            <div class="tab-pane fade" :class="[tabs.active ? 'active' : '',tabs.show ? 'show' : '']"  role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                <div class="card">
                                    <div class="card-header  bg-info">
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
                                                        <input v-model="cliente.nombre" type="text" class="form-control" placeholder="nombres.." readonly>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="text-uppercase">Dirección</label>
                                                        <input type="text" class="form-control" placeholder="ingresar direccion..." v-model="cliente.direccion">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label  class="text-uppercase">tipo documento</label>
                                                        <select  v-model="cliente.tipo_documento" class="custom-select">
                                                            <option value="DNI">DNI</option>
                                                            <option value="RUC">RUC</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label  class="text-uppercase">N° de documento</label>
                                                        <input type="text" class="form-control" placeholder="numero de documento" v-model="cliente.num_documento" readonly>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label  class="text-uppercase">Teléfono</label>
                                                        <input type="text" class="form-control" placeholder="numero de teléfono" v-model="cliente.telefono">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label  class="text-uppercase">Email</label>
                                                        <input type="text" class="form-control" placeholder="ingres su email" v-model="cliente.email">
                                                    </div>
                                                </div>
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
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        data(){
            return{
                listarArray:[],
                cliente:{
                    id:0,
                    nombre:'',
                    tipo_documento:'DNI',
                    num_documento:'',
                    direccion:'',
                    telefono:'',
                    email:'',
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
                tabs:{
                    active:0,
                    show:0,
                    title:'Registrar',
                    mantenimiento : 1,
                },
                options:{
                    placeholder:'nombre',
                    type:'text',
                },
                load:0,
                criterio:'nombre',
                search:'',
                tamanio:5,
                consulta:{
                    tipo:'dni',
                    numero:'',
                    buscar:1,
                },
                accion:1,
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
                this.load = 1;
                axios.get(`/admin/cliente?page=${page}&search=${search}&criterio=${criterio}&tamanio=${tamanio}`)
                .then(response=>{
                    this.load  = 0;
                    this.listarArray = response["data"]["clientes"]["data"];
                    this.paginacion = response["data"]["paginacion"];
                }).catch(response=>{
                    console.log(response);
                });
            },
            store(){
                var datos={
                    nombre:this.cliente.nombre,
                    tipo_documento : this.cliente.tipo_documento,
                    num_documento : this.cliente.num_documento,
                    direccion : this.cliente.direccion,
                    telefono:this.cliente.telefono,
                    email:this.cliente.email,
                };
                axios.post("/admin/cliente/registrar",datos)
                .then(r=>{
                   switch (r["data"]["estado"]) {
                       case 1:{
                           this.success(r["data"]["mensaje"]);
                           this.cancelar();
                           break;
                       }
                       case  2:{
                           this.success(r["data"]["mensaje"]);
                           break;
                       }
                   }
                }).catch(e=>{
                    this.error(e);
                })
            },
            update(){
                var datos={
                    id:this.cliente.id,
                    nombre:this.cliente.nombre,
                    tipo_documento : this.cliente.tipo_documento,
                    num_documento : this.cliente.num_documento,
                    direccion : this.cliente.direccion,
                    telefono:this.cliente.telefono,
                    email:this.cliente.email,
                };
                axios.put("/admin/cliente/editar",datos)
                .then(r=>{
                   switch (r["data"]["estado"]) {
                       case 1:{
                           this.success(r["data"]["mensaje"]);
                           this.cancelar();
                           break;
                       }
                       case 2:{
                           this.error(r["data"]["mensaje"]);
                           break;
                       }
                   }
                }).catch(e =>{
                    console.log(e);
                });
            },
            listado(){
                this.tabs.show = 0;
                this.tabs.active = 0;
                this.tabs.title="Registrar";
                this.limpiar();
            },
            cancelar(){
              this.listado();
              this.all(`${1}`,`${this.search}`,`${this.criterio}`,`${this.tamanio}`);
            },
            mantenimiento(modelo,accion,data=[]){
                switch (modelo) {
                    case 'cliente': {
                        switch (accion) {
                            case 'insertar':{
                                this.tabs.show = 1;
                                this.tabs.active = 1;
                                this.tabs.title ="Registrar Nuevo Cliente";
                                this.tabs.mantenimiento =1;
                                this.accion = 1;
                                break;
                            }
                            case 'update':{
                                this.tabs.show = 1;
                                this.tabs.active = 1;
                                this.tabs.title ="Actualizando Cliente " + data.nombre;
                                this.accion = 0;
                                this.cliente.id = data.id;
                                this.cliente.nombre = data.nombre;
                                this.cliente.tipo_documento = data.tipo_documento;
                                this.cliente.num_documento = data.num_documento;
                                this.cliente.email = data.email;
                                this.cliente.telefono = data.telefono;
                                this.cliente.direccion = data.direccion;
                                this.tabs.mantenimiento = 1;
                                break;
                            }
                            case 'ver-informacion':{
                                this.tabs.show = 1;
                                this.tabs.active = 1;
                                this.tabs.mantenimiento  =0;
                                this.tabs.title = `Ver Informacion de: ${data.nombre}`;
                                break;
                            }
                        }
                        break;
                    }
                }
            },
            Opciones(e){

               if(e.target.value === "nombre"){
                   this.options.placeholder = " nombre";
                   this.options.type = "text";
               }else if(e.target.value === 'num_documento'){
                   this.options.placeholder = " número de documento";
                   this.options.type = "number";
               }else if (e.target.value === 'email'){
                   this.options.placeholder = " email";
                   this.options.type = "email";
               }else{
                   this.options.placeholder = " teléfono";
                   this.options.type = "number";
               }
            },
            consultar(){
                this.consulta.buscar = 0;
                axios.get(`/admin/cliente/consulta?tipo=${this.consulta.tipo}&numero=${this.consulta.numero}`)
                .then(response=>{
                    this.consulta.buscar = 1;
                    let data=response["data"]["datos"];
                    switch (response.data.estado) {
                        case 1:{
                            this.cliente.nombre = data['result']["razon"];
                            this.cliente.num_documento = data['result']["numero"];
                            this.cliente.tipo_documento = data['tipo'];
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
            error(sms){
                toastr.error(sms);
            },
            success(sms){
                toastr.success(sms);
            },
            limpiar(){
                this.cliente.id=0;
                this.cliente.nombre = '';
                this.cliente.tipo_documento = 'DNI';
                this.cliente.num_documento = '';
                this.cliente.email = '';
                this.cliente.telefono = '';
                this.cliente.direccion = '';
            },
            cambiarPage(page){
                this.all(`${page}`,`${this.search}`,`${this.criterio}`,`${this.tamanio}`);
            }
        },
        mounted() {
            this.all(1,`${this.search}`,`${this.criterio}`,`${this.tamanio}`);
        }
    }
</script>
