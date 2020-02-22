<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Registros</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>Registros
                        <button type="button" @click="abrirModal('registro','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button type="button" @click="cargarPdf()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="tema">tema</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarRegistro(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarRegistro(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    
                                    <th>Editar</th>
                                    <th>Tema</th>
                                    <th>Persona</th>
                                    <th>Ejemplar</th>
                                    <th>Celular</th>
                                    <th>fecha</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="registro in arrayRegistro" :Key="registro.id">
                                    <td>
                                        <button type="button" @click="abrirModal('registro','actualizar',registro)" class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;

                                    </td>
                                    
                                    <td v-text="registro.tema"></td> 
                                    <td v-text="registro.nombre_persona"></td>
                                    <td v-text="registro.nombre_ejemplar"></td> 
                                    <td v-text="registro.celular"></td>
                                    <td v-text="registro.updated_at"></td>                              
                                    
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
                                    <label class="col-md-3 form-control-label" for="text-input">Tema</label>
                                    <div class="col-md-9">
                                        <input type="text"  class="form-control" v-model="tema" placeholder="tema">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Ejemplar</label>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <v-select class="form-control"
                                                @search="selectEjemplar"
                                                label="titulo"
                                                v-model="nombre_ejemplar"
                                                :options="arrayEjemplar"
                                                placeholder="Buscar..."
                                                @input="getDatosEjemplar"                                    
                                            >
                                                 <span slot="no-options">No se han encontrado registros.</span>
                                            </v-select>
                                        </div>
                                        <!--la variable idcategoria asociado a v-model la asignamos
                                        en la propiedad data en javascript (ver al final) -->

                                        <!--<select class="form-control" v-model="idejemplar">-->
                                          
                                          <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                          de la tabla categorias de la bd-->
                                          <!--<option value="0" disabled>Seleccione</option>-->
                                          <!--el arrayCategoria es una variable de la data javascript de vue 
                                          y se cargan los registros de la categoria una vez se abra la ventana
                                          modal-->
                                          <!--<option v-for="ejemplar in arrayEjemplar" :key="ejemplar.id" :value="ejemplar.id" v-text="ejemplar.titulo"></option>-->

                                        <!--</select>-->
                                       
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text"  class="form-control" v-model="nombre_persona" placeholder="nombre de quien consulta">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Celular</label>
                                    <div class="col-md-9">
                                        <input type="text"  class="form-control" v-model="celular" placeholder="celular">
                                    </div>
                                </div> 

                                 <div class="form-group row">
                                </div>
                                <div v-show="errorRegistro" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjRegistro" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarRegistro()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarRegistro()">Actualizar</button>
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
    import vSelect from 'vue-select';
    export default {
        data(){
            return{
            registro_id:0,
            idejemplar:0,
            idpersona:0,
            nombre_persona:'',
            nombre_ejemplar:'',
            celular:'',
            tema:'',

            arrayEjemplar: [],
            modal:0,
            tituloModal:"",
            tipoAccion:0,
            errorRegistro :0,
            errorMostrarMsjRegistro:[],
           
            pagination:{
 
                'total'        :0,
                'current_page' :0,
                'per_page'     :0,
                'last_page'    :0,
                'from'         :0,
                'to'           :0 
                 },
                 offset :3,
                 criterio : 'tema',
                buscar : '',
                arrayRegistro:[]
            }
        },
        components:{
            vSelect
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
            cargarPdf(){
                window.open('http://localhost:8000/registro/listarPdf','_blank');
            },
            listarRegistro (page,buscar,criterio){
               let me=this;
                var url='/registro?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRegistro = respuesta.registros.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
          
            selectEjemplar(search,loading){
                let me=this;
                loading(true)

                var url='/ejemplar/selectEjemplar?filtro='+search;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    let respuesta= response.data;
                    q: search
                    me.arrayEjemplar = respuesta.ejemplares;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosEjemplar(val1){
                let me=this;
                me.loading=true;
                me.idejemplar= val1.id;
            },
            
             cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarRegistro(page,buscar,criterio);
            },
            registrarRegistro(){
                if(this.validarRegistro()){
                    return;
                }
                let me= this;
                axios.post('/registro/registrar',{
                    //'idpersona':this.idpersona,
                    'nombre_persona':this.nombre_persona,
                    'idejemplar':this.idejemplar,
                    'tema': this.tema,
                    'celular':this.celular
                }).then(function(response){
                    me.cerrarModal();
                    me.listarRegistro(1,'','tema');
                })
                .catch(function(error){
                    console.log(error.response);
                });
            },
            validarRegistro(){
                this.errorArticulo=0;
                this.errorMostrarMsjRegistro =[];

                if (this.idejemplar==0) this.rrorMostrarMsjRegistro.push("Seleccione una categoría.");
                if (!this.tema) this.rrorMostrarMsjRegistro.push("El nombre del artículo no puede estar vacío.");
                
                if (this.rrorMostrarMsjRegistro.length) this.errorRegistro = 1;

                return this.errorRegistro;
            },
            actualizarRegistro(){
                
                
               if (this.validarRegistro()){
                    return;
                }
                let me = this;
                axios.put('/registro/actualizar',{
                    'nombre_persona':this.nombre_persona,
                    'idpersona':this.idpersona,
                    'idejemplar':this.idejemplar,
                    'tema': this.tema,
                    'id':this.registro_id,
                    'celular':this.celular
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarRegistro(1,'','tema');
                }).catch(function (error) {
                    console.log(error.response);
                }); 
            },
            desactivarRegistro(id){
               swal({
                title: 'Está seguro de desactivar este Ejemplar?',
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

                    axios.put('/registro/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarRegistro(1,'','tema');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error.response);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarRegistro(id){
               swal({
                title: 'Esta seguro de activar esta Categoría?',
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

                    axios.put('/registro/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarRegistro(1,'','tema');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error.response);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarRegistro(){
                this.errorRegistro=0;
                this.errorMostrarMsjRegistro=[];

                if(!this.tema) this.errorMostrarMsjRegistro.push("El tema no puede estar vacío");  
                if(this.errorMostrarMsjRegistro.length) this.errorRegistro=1;
                return this.errorRegistro;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal= "";
                this.tema="";
                this.idpersona=0;
                this.idejemplar=0;
                this.nombre_persona="";
                this.nombre_ejemplar="";
                this.errorRegistro=0;
                this.celular='';
            },
            abrirModal(modelo,accion,data=[]){
                switch(modelo){
                    case "registro":{
                        switch(accion){
                            case "registrar":
                            {
                                this.modal=1;
                                this.tema="";
                                this.tituloModal="Registrar Consulta";
                                this.idregistro=0;
                                this.nombre_persona="";                 
                                this.nombre_ejemplar="";
                                this.idpersona=0;
                                this.tipoAccion=1;
                                this.celular='';
                                break;
                            }
                            case "actualizar":
                            {      
                                this.modal=1;
                                this.tipoAccion=2;
                                this.tituloModal="Actualizar Consulta";
                                this.idejemplar=data["idejemplar"];
                                this.idpersona=data["idpersona"];
                                this.registro_id=data["id"];
                                this.tema=data["tema"];
                                this.persona=data["persona"];               
                                this.ejemplar=data["ejemplar"];
                                this.celular= data["celular"];
                                this.nombre_persona=data["nombre_persona"];
                            }    
                        }
                    }
                }
                this.selectEjemplar();
            }
        },
        mounted() {
            this.listarRegistro(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
.modal-content{
    width: 100% !important;
    position: absolute !important;
}
.mostrar{
    height: 1000px;
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