<template>
    <main>
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header text-uppercase">
                            <label>
                                <i class="fas fa-align-justify"></i>
                                <span>Categorias</span>
                            </label>
                            <button class="btn btn-success  ml-2 text-uppercase" type="button" @click="abrilModal('categoria','insertar')">
                                <span>Agregar</span>
                                <i class="fas fa-plus-square"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5 form-group">
                                    <div class="input-group">
                                        <input type="text" v-model="busquedas.nombre" class="form-control" placeholder="buscar categorias" @keyup="listar(1,busquedas.nombre,busquedas.estado,busquedas.tamanio)" />
                                        <div class="input-group-append">
                                          <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                          </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 form-group">
                                    <div class="input-group">
                                        <select class="custom-select" v-model="busquedas.estado" @change="listar(1,busquedas.nombre,busquedas.estado,busquedas.tamanio)">
                                            <option value>Todos</option>
                                            <option value="1">Activos</option>
                                            <option value="0">Inactivos</option>
                                        </select>
                                        <div class="input-group-append">
                                          <span class="input-group-text">
                                                <i class="fas fa-align-justify"></i>
                                          </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 align-items-center d-flex form-group justify-content-end">
                                    <label class="col-md-6 col-8" :style="{'margin-bottom':'0px'}">Registros Por Páginas :</label>
                                    <select class="col-md-3 col-4 custom-select" v-model.number="busquedas.tamanio" @change="listar(1,busquedas.nombre,busquedas.estado,busquedas.tamanio)">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="25">25</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover table-bordered table-striped">
                                            <thead class="bg-info text-uppercase text-white text-center">
                                            <tr>
                                                <th>ID</th>
                                                <th>Categoria</th>
                                                <th>Descripcion</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-center">
                                            <template v-if="array_categoria.length > 0">
                                                <tr v-for="row in array_categoria" :key="row.id">
                                                    <td v-text="row.id"></td>
                                                    <td v-text="row.nombre"></td>
                                                    <td v-text="row.descripcion"></td>
                                                    <td>
                                                        <template v-if="row.condicion">
                                                            <span class="badge badge-success">Activo</span>
                                                        </template>
                                                        <template v-else>
                                                            <span class="badge badge-danger">Inactivo</span>
                                                        </template>
                                                    </td>
                                                    <td>
                                                        <template v-if="row.condicion">
                                                            <button type="button" class="btn btn-danger btn-sm" @click.prevent="desactivar(row.id)">
                                                                <!--<i class="fas fa-trash-alt"></i>-->
                                                                Desactivar
                                                            </button>
                                                        </template>
                                                        <template v-else>
                                                            <button type="button" class="btn btn-warning btn-sm" @click.prevent="activar(row.id)">
                                                                <!--<i class="fas fa-trash-alt"></i>-->
                                                                Activar
                                                            </button>
                                                        </template>

                                                        <button type="button" @click="abrilModal('categoria','update',row)" class="btn btn-primary btn-sm">
                                                            <!--<i class="fas fa-edit"></i>-->
                                                            Editar
                                                        </button>
                                                    </td>
                                                </tr>
                                            </template>
                                            <template v-else>
                                                <td colspan="5" class="text-center" v-text="paginacion.mensaje"></td>
                                            </template>
                                            </tbody>
                                        </table>
                                        <nav class="d-flex align-items-center flex-wrap">
                                            <div class="col-md-5">
                                                <label>Mostrando</label>
                                                <label v-text="paginacion.desde_pagina"></label>
                                                <label>Hasta</label>
                                                <label v-text="paginacion.hasta_pagina"></label>
                                                <label>de</label>
                                                <label v-text="paginacion.total_registros"></label>
                                                <label>Registros</label>
                                            </div>
                                            <div class="col-md-7 d-flex justify-content-end">
                                                <ul class="pagination">
                                                    <li class="page-item" :class="[paginacion.pagina_actual > 1 ? '' : 'disabled' ]">
                                                        <a class="page-link" href="javascript:void(0)" @click.prevent="cambiarPage(paginacion.pagina_actual - 1)">Anterior</a>
                                                    </li>
                                                    <li class="page-item" v-for="page in NumberPage" :key="page" :class="[page==isActive ? 'active' : '',page=='...'? 'disabled' : '']">
                                                        <a class="page-link" href="javascript:void(0)" v-text="page" @click.prevent="cambiarPage(page)"></a>
                                                    </li>
                                                    <li class="page-item" :class="[paginacion.pagina_actual < paginacion.ultima_pagina ? '' : 'disabled']">
                                                        <a class="page-link" href="javascript:void(0)" @click.prevent="cambiarPage(paginacion.pagina_actual + 1)">Siguiente</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" :class="{'mostrar':modal.show,'show':modal.show}" aria-modal="true">
            <div class="modal-dialog">
                <div class="modal-content animated" :class="{'bounceInDown':modal.show}">
                    <div class="modal-header bg-info disabled color-palette text-uppercase">
                        <h4 class="modal-title text-md" v-text="modal.title"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for class="text-uppercase">Categoria</label>
                                        <input type="text" class="form-control" v-model="nombre" placeholder="* ingrese nombre de categoria" />
                                        <span ref="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for class="text-uppercase">Descripcion</label>
                                        <textarea v-model="descripcion" class="form-control" rows="5" placeholder="ingrese su descripcion"></textarea>
                                        <span ref="error"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" @click="cerrarModal()">Cerrar</button>
                        <template v-if="modal.accion">
                            <button type="button" class="btn btn-success" @click.prevent="registrar()">Registrar</button>
                        </template>
                        <template v-else>
                            <button type="button" class="btn btn-success" @click.prevent="update()">Actualizar</button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
export default {
      data() {
            return {
                  array_categoria: [],
                  id: 0,
                  nombre: "",
                  descripcion: "",
                  paginacion: {
                        total_registros: 0,
                        pagina_actual: 0,
                        registro_pagina: 0,
                        ultima_pagina: 0,
                        desde_pagina: 0,
                        hasta_pagina: 0,
                        NumeroPaginas: [],
                        mensaje: "Cargando..."
                  },
                  busquedas: {
                        nombre: "",
                        estado: "",
                        tamanio: 5
                  },
                  modal: {
                        show: 0,
                        title: "",
                        accion: 0
                  }
            };
      },
      computed: {
            isActive: function () {
                  return this.paginacion.pagina_actual;
            },
            NumberPage: function () {
                  var newArray = [],
                        pages = [];
                  pages = this.paginacion.NumeroPaginas;
                  for (let i = 0; i < pages.length; i++) {
                        newArray.push(pages[i]);
                  }
                  return newArray;
            }
      },
      methods: {
            listar(page, nombre, estado, tamanio) {
                  axios.get(`/admin/categoria?page=${page}&nombre=${nombre}&estado=${estado}&tamanio=${tamanio}`)
                        .then(response => {
                              this.array_categoria = response["data"]["categoria"]["data"];
                              this.paginacion = response["data"]["paginacion"];
                        })
                        .catch(error => {
                              console.log(error);
                        });
            },
            registrar() {
                  var campos = {
                        nombre: this.nombre,
                        descripcion: this.descripcion
                  };
                  axios.post("/admin/categoria/registrar", campos)
                        .then(respose => {
                              switch (respose["data"]["estado"]) {
                                    case 1: {
                                          this.cerrarModal();
                                          this.success(respose["data"]["mensaje"]);
                                          this.listar(1, this.busquedas.nombre, this.busquedas.estado, this.busquedas.tamanio);
                                          break;
                                    }
                                    case 2: {
                                          console.log(respose);
                                          break;
                                    }
                              }
                        }).catch(error => {
                              console.log(error);
                        });
            },
            update() {
                  var edit = {
                        "id": this.id,
                        "nombre": this.nombre,
                        "descripcion": this.descripcion
                  };
                  axios.put("/admin/categoria/editar", edit)
                        .then(response => {
                              switch (response["data"]["estado"]) {
                                    case 1: {
                                          this.cerrarModal();
                                          this.success(response["data"]["mensaje"]);
                                          this.listar(1, this.busquedas.nombre, this.busquedas.estado, this.busquedas.tamanio);
                                          break;
                                    }
                                    case 2: {
                                          console.log(response);
                                          break;
                                    }
                              }
                        }).catch(error => {
                              console.log(error);
                        });
            },
            activar(id) {
                  this.sweetAlert("/admin/categoria/activar", `${id}`, "Activado", "Activalo");
            },
            desactivar(id) {
                  this.sweetAlert("/admin/categoria/desactivar", `${id}`, "Desactivado", "Desactivalo");
            },
            abrilModal(modelo, accion, data = []) {
                  switch (modelo) {
                        case "categoria": {
                              switch (accion) {
                                    case "insertar": {
                                          this.modal.show = 1;
                                          this.modal.title = "Registrar Categoría";
                                          this.modal.accion = 1;
                                          this.open_modal(this.modal.show);
                                          this.id = "";
                                          this.nombre = "";
                                          this.descripcion = "";
                                          break;
                                    }
                                    case "update": {
                                          this.modal.show = 1;
                                          this.modal.title = "Actualizar Categoría";
                                          this.modal.accion = 0;
                                          this.open_modal(this.modal.show);
                                          this.id = data.id;
                                          this.nombre = data.nombre;
                                          this.descripcion = data.descripcion;
                                          break;
                                    }
                              }
                              break;
                        }
                  }
            },
            cambiarPage(page) {
                  this.listar(page, this.busquedas.nombre, this.busquedas.estado, this.busquedas.tamanio);
            },
            cerrarModal() {
                  this.modal.show = 0;
                  this.open_modal(this.modal.show);
            },
            open_modal(modal) {
                  modal ? document.body.classList.add("modal-open") : document.body.classList.remove("modal-open");
            },
            success(sms) {
                  toastr.success(`${sms}`);
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
                                    })
                                    .then(response => {
                                          switch (response["data"]["estado"]) {
                                                case 1: {
                                                      swalWithBootstrapButtons.fire(
                                                            `${motivo}!`,
                                                            `${response["data"]["mensaje"]}`,
                                                            'success'
                                                      );
                                                      this.listar(1, this.busquedas.nombre, this.busquedas.estado, this.busquedas.tamanio);
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
            }
      },
      mounted() {
            this.listar(1, this.busquedas.nombre, this.busquedas.estado, this.busquedas.tamanio);
      }
}
</script>
