<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Colecciones</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Colecciones
                        <button type="button" @click="abrirModal('coleccion','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarColeccion(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarColeccion(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="coleccion in arrayColeccion" :Key="coleccion.id">
                                    <td>
                                        <button type="button" @click="abrirModal('coleccion','actualizar',coleccion)" class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="coleccion.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarColeccion(coleccion.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarColeccion(coleccion.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>

                                    </td>
                                    <td v-text="coleccion.nombre"></td>
                                    <td v-text="coleccion.descripcion"></td>
                                    <td>
                                        <div v-if="coleccion.condicion==1">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        
                                        <div v-else>
                                            <span class="badge badge-danger">Inactivo</span>
                                        </div>
                                    </td>
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
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input"><strong>Nombre</strong>(Solo letras en mayuscula)</label>
                                    <div class="col-md-9">
                                        <input type="text"  class="form-control" v-model="nombre" placeholder="Nombre de colección">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Descripción">
                                    </div>
                                </div>
                                <div class="text-center text-error">
                                        
                                        <div v-text="alertError"></div>
                                    </div>
                                <div v-show="errorColeccion" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjColeccion" :key="error" v-text="error"></div>
                                    </div>
                                    <div class="text-center text-error">
                                        <span v-if="errors.nombre">{{errors.nombre}}</span>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarColeccion()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarColeccion()">Actualizar</button>
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
        data(){
            return{
            nombre :"",
            descripcion : "",
            arrayColeccion: [],
            modal:0,
            alertError:"",
            tituloModal:"",
            tipoAccion:0,
            errorColeccion :0,
            errorMostrarMsjColeccion:[],
            errors:[],
            coleccion_id:0,
            pagination:{
 
                'total'        :0,
                'current_page' :0,
                'per_page'     :0,
                'last_page'    :0,
                'from'         :0,
                'to'           :0 
                 },
                 offset :3,
                 criterio : 'nombre',
                buscar : ''
            }
        },
        computed:{
           isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  
                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             
            }
        },
        methods :{
            
            listarColeccion (page,buscar,criterio){
                let me=this;
                var url= '/coleccion?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayColeccion = respuesta.colecciones.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
             cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarColeccion(page,buscar,criterio);
            },
            registrarColeccion(){
                //this.nombre= this.nombre.normalize('NFD').replace(/[\u0300-\u036f]/g,"");
                //texto.normalize('NFD').replace(/[\u0300-\u036f]/g,"");
                //this.nombre = this.nombre.toUpperCase();
               
                if(this.validarColeccion()){
                    return;
                }
                let me= this;
                axios.post('/coleccion/registrar',{
                    'nombre': this.nombre,
                    'descripcion':this.descripcion
                }).then(function(response){
                    me.cerrarModal();
                    me.listarColeccion(1,'','nombre');
                })
                .catch(error =>{
                    if(error.response.status == 422){
                        
                        this.errors= error.response.data.errors;
                        this.errorMostrarMsjColeccion.push("El nombre debe ser en mayuscula,sin tildes ni caracteres especiales");
                    }
                });
                //.catch(function(error){
                  //  console.log(error);
                //});
            },
            actualizarColeccion(){
                
               if (this.validarColeccionActualizar()){
                    return;
                }
                
                let me = this;

                axios.put('/coleccion/actualizar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'id': this.coleccion_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarColeccion(1,'','nombre');
                })
                .catch(error =>{
                    if(error.response.status == 422){    
                        this.errors= error.response.data.errors;
                        this.errorMostrarMsjColeccion.push("El nombre debe ser letras en mayuscula,sin tildes ni caracteres especiales");
                    }
                });    
                /*}).catch(function (error) {
                    console.log(error);
                });*/ 
            },
            desactivarColeccion(id){
               swal({
                title: 'Esta seguro de desactivar esta colección?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/coleccion/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarColeccion(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarColeccion(id){
               swal({
                title: 'Esta seguro de activar esta colección?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/coleccion/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarColeccion(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarColeccionActualizar(){
                this.errorColeccion=0;
                this.errorMostrarMsjColeccion=[];

                if(!this.nombre) this.errorMostrarMsjColeccion.push("El nombre no puede estar vacío");
                if(!this.descripcion) this.errorMostrarMsjColeccion.push("La descripción no puede estar vacía");   
                if(this.errorMostrarMsjColeccion.length) this.errorColeccion=1;
                return this.errorColeccion;
            },
            validarColeccion(){
                this.errorColeccion=0;
                this.errorMostrarMsjColeccion=[];

                    this.arrayColeccion.forEach(element => {
                    if(element.nombre == this.nombre){
                        //this.errorCategoria=0;
                        this.errorMostrarMsjColeccion.push("Esta Colección ya existe");
                        if(this.errorMostrarMsjColeccion.length) this.errorColeccion=1;
                        alert(element.nombre);
                        return this.errorColeccion;
                    }
                        
                });              
                        if(!this.nombre) this.errorMostrarMsjColeccion.push("El nombre no puede estar vacío");
                        if(!this.descripcion) this.errorMostrarMsjColeccion.push("La descripción no puede estar vacía");  
                        //alert("no validó"); 
                        if(this.errorMostrarMsjColeccion.length) this.errorColeccion=1;
                        return this.errorColeccion;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal= "";
                this.nombre="";
                this.descripcion="";
            },
            abrirModal(modelo,accion,data=[]){
                switch(modelo){
                    case "coleccion":{
                        switch(accion){
                            case "registrar":
                            {
                                this.modal=1;
                                this.nombre="";
                                this.descripcion="";
                                this.tituloModal="Registrar Colección";
                                this.alertError="La Colección registrará cuando el formato de todos los campos sea el correcto";
                                this.tipoAccion=1;
                                break;
                            }
                            case "actualizar":
                            {
                                this.coleccion_id=data['id'];
                                this.modal=1;
                                this.nombre=data['nombre'];
                                this.descripcion= data['descripcion'];
                                this.tituloModal="Actualizar Colección";
                                this.alertError="La Colección se actualizará cuando el formato de todos los campos sea el correcto";
                                this.tipoAccion=2;
                            }    
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarColeccion(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
.modal-content{
    width: 100% !important;
    position: absolute !important;
}
.mostrar{
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
}
.div-error{
    display: flex;
    justify-content: center;
}
.text-error{
    color: red !important;
    font-weight: bold;
}
</style>