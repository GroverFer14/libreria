<template>
  <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
    </ol>
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <!-- <i class="fa fa-align-justify"></i> Usuarios
          <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-secondary">
            <i class="icon-plus"></i>&nbsp;Nuevo
          </button> -->
        </div>
        <template v-if="listado==1">
          <div class="card-body">
            <div class="form-group row">
              <div class="col-md-6">
                <div class="input-group">
                  <select class="form-control col-md-3" v-model="criterio">
                    <option value="nombre">Nombre</option>
                  </select>
                  <input type="text" v-model="buscar" @keyup.enter="listarPedido(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                  <button type="submit" @click="listarPedido(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                </div>
              </div>
            </div>
            <table class="table table-bordered table-striped table-sm">
              <thead>
                <tr>
                  <th>Opciones</th>
                  <th>Tipo Comprobante</th>
                  <th>Serie</th>
                  <th>Numero</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="pedido in arrayPedido" :key="pedido.id">
                  <td>
                    <button type="button" @click="verVenta(pedido.ventasId)" class="btn btn-success btn-sm">
                      <i class="icon-eye"></i>
                    </button> &nbsp;
                    <!-- <template v-if="pedido.estado == 'Pendiente'">
                      <button type="button" class="btn btn-success btn-sm" @click="entregarPedido(pedido.id)">
                        <i class="icon-check"></i>
                      </button>
                    </template>
                    <template v-else>
                      <button type="button" class="btn btn-warning btn-sm" @click="pendientePedido(pedido.id)">
                        <i class="icon-check"></i>
                      </button>
                    </template> -->
                  </td>
                  <td v-text="pedido.tipo_comprobante"></td>
                  <td v-text="pedido.serie_comprobante"></td>
                  <td v-text="pedido.num_comprobante"></td>
                  <td v-text="pedido.total"></td>
                </tr>
              </tbody>
            </table>
            <nav>
              <ul class="pagination">
                <li class="page-item" v-if="pagination.current_page > 1">
                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                </li>
                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                  <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                </li>
                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                </li>
              </ul>
            </nav>
          </div>
        </template>
        <template v-else-if="listado==2">
          <div class="card-body">
            <div class="form-group row border">
              <div class="col-md-9">
                <div class="form-group">
                  <label for="">Cliente</label>
                  <p v-text="cliente"></p>
                </div>
              </div>
              <!-- <div class="col-md-3">
                <label for="">Impuesto</label>
                <p v-text="impuesto"></p>
              </div> -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>Tipo Comprobante</label>
                  <p v-text="tipo_comprobante"></p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Serie Comprobante</label>
                  <p v-text="serie_comprobante"></p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Número Comprobante</label>
                  <p v-text="num_comprobante"></p>
                </div>
              </div>
            </div>
            <div class="form-group row border">
              <div class="table-responsive col-md-12">
                <table class="table table-bordered table-striped table-sm">
                  <thead>
                    <tr>
                      <th>Artículo</th>
                      <th>Precio</th>
                      <th>Cantidad</th>
                      <th>Descuento</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody v-if="arrayDetalle.length">
                    <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                      <td v-text="detalle.articulo">
                      </td>
                      <td v-text="detalle.precio">
                      </td>
                      <td v-text="detalle.cantidad">
                      </td>
                      <td v-text="detalle.descuento">
                      </td>
                      <td>
                        {{detalle.precio*detalle.cantidad-detalle.descuento}}
                      </td>
                    </tr>
                    <!-- <tr style="background-color: #CEECF5;">
                      <td colspan="4" align="right"><strong>Total Parcial:</strong></td>
                      <td>Bs. {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                    </tr>
                    <tr style="background-color: #CEECF5;">
                      <td colspan="4" align="right"><strong>Total Impuesto:</strong></td>
                      <td>Bs. {{totalImpuesto=((total*impuesto)).toFixed(2)}}</td>
                    </tr> -->
                    <tr style="background-color: #CEECF5;">
                      <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                      <td>Bs. {{total}}</td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td colspan="5">
                        NO hay artículos agregados
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>

              </div>
            </div>
          </div>
        </template>

      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Nombre(*)</label>
                <div class="col-md-9">
                  <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la persona">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Tipo documento</label>
                <div class="col-md-9">
                  <select v-model="tipo_documento" class="form-control">
                    <option value="CI">CI</option>
                    <option value="PASS">PASS</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Número documento</label>
                <div class="col-md-9">
                  <input type="email" v-model="num_documento" class="form-control" placeholder="Número de documento">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Dirección</label>
                <div class="col-md-9">
                  <input type="email" v-model="direccion" class="form-control" placeholder="Dirección">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Teléfono</label>
                <div class="col-md-9">
                  <input type="email" v-model="telefono" class="form-control" placeholder="Teléfono">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Email</label>
                <div class="col-md-9">
                  <input type="email" v-model="email" class="form-control" placeholder="Email">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Role</label>
                <div class="col-md-9">

                  <select v-model="idrol" class="form-control">
                    <option value="0" disabled>Seleccione</option>
                    <option v-for="role in arrayRol" :key="role.id" :value="role.id" v-text="role.nombre"></option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Usuario</label>
                <div class="col-md-9">
                  <input type="text" v-model="usuario" class="form-control" placeholder="Nombre del usuario">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">password</label>
                <div class="col-md-9">
                  <input type="password" v-model="password" class="form-control" placeholder="password del usuario">
                </div>
              </div>
              <div v-show="errorPersona" class="form-group row div-error">
                <div class="text-center text-error">
                  <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                  </div>
                </div>
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
  </main>
</template>

<script>
export default {
  data() {
    return {
      persona_id: 0,
      nombre: "",
      tipo_documento: "",
      num_documento: "",
      direccion: "",
      telefono: "",
      email: "",
      usuario: "",
      password: "",
      idrol: "",
      arrayPedido: [],
      arrayRol: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorPersona: 0,
      errorMostrarMsjPersona: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0,
      },
      offset: 3,
      criterio: "nombre",
      buscar: "",
      listado: 1,
      cliente: "",
      tipo_comprobante: "RECIBO",
      serie_comprobante: "",
      num_comprobante: "",
      arrayDetalle: [],
    };
  },
  computed: {
    isActived: function () {
      return this.pagination.current_page;
    },
    //Calcula los elementos de la paginación
    pagesNumber: function () {
      if (!this.pagination.to) {
        return [];
      }

      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    },
  },
  methods: {
    listarPedido(page, buscar, criterio) {
      let me = this;
      var url =
        "/clienteventa?page=" +
        page +
        "&buscar=" +
        buscar +
        "&criterio=" +
        criterio;
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          me.arrayPedido = respuesta.pedidos.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    cambiarPagina(page, buscar, criterio) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarPedido(page, buscar, criterio);
    },

    actualizarPersona() {
      if (this.validarPersona()) {
        return;
      }

      let me = this;

      axios
        .put("/pedido/actualizar", {
          nombre: this.nombre,
          tipo_documento: this.tipo_documento,
          num_documento: this.num_documento,
          direccion: this.direccion,
          telefono: this.telefono,
          email: this.email,
          idrol: this.idrol,
          usuario: this.usuario,
          password: this.password,
          id: this.persona_id,
        })
        .then(function (response) {
          me.cerrarModal();
          me.listarPedido(1, "", "nombre");
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    validarPersona() {
      this.errorPersona = 0;
      this.errorMostrarMsjPersona = [];

      if (!this.nombre)
        this.errorMostrarMsjPersona.push(
          "El nombre de la pesona no puede estar vacío."
        );
      if (!this.usuario)
        this.errorMostrarMsjPersona.push(
          "El nombre de usuario no puede estar vacío."
        );
      if (!this.password)
        this.errorMostrarMsjPersona.push(
          "La password del usuario no puede estar vacía."
        );
      if (this.idrol == 0)
        this.errorMostrarMsjPersona.push("Seleccione una Role.");
      if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

      return this.errorPersona;
    },
    verVenta(id) {
      let me = this;
      me.listado = 2;

      //Obtener los datos del ingreso
      var arrayVentaT = [];
      var url = "/venta/obtenerCabecera?id=" + id;

      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          arrayVentaT = respuesta.venta;

          me.cliente = arrayVentaT[0]["nombre"];
          me.tipo_comprobante = arrayVentaT[0]["tipo_comprobante"];
          me.serie_comprobante = arrayVentaT[0]["serie_comprobante"];
          me.num_comprobante = arrayVentaT[0]["num_comprobante"];
          // me.impuesto = arrayVentaT[0]["impuesto"];
          me.total = arrayVentaT[0]["total"];
        })
        .catch(function (error) {
          console.log(error);
        });

      //Obtener los datos de los detalles
      var urld = "/venta/obtenerDetalles?id=" + id;

      axios
        .get(urld)
        .then(function (response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayDetalle = respuesta.detalles;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    ocultarDetalle() {
      this.listado = 1;
    },
    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.nombre = "";
      this.tipo_documento = "CI";
      this.num_documento = "";
      this.direccion = "";
      this.telefono = "";
      this.email = "";
      this.usuario = "";
      this.password = "";
      this.idrol = 0;
      this.errorPersona = 0;
    },
    abrirModal(modelo, accion, data = []) {
      this.selectRol();
      switch (modelo) {
        case "persona": {
          switch (accion) {
            case "registrar": {
              this.modal = 1;
              this.tituloModal = "Registrar Usuario";
              this.nombre = "";
              this.tipo_documento = "CI";
              this.num_documento = "";
              this.direccion = "";
              this.telefono = "";
              this.email = "";
              this.usuario = "";
              this.password = "";
              this.idrol = 0;
              this.tipoAccion = 1;
              break;
            }
            case "actualizar": {
              //console.log(data);
              this.modal = 1;
              this.tituloModal = "Actualizar Usuario";
              this.tipoAccion = 2;
              this.persona_id = data["id"];
              this.nombre = data["nombre"];
              this.tipo_documento = data["tipo_documento"];
              this.num_documento = data["num_documento"];
              this.direccion = data["direccion"];
              this.telefono = data["telefono"];
              this.email = data["email"];
              this.usuario = data["usuario"];
              this.password = data["password"];
              this.idrol = data["idrol"];
              break;
            }
          }
        }
      }
    },
    entregarPedido(id) {
      swal({
        title: "Esta seguro de marcar como entregado este pedido?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true,
      }).then((result) => {
        if (result.value) {
          let me = this;

          axios
            .put("/pedido/entregar", {
              id: id,
            })
            .then(function (response) {
              me.listarPedido(1, "", "nombre");
              swal(
                "Entregado!",
                "El se registro como entregado con éxito.",
                "success"
              );
            })
            .catch(function (error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },
    pendientePedido(id) {
      swal({
        title: "Esta seguro de marcar como pendiente este pedido?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true,
      }).then((result) => {
        if (result.value) {
          let me = this;

          axios
            .put("/pedido/pendiente", {
              id: id,
            })
            .then(function (response) {
              me.listarPedido(1, "", "nombre");
              swal(
                "Pendiente!",
                "El pedido se coloco como pendiente con exito.",
                "success"
              );
            })
            .catch(function (error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },
  },
  mounted() {
    this.listarPedido(1, this.buscar, this.criterio);
  },
};
</script>
<style>
.modal-content {
  width: 100% !important;
  position: absolute !important;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important;
}
.div-error {
  display: flex;
  justify-content: center;
}
.text-error {
  color: red !important;
  font-weight: bold;
}
</style>
