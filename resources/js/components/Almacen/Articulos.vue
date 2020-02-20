<template>
    <div class="form-group animated fadeIn">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card card-info card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-uppercase" @click="listado()" :class="{'active':!nav_tabs.active}" href="javascript:void(0)" role="tab" aria-controls="custom-tabs-three-home" aria-selected="false">Listado</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase" @click="mantenimiento('articulo','insertar')" :class="{'active': nav_tabs.active}" href="javascript:void(0)" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false" >Mantenimiento</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <div class="tab-pane fade" :class="{'active':!nav_tabs.active,'show':!nav_tabs.show}" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                <div class="row">
                                    <div class="col-md-5 form-group">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <select class="custom-select input-group-text" v-model="busquedas.campo">
                                                    <option value="nombre">Nombre</option>
                                                    <option value="codigo">Codigo</option>
                                                </select>
                                            </div>
                                            <input type="text"  v-model="busquedas.search" class="form-control" placeholder="busquedas...">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-success" @click.prevent="all(1,busquedas.categoria,busquedas.search,busquedas.campo,busquedas.tamanio)">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <select class="custom-select" id="categorias">
                                            <option value="">Todas las categorias</option>
                                            <option :value="row.id" v-for="row in articulo.categoriasArray" :key="row.id" v-text="row.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group align-items-center justify-content-end d-flex">
                                        <label class="col-md-8 col-8" :style="{'margin-bottom':'0px'}">Registros Por Páginas :</label>
                                        <select class="col-md-3 col-4 custom-select" v-model="busquedas.tamanio" @change="all(1,busquedas.categoria,busquedas.search,busquedas.campo,busquedas.tamanio)">
                                            <option value="5" class="text-center">5</option>
                                            <option value="10" class="text-center">10</option>
                                            <option value="15" class="text-center">15</option>
                                            <option value="25" class="text-center">25</option>
                                            <option value="50" class="text-center">50</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-sm table-striped table-bordered table-hover">
                                            <thead class="bg-info text-uppercase text-white text-center text-sm">
                                            <tr>
                                                <th>Accion</th>
                                                <th>codigo</th>
                                                <th>producto</th>
                                                <th>categoria</th>
                                                <th>P.Venta</th>
                                                <th>stock</th>
                                                <th>descripcion</th>
                                                <th>Foto</th>
                                                <th>estado</th>
                                            </tr>
                                            </thead>
                                            <tbody class="tbody">
                                            <template v-if="articulo.listArray.length > 0">
                                                <tr v-for="row in articulo.listArray" :key="row.id" :class="[row.stock <= row.stock_inicial ? 'bg-danger' : '']">
                                                    <td class="text-center">
                                                        <div class="btn-group-vertical">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-sm btn-default  btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                                    <span class="mr-2">Accion</span>
                                                                    <div class="dropdown-menu" role="menu">
                                                                        <a class="dropdown-item text-primary" href="javascript:void(0)" @click="mantenimiento('articulo','update',row)">
                                                                            <i class="fas fa-edit"></i>
                                                                            <span>Editar</span>
                                                                        </a>
                                                                        <template v-if="row.condicion">
                                                                            <a class="dropdown-item text-danger" href="javascript:void(0)" @click.prevent="desactivar(row.id)">
                                                                                <i class="fas fa-trash"></i>
                                                                                <span>Desactivar</span>
                                                                            </a>
                                                                        </template>
                                                                        <template v-else>
                                                                            <a class="dropdown-item text-success" href="javascript:void(0)" @click.prevent="activar(row.id)">
                                                                                <i class="fas fa-check-circle"></i>
                                                                                <span>Activar</span>
                                                                            </a>
                                                                        </template>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center" v-text="row.codigo"></td>
                                                    <td v-text="row.nombre"></td>
                                                    <td v-text="row.categoria"></td>
                                                    <td class="text-center" v-text="row.precio_venta"></td>
                                                    <td class="text-center" v-text="row.stock"></td>
                                                    <td v-text="row.descripcion"></td>
                                                    <td class="text-center">
                                                        <img class="img-thumbnail" :src="row.imagen" width="50" alt="">
                                                    </td>
                                                    <td class="text-center">
                                                        <template v-if="row.condicion">
                                                            <span class="badge badge-success">Activo</span>
                                                        </template>
                                                        <template v-else>
                                                            <span class="badge-danger badge">Inactivo</span>
                                                        </template>
                                                    </td>
                                                </tr>
                                            </template>
                                            <template v-else>
                                                <tr>
                                                    <td colspan="10" class="text-uppercase text-center" v-text="articulo.paginacion.mensaje"></td>
                                                </tr>
                                            </template>
                                            <template v-if="body_item">
                                                <tr class="body-item">
                                                    <td colspan="10"></td>
                                                </tr>
                                            </template>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <nav class="d-flex align-items-center flex-wrap">
                                            <div class="col-md-7">
                                                <ul class="pagination float-left m-0">
                                                    <li class="page-item" :class="[isActived > 1 ? '' : 'disabled']">
                                                        <a href="javascript:void(0)" @click.prevent="cambiarPage(isActived - 1)" class="page-link">Anterior</a>
                                                    </li>
                                                    <li class="page-item" :key="page" v-for="page in NumberPages" :class="{'active': page === isActived}">
                                                        <a href="javascript:void(0)" @click.prevent="cambiarPage(page)" class="page-link" v-text="page"></a>
                                                    </li>
                                                    <li class="page-item" :class="[isActived < articulo.paginacion.ultima_pagina ? '' : 'disabled']">
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
                            <div class="tab-pane fade" :class="{'active':nav_tabs.active,'show':nav_tabs.show}" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <h4 class="card-title text-uppercase  text-sm" v-text="nav_tabs.title"></h4>
                                    </div>
                                    <div class="card-body">
                                        <form enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="" class="text-uppercase text-md">Producto:</label>
                                                    <input type="text" v-model="articulo.nombre" placeholder="* producto...." class="form-control campo m" @keyup="Input">
                                                    <span class="error invalid-feedback"></span>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="" class="text-uppercase">Categorias:</label>
                                                    <select class="custom-select campo m" v-model="articulo.idcategoria" id="selectCategorias">
                                                        <option value="">* Seleccionar</option>
                                                        <option :value="x.id" v-for="x in articulo.categoriasArray" :key="x.id" v-text="x.nombre"></option>
                                                    </select>
                                                    <span class="error invalid-feedback"></span>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="" class="text-uppercase">Precio de Venta :</label>
                                                    <input type="text" v-model="articulo.precio_venta" placeholder="* precio venta..." class="form-control campo m" @keyup="Input">
                                                    <span class="error invalid-feedback"></span>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="" class="text-uppercase">Stock :</label>
                                                    <input type="text" placeholder="* stock..." v-model="articulo.stock" class="form-control campo m" @keyup="Input">
                                                    <span class="error invalid-feedback"></span>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="" class="text-uppercase">Stock Inicial :</label>
                                                    <input type="text" placeholder="* stock inicial..." v-model="articulo.stock_inicial" class="form-control campo m" @keyup="Input">
                                                    <span class="error invalid-feedback"></span>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="" class="text-uppercase">descripcion</label>
                                                    <textarea rows="4" class="form-control m" v-model="articulo.descripcion" placeholder="ingrese descripcion"></textarea>
                                                    <span class="error invalid-feedback"></span>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="" class="text-uppercase">Codigo de Barra</label>
                                                    <input v-model="articulo.codigo" maxlength="11" min="1" type="number" class="form-control mb-2 campo m" placeholder="* ingresar código" @keyup="Input">
                                                    <span class="error invalid-feedback"></span>
                                                    <template v-if="codigoBarcode === 11">
                                                        <div class="d-flex justify-content-center">
                                                            <barcode :value="articulo.codigo" :options="opciones" tag="img"></barcode>
                                                        </div>
                                                    </template>
                                                    <template v-else>
                                                        <template v-if="codigoBarcode===0">
                                                            <label for="">¡Generar codigo de barra.!</label>
                                                            <label for="">Digite solo 11 números.</label>
                                                        </template>
                                                        <template v-else>
                                                            <label for="">¡Datos no válidos para este tipo de código de barras!</label>
                                                        </template>
                                                    </template>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="" class="text-uppercase">Subir Imagen</label>
                                                    <input type="file" ref="file" @change="getImage" class="form-control mb-2" accept="image/*">
                                                    <span class="error invalid-feedback"></span>
                                                    <div class="d-flex justify-content-center">
                                                        <template v-if="articulo.img !==''">
                                                            <img :src="articulo.img" alt="" class="img-thumbnail img-bordered" style="width:100%;height:200px;">
                                                        </template>
                                                        <template v-else>
                                                            <label for="" v-text="articulo.mensajeImg"></label>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-end">
                                                    <div class="">
                                                        <button class="btn btn-danger" @click="cancelar()" type="button">Cancelar</button>
                                                        <template v-if="nav_tabs.accion">
                                                            <button class="btn btn-success" @click="store()" type="button">Guardar</button>
                                                        </template>
                                                        <template v-else>
                                                            <button class="btn btn-success" @click="update()" type="button">Actualizar</button>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueBarcode from '@chenfengyuan/vue-barcode';
    export default {
        data() {
            return {
                articulo: {
                    listArray: [],
                    id: 0,
                    codigo: '',
                    nombre: '',
                    precio_venta: '',
                    stock: '',
                    stock_inicial: '',
                    condicion: 0,
                    descripcion: '',
                    idcategoria: '',
                    imagenFile: '',
                    paginacion: {
                        total_registros: 0,
                        pagina_actual: 0,
                        registro_pagina: 0,
                        ultima_pagina: 0,
                        desde_pagina: 0,
                        hasta_pagina: 0,
                        NumeroPaginas: 0,
                        mensaje: "Cargando"
                    },
                    categoriasArray: [],
                    img: '',
                    imagen: '',
                    mensajeImg: 'Tamaño de imagen válido 600 x 600',
                    edit: false,
                },
                nav_tabs: {
                    active: 0,
                    show: 0,
                    title: 'Registrar',
                    accion: 0
                },
                busquedas: {
                    search: "",
                    campo: "nombre",
                    tamanio: 5,
                    categoria: "",
                },
                opciones: {
                    lineColor: '#000',
                    displayValue: true,
                    format: 'UPC',
                    height: "50",
                    background: "#eceff1",
                    width: "2",
                    font: 'fantasy'
                },
                body_item: 0,
            }
        },
        components: {
            'barcode': VueBarcode,
        },
        computed: {
            codigoBarcode: function () {
                return parseInt(this.articulo.codigo.split("").length);
            },
            desde: function () {
                return this.articulo.paginacion.desde_pagina;
            },
            hasta: function () {
                return this.articulo.paginacion.hasta_pagina;
            },
            totalRegistros: function () {
                return this.articulo.paginacion.total_registros;
            },
            isActived: function () {
                return this.articulo.paginacion.pagina_actual;
            },
            NumberPages: function () {
                let newArray = [],
                    pages = this.articulo.paginacion.NumeroPaginas;
                for (let x = 0; x < pages.length; x++) {
                    newArray.push(pages[x]);
                }
                return newArray;
            }
        },
        methods: {
            all(page, categoria, search, campo, tamanio) {
                this.body_item = 1;
                axios.get(`/admin/articulos?page=${page}&categoria=${categoria}&search=${search}&campo=${campo}&tamanio=${tamanio}`)
                    .then(response => {
                        this.articulo.listArray = response["data"]["articulos"];
                        this.articulo.paginacion = response["data"]["paginacion"];
                        this.body_item = 0;
                    }).catch(error => {
                    console.log(error)
                });
            },
            store() {
                try {
                    if (!this.validacion())
                        throw "Verificiar Errores";
                    var formdata = new FormData();
                    formdata.append("producto", this.articulo.nombre);
                    formdata.append("idcategoria", this.articulo.idcategoria);
                    formdata.append("precio_venta", this.articulo.precio_venta);
                    formdata.append("stock", this.articulo.stock);
                    formdata.append("stock_inicial", this.articulo.stock_inicial);
                    formdata.append("descripcion", this.articulo.descripcion);
                    formdata.append("codigo", this.articulo.codigo);
                    formdata.append("imagen", this.articulo.imagen);
                    axios.post("/admin/articulos/registrar", formdata, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }).then(response => {
                        switch (response["data"]["estado"]) {
                            case 1: {
                                this.all(1, this.busquedas.categoria, this.busquedas.search, this.busquedas.campo, this.busquedas.tamanio);
                                this.success(response["data"]["mensaje"]);
                                this.listado();
                                break;
                            }
                            case 2: {
                                this.error(response["data"]["mensaje"]);
                                var error = [],
                                    m = null,
                                    e = null;
                                error = response["data"]["error"];
                                m = document.querySelectorAll(".m");
                                e = document.querySelectorAll(".error");
                                for (var x = 0; x < error.length; x++) {
                                    if (error[x] !== "") {
                                        m[x].classList.add("is-invalid");
                                        e[x].textContent = error[x]
                                    }
                                }
                                break;
                            }
                        }
                    }).catch(error => {
                        console.log(error);
                    })
                } catch (error) {
                    this.error(error);
                }
            },
            update() {
                try {
                    if (!this.validacion())
                        throw "Verificar Errores";
                    var form = new FormData();
                    form.append("id", this.articulo.id);
                    form.append("producto", this.articulo.nombre);
                    form.append("idcategoria", this.articulo.idcategoria);
                    form.append("precio_venta", this.articulo.precio_venta);
                    form.append("stock", this.articulo.stock);
                    form.append("stock_inicial", this.articulo.stock_inicial);
                    form.append("descripcion", this.articulo.descripcion);
                    form.append("codigo", this.articulo.codigo);
                    form.append("imagen", this.articulo.imagen);
                    form.append("editar", this.articulo.edit);
                    axios.post("/admin/articulos/editar", form, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }).then(response => {

                        switch (response["data"]["estado"]) {
                            case 1: {
                                this.all(1, this.busquedas.categoria, this.busquedas.search, this.busquedas.campo, this.busquedas.tamanio);
                                this.success(response["data"]["mensaje"]);
                                this.listado();
                                break;
                            }
                            case 2: {
                                this.error(response["data"]["mensaje"]);
                                let error = [],
                                    m = null,
                                    e = null;
                                error = response["data"]["error"];
                                m = document.querySelectorAll(".m");
                                e = document.querySelectorAll(".error");
                                for (let x = 0; x < error.length; x++) {
                                    if (error[x] !== "") {
                                        m[x].classList.add("is-invalid");
                                        e[x].textContent = error[x]
                                    }
                                }
                                break;
                            }
                        }
                    }).catch(error => {
                        console.log(error);
                    });
                } catch (error) {
                    this.error(error);
                }
            },
            activar(id) {
                this.sweetAlert("/admin/articulos/activar", id, "¡Activado!", "Activalo");
            },
            desactivar(id) {
                this.sweetAlert("/admin/articulos/desactivar", id, "¡Desactivado!", "Desactivalo");
            },
            cancelar() {
                this.listado();
                this.all(1, this.busquedas.categoria, this.busquedas.search, this.busquedas.campo, this.busquedas.tamanio);
            },
            categorias() {
                var me = this;
                axios.get("/admin/categorias/lista")
                    .then(response => {
                        this.articulo.categoriasArray = response["data"];
                    }).catch(error => {
                    console.log(error)
                });
                $("#categorias").select2({
                    theme: "bootstrap",
                    width: "100%"
                });
                $(document).on("change", "#categorias", function (e) {
                    me.busquedas.categoria = e.target.value;
                    me.all(1, e.target.value, me.busquedas.search, me.busquedas.campo, me.busquedas.tamanio);
                });
                $(document).on("change", "#selectCategorias", function (e) {
                    me.articulo.idcategoria = e.target.value;
                })
            },
            cambiarPage(page) {
                this.all(page, this.busquedas.categoria, this.busquedas.search, this.busquedas.campo, this.busquedas.tamanio);
            },
            listado() {
                this.nav_tabs.active = 0;
                this.nav_tabs.show = 0;
                this.nav_tabs.title = "Registrar";
                this.limpiar();
            },
            mantenimiento(modelo, accion, data = []) {
                switch (modelo) {
                    case 'articulo': {
                        switch (accion) {
                            case 'insertar': {
                                this.nav_tabs.active = 1;
                                this.nav_tabs.show = 1;
                                this.nav_tabs.accion = 1;
                                this.nav_tabs.title = "Registrar Nuevo Articulo";
                                this.limpiar();
                                this.selectCategR();
                                break;
                            }
                            case 'update': {
                                this.nav_tabs.active = 1;
                                this.nav_tabs.show = 1;
                                this.nav_tabs.accion = 0;
                                this.nav_tabs.title = "Actualizando Articulo " +  data.nombre;
                                this.articulo.id = data.id;
                                this.articulo.nombre = data.nombre;
                                this.articulo.idcategoria = data.idcategoria;
                                this.articulo.precio_venta = data.precio_venta;
                                this.articulo.codigo = data.codigo;
                                this.articulo.stock = data.stock;
                                this.articulo.stock_inicial = data.stock_inicial;
                                this.articulo.descripcion = data.descripcion;
                                this.articulo.img = data.imagen;
                                this.selectCategR();
                                break;
                            }
                        }
                        break;
                    }
                }
            },
            getImage(f) {
                if (f.target.value !== "") {
                    f.target.classList.remove("is-invalid");
                } else {
                    f.target.classList.add("is-invalid");
                }
                var me = this;
                var imagen = f.target.files[0];
                if (imagen) {
                    if (imagen["type"] === 'image/png' || imagen["type"] === "image/jpeg") {
                        var reader = new FileReader();
                        reader.readAsDataURL(imagen);
                        reader.onload = (e) => {
                            me.articulo.img = e.target.result;
                            me.articulo.imagen = me.$refs.file.files[0];
                            me.articulo.edit = true;
                        }
                    } else {
                        this.error("solo se permite formato JPEG ó PNG");
                        this.$refs.file.value = "";
                        this.articulo.imagen = "";
                        this.articulo.img = "";
                        this.articulo.mensajeImg = "Solo formato JPEG ó PNG";
                        this.articulo.edit = false;
                    }
                } else {
                    this.$refs.file.value = "";
                    this.articulo.imagen = "";
                    this.articulo.img = "";
                    this.articulo.mensajeImg = "Solo formato JPEG ó PNG";
                    this.articulo.edit = false;
                }
            },
            sweetAlert(url, id, motivo, accion) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: true
                });
                swalWithBootstrapButtons.fire({
                    title: 'Estás Seguro ?',
                    text: "No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: `Si, ${accion}!`,
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        axios.put(url, {
                            id: id
                        }).then(response => {
                            switch (response["data"]["estado"]) {
                                case 1: {
                                    swalWithBootstrapButtons.fire(
                                        `${motivo}!`,
                                        `${response["data"]["mensaje"]}`,
                                        'success'
                                    );
                                    this.all(1, this.busquedas.categoria, this.busquedas.search, this.busquedas.campo, this.busquedas.tamanio);
                                    break;
                                }
                                case 2: {
                                    swalWithBootstrapButtons.fire(
                                        `Sin Exito!`,
                                        `${response["data"]["mensaje"]}`,
                                        'error'
                                    );
                                    break;
                                }
                            }
                        }).catch(error => {
                            console.log(error)
                        })
                    }
                })
            },
            error(sms) {
                toastr.error(`${sms}`);
            },
            success(sms) {
                toastr.success(`${sms}`);
            },
            validacion() {
                var campos = [],
                    bools = true,
                    error = [];
                campos = document.querySelectorAll(".campo");
                error = document.querySelectorAll(".error");
                for (let x = 0; x < campos.length; x++) {
                    if (campos[x].value === "") {
                        bools = false;
                        campos[x].classList.add("is-invalid");
                        error[x].textContent = "* campo obligatorio";
                    } else {
                        campos[x].classList.remove("is-invalid");
                    }
                }
                return bools;
            },
            Input(e) {
                if (e.target.value !== "") {
                    e.target.classList.remove("is-invalid");
                } else {
                    e.target.classList.add("is-invalid");
                }
            },
            limpiar() {
                var m = document.querySelectorAll(".m");
                for (let i = 0; i < m.length; i++) {
                    m[i].classList.remove("is-invalid");
                }
                this.articulo.id = 0;
                this.articulo.idcategoria = '';
                this.articulo.codigo = '';
                this.articulo.nombre = '';
                this.articulo.precio_venta = '';
                this.articulo.stock = '';
                this.articulo.stock_inicial = '';
                this.articulo.condicion = 0;
                this.articulo.descripcion = '';
                this.articulo.img = "";
                this.articulo.imagen = "";
            },
            selectCategR() {
                setTimeout(() => {
                    $("#selectCategorias").select2({
                        theme: "bootstrap",
                        width: "100%"
                    })
                }, 100)
            },
            aleatorio(num){
                let numeros = ['0','1','2','3','4','5','6','7','8','9'];
                let numeroAleatorio = 3;
                let resultado="";
                for(let i=0;i< num;i++){
                    numeroAleatorio = parseInt(Math.random() * numeros.length );
                    resultado +=numeros[numeroAleatorio];
                }
                return resultado;
            }
        },
        mounted() {
            this.all(1, this.busquedas.categoria, this.busquedas.search, this.busquedas.campo, this.busquedas.tamanio);
            this.categorias();
            console.log(this.aleatorio(11));
        }
    }
</script>
