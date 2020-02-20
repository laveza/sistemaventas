<template>
    <main class="form-group animated fadeIn">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" @click="listado()" :class="{'active':!tabs.active}"  href="javascript:void(0)" role="tab">
                                    Listado
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" @click="acciones(`proveedores`,`insertar`)" :class="{'active': tabs.active}" href="javascript:void(0)" role="tab">
                                    Mantenimiento
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <div class="tab-pane fade" :class="{'active':!tabs.active,'show':!tabs.show}" role="tabpanel">
                               <div class="row">
                                   <div class="col-md-6 form-group">
                                       <div class="input-group">
                                           <div class="input-group-append">
                                               <select class="input-group-text custom-select" @change="SelectOpciones" v-model="busquedas.criterio">
                                                   <option value="personas.nombre">Nombre</option>
                                                   <option value="personas.num_documento">N° Documento</option>
                                                   <option value="personas.email">Email</option>
                                                   <option value="personas.telefono">Telefono</option>
                                                   <option value="proveedores.telefono_contacto">T. del Contacto</option>
                                               </select>
                                           </div>
                                           <input type="text" class="form-control" v-model="busquedas.search" :placeholder="'Buscar por '+ busquedas.placeholder " @keyup="all(`${1}`,`${busquedas.criterio}`,`${busquedas.search}`,`${busquedas.tamanio}`)">
                                       </div>
                                   </div>
                                   <div class="col-md-6 d-flex  align-items-center justify-content-end form-group">
                                       <label for="" class="col-md-5">Registros por página</label>
                                       <select class="col-md-2 col-sm-2 col-3 custom-select" @change="all(`${1}`,`${busquedas.criterio}`,`${busquedas.search}`,`${busquedas.tamanio}`)">
                                           <option value="5">5</option>
                                           <option value="10">10</option>
                                           <option value="15">15</option>
                                       </select>
                                   </div>
                               </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl ">
                                            <table class="table table-sm table-striped table-hover table-bordered">
                                                <thead class="bg-info text-white text-uppercase text-center text-sm ">
                                                    <tr>
                                                        <th>Accion</th>
                                                        <th>Proveedor</th>
                                                        <th>N° documento</th>
                                                        <th>direccion</th>
                                                        <th>telefono</th>
                                                        <th>contacto</th>
                                                        <th>T. contacto</th>
                                                        <th>email</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody">
                                                <template v-if="listaArray.length > 0">
                                                    <tr v-for="row in  listaArray" :key="row.id">
                                                        <td class="text-center">
                                                            <div class="btn-group-vertical">
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-sm btn-default  btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                                        <span class="mr-2">Accion</span>
                                                                        <div class="dropdown-menu" role="menu">
                                                                            <a class="dropdown-item text-primary" href="javascript:void(0)" @click="acciones('proveedores','update',row)">
                                                                                <i class="fas fa-edit"></i>
                                                                                <span>Editar</span>
                                                                            </a>
                                                                            <a class="dropdown-item text-danger" @click="acciones('proveedores','ver-informacion',row)" href="javascript:void(0)">
                                                                                <i class="fas fa-eye "></i>
                                                                                <span>Ver</span>
                                                                            </a>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="ellipses" v-text="row.nombre" ></span>
                                                        </td>
                                                        <td>
                                                            <span class="ellipses" v-text="row.tipo_documento + ' - '+ row.num_documento"></span>
                                                        </td>
                                                        <td>
                                                            <span class="ellipses ellipses-sm" v-text="row.direccion"></span>
                                                        </td>
                                                        <td>
                                                           <span class="ellipses ellipses-sm" v-text="row.telefono"></span>
                                                        </td>
                                                        <td>
                                                            <span class="ellipses ellipses-sm" v-text="row.contacto"></span>
                                                        </td>
                                                        <td>
                                                            <span class="ellipses ellipses-sm" v-text="row.telefono_contacto"></span>
                                                        </td>
                                                        <td>
                                                            <span class="ellipses ellipses-sm" v-text="row.email"></span>
                                                        </td>
                                                    </tr>
                                                </template>
                                                <template v-else>
                                                    <tr>
                                                        <td class="text-center" colspan="8" v-text="paginacion.mensaje"></td>
                                                    </tr>
                                                </template>
                                                <template v-if="load.body_item">
                                                    <tr class="body-item">
                                                        <td  colspan="8"></td>
                                                    </tr>
                                                </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-group mt-2">
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
                            <div class="tab-pane fade" :class="{'active': tabs.active,'show':tabs.show}" role="tabpanel">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <h4 class="text-sm text-uppercase" v-text="tabs.title_card"></h4>
                                    </div>
                                    <div class="card-body">
                                        <template v-if="tabs.accion">
                                            <form>
                                                <div class="row">
                                                    <div class="col-md-5 form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-append">
                                                                <select v-model="consultar.tipo" class="custom-select input-group-text">
                                                                    <option value="ruc">RUC</option>
                                                                    <option value="dni">DNI</option>
                                                                </select>
                                                            </div>
                                                            <input type="text" v-model="consultar.numero" class="form-control" placeholder="buscar datos">
                                                            <div class="input-group-prepend">
                                                                <template v-if="consultar.accion">
                                                                    <button type="button" @click="consulta()" class="btn btn-success">
                                                                        <i class="fas fa-search"></i>
                                                                    </button>
                                                                </template>
                                                                <template v-else>
                                                                    <button type="button" class="btn btn-success" disabled>
                                                                        <span class="spinner-border spinner-border-sm text-white" role="status">
                                                                            <span class="sr-only">Loading...</span>
                                                                        </span>
                                                                    </button>
                                                                </template>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="text-uppercase">Nombres</label>
                                                        <input v-model="proveedor.nombre" type="text" class="form-control" placeholder="nombres.." readonly>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="text-uppercase">Dirección</label>
                                                        <template v-if="consultar.existe">
                                                            <input type="text" readonly class="form-control" placeholder="ingresar direccion..." v-model="proveedor.direccion">
                                                        </template>
                                                        <template v-else>
                                                            <input type="text"  class="form-control" placeholder="ingresar direccion..." v-model="proveedor.direccion">
                                                        </template>

                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label  class="text-uppercase">tipo documento</label>
                                                        <select  v-model="proveedor.tipo_documento" class="custom-select">
                                                            <option value="DNI">DNI</option>
                                                            <option value="RUC">RUC</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label  class="text-uppercase">N° de documento</label>
                                                        <input type="text" class="form-control" placeholder="numero de documento" v-model="proveedor.num_documento" readonly>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label  class="text-uppercase">Teléfono</label>
                                                        <input type="text" class="form-control" placeholder="numero de teléfono" v-model="proveedor.telefono">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label  class="text-uppercase">Email</label>
                                                        <input type="text" class="form-control" placeholder="ingres su email" v-model="proveedor.email">
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <label class="text-uppercase">Contacto</label>
                                                        <input type="text" class="form-control"  placeholder="contacto..." v-model="proveedor.contacto">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label class="text-uppercase">Teléfono del Contacto</label>
                                                        <input type="text" class="form-control"  placeholder="teléfono del contacto..." v-model="proveedor.telefono_contacto">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <div class="d-flex justify-content-end">
                                                            <div>
                                                                <button type="button" @click.prevent="cancelar()" class="btn btn-danger">
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
                                        </template>
                                        <template v-else>

                                        </template>
                                    </div>
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
    export  default {
        data(){
            return {
                listaArray:[],
                proveedor:{
                    id:0,
                    idpersona:0,
                    nombre:'',
                    tipo_documento:'RUC',
                    num_documento:'',
                    direccion:'',
                    telefono:'',
                    email:'',
                    contacto:'',
                    telefono_contacto:''
                },
                tabs:{
                    active:0,
                    show:0,
                    title:'Mantenimiento',
                    title_card : '',
                    accion:1,

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
                    criterio:'personas.nombre',
                    tamanio:5,
                    search:'',
                    placeholder:'nombre'
                },
                consultar:{
                    tipo:'ruc',
                    numero:'',
                    accion:1,
                    existe:0,
                },
                accion:1,
                load:{
                    body_item:0,
                }
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

            all(page,criterio,search,tamanio){
                this.load.body_item = 1;
              axios.get(`/admin/proveedor?page=${page}&criterio=${criterio}&search=${search}&tamanio=${tamanio}`)
              .then(r=>{
                  this.paginacion = r["data"]["paginacion"];
                  this.listaArray = r["data"]["proveedor"]["data"];
                  this.load.body_item = 0;
              }).catch(e=>{
                  console.log(e);
              })
            },
            store(){
                axios.post("/admin/proveedor/registrar",{
                    nombre:this.proveedor.nombre,
                    tipo_documento:this.proveedor.tipo_documento,
                    num_documento:this.proveedor.num_documento,
                    direccion:this.proveedor.direccion,
                    email:this.proveedor.email,
                    telefono:this.proveedor.telefono,
                    contacto:this.proveedor.contacto,
                    telefono_contacto:this.proveedor.telefono_contacto,
                }).then(r=>{
                    switch (r["data"]["estado"]) {
                        case 1:{

                            this.cancelar();
                            this.success("sdsd");
                            break;
                        }
                        case 2:{
                            alert(r["data"]["mensaje"]);
                            break;
                        }
                    }
                }).catch(e=>{
                    console.log(e);
                })
            },
            update(){
                axios.put("/admin/proveedor/editar",this.campos())
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
                }).catch(e=>{
                   console.log(e);
                });
            },
            cambiarPage(page){
                this.all(`${page}`,`${this.busquedas.criterio}`,`${this.busquedas.search}`,`${this.busquedas.tamanio}`);
            },
            acciones(modelo,accion,data=[]){
              switch (modelo) {
                  case 'proveedores':{
                      switch (accion) {
                          case 'insertar':{
                              this.mantenimiento();
                              this.accion =1;
                              this.tabs.title_card = "Nuevo Registro";
                              break;
                          }
                          case  'update':{
                              this.mantenimiento();
                              this.accion =0;
                              this.tabs.title_card = "Actualizar Registro";
                              this.proveedor.id = data.id;
                              this.proveedor.idpersona = data.id;
                              this.proveedor.nombre = data.nombre;
                              this.proveedor.direccion = data.direccion;
                              this.proveedor.tipo_documento = data.tipo_documento;
                              this.proveedor.num_documento = data.num_documento;
                              this.proveedor.telefono  =data.telefono;
                              this.proveedor.email = data.email;
                              this.proveedor.telefono_contacto = data.telefono_contacto;
                              this.proveedor.contacto = data.contacto;
                              this.consultar.tipo = data.tipo_documento.toLowerCase();

                              break;
                          }
                          case 'informacion':{

                          }
                      }
                      break;
                  }
              }
            },
            listado(){
                this.tabs.active = 0;
                this.tabs.show = 0;
            },
            mantenimiento(){
                this.tabs.active = 1;
                this.tabs.show = 1;
                this.limpiar();
            },
            cancelar(){
              this.listado();
              this.all(`${1}`,`${this.busquedas.criterio}`,`${this.busquedas.search}`,`${this.busquedas.tamanio}`);
              this.limpiar();
            },
            SelectOpciones(e){
                switch (e.target.value) {
                    case 'personas.nombre':{
                        this.busquedas.placeholder = 'nombre...';
                        break;
                    }
                    case 'personas.num_documento':{
                        this.busquedas.placeholder = 'número de documento...';
                        break;
                    }
                    case  'personas.email':{
                        this.busquedas.placeholder = 'email...';
                        break;
                    }
                    case 'personas.telefono':{
                        this.busquedas.placeholder = 'teléfono';
                        break;
                    }
                    case  'proveedores.telefono_contacto':{
                        this.busquedas.placeholder = 'teléfono del contacto...';
                        break;
                    }
                }
            },
            consulta(){
                this.consultar.accion = 0;
                axios.get(`/admin/proveedor/consulta?tipo=${this.consultar.tipo}&numero=${this.consultar.numero}`)
                    .then(r=>{
                        this.consultar.accion = 1;
                        switch (r["data"]["estado"]) {
                            case 1:{
                                let result = r["data"]["datos"];
                                this.consultar.existe = result["result"]["direccion"] === "" ? 0 : 1;
                                this.proveedor.nombre = result["result"]["razon"];
                                this.proveedor.direccion = result["result"]["direccion"];
                                this.proveedor.num_documento  =result["result"]["numero"];
                                this.proveedor.tipo_documento = result["tipo"];
                                break;
                            }
                            case 2:{
                                break;
                            }
                        }
                    }).catch(e=>{
                        console.log(e);
                    })
            },
            campos() {
                return {
                    idpersona : this.proveedor.id,
                    id : this.proveedor.id,
                    nombre:this.proveedor.nombre,
                    tipo_documento:this.proveedor.tipo_documento,
                    num_documento:this.proveedor.num_documento,
                    direccion:this.proveedor.direccion,
                    email:this.proveedor.email,
                    telefono:this.proveedor.telefono,
                    contacto:this.proveedor.contacto,
                    telefono_contacto:this.proveedor.telefono_contacto,
                }
            },
            limpiar(){
                this.proveedor.id = 0;
                this.proveedor.idpersona = 0;
                this.proveedor.nombre ="";
                this.proveedor.tipo_documento = "RUC";
                this.proveedor.num_documento = '';
                this.proveedor.direccion = "";
                this.proveedor.telefono ="";
                this.proveedor.email = "";
                this.proveedor.contacto = "";
                this.proveedor.telefono_contacto ="";
                this.consultar.numero  =  "";
                this.consultar.tipo  = "ruc";
            },
            success(sms){
                toastr.success(sms);
            },
            error(sms){
                toastr.error(sms);
            }
        },
        mounted() {
            this.all(`${1}`,`${this.busquedas.criterio}`,`${this.busquedas.search}`,`${this.busquedas.tamanio}`);
        }
    }
</script>
