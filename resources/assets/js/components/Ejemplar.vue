<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Ejemplares</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>Ejemplares
                        <button type="button" @click="abrirModal('ejemplar','registrar')" class="btn btn-secondary">
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
                                      <option value="titulo">titulo</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarEjemplar(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarEjemplar(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    
                                    <th>Opciones</th>
                                    <th>Categoría</th>
                                    <th>Colección</th>
                                    <th>Titulo</th>
                                    <th>Descripción</th>
                                    <th>Elaborado</th>
                                    <th>Editorial</th>
                                    <th>Publicación</th>
                                    <th>Cantidad</th>
                                    <th>Imagen</th>
                                    <th>Autor</th>
                                    <th>Condición</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="ejemplar in arrayEjemplar" :Key="ejemplar.id">
                                    <td>
                                        <button type="button" @click="abrirModal('ejemplar','actualizar',ejemplar)" class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="ejemplar.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarEjemplar(ejemplar.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarEjemplar(ejemplar.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>

                                    </td>
                                    <td v-text="ejemplar.nombre_categoria"></td>
                                    <td v-text="ejemplar.nombre_coleccion"></td>
                                    <td v-text="ejemplar.titulo"></td>
                                    <td v-text="ejemplar.descripcion"></td>
                                    <td>
                                        <div v-if="ejemplar.elaborado==1">
                                            <span class="badge badge-warning">Si</span>
                                        </div>
                                        
                                        <div v-else>
                                            <span class="badge badge-info">No</span>
                                        </div>
                                    </td>
                                    <td v-text="ejemplar.editorial"></td>
                                    <td v-text="ejemplar.fecha_publicacion"></td>
                                    <td v-text="ejemplar.cantidad"></td>
                                    <td>
                                         <img :src="'img/ejemplar/' + ejemplar.imagen" class="img-responsive" width="100px" height="100px">
                                    </td>
                                    <td v-text="ejemplar.autor"></td>
                                    
                                    <td>
                                        <div v-if="ejemplar.condicion==1">
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
            <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog"  aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="https://vuejs.org/" id="app" method="post" enctype="multipart/form-data" novalidate="true"  class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">titulo</label>
                                    <div class="col-md-9">
                                        <input type="text"  class="form-control" v-model="titulo" placeholder="titulo del ejemplar">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Descripción">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                                    <div class="col-md-9">
                                        
                                        <!--la variable idcategoria asociado a v-model la asignamos
                                        en la propiedad data en javascript (ver al final) -->

                                        <select class="form-control" v-model="idcategoria">
                                          
                                          <!-- el id y nombre asociado en el objeto categoria vienen de los campos
                                          de la tabla categorias de la bd-->
                                          <option value="0" disabled>Seleccione</option>
                                          <!--el arrayCategoria es una variable de la data javascript de vue 
                                          y se cargan los registros de la categoria una vez se abra la ventana
                                          modal-->
                                          <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>

                                        </select>
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Colección</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idcoleccion">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="coleccion in arrayColeccion" :key="coleccion.id" :value="coleccion.id" v-text="coleccion.nombre"></option>
                                        </select>                                         
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Elaborado</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="elaborado">
                                                <option value="1" >Si</option>
                                                <option value="0" >No</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Editorial</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="editorial" class="form-control" placeholder="Editorial">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Año de publicación</label>
                                    <div class="col-md-9">
                                        <input type="text" name="fecha_publicacion" id="fecha_publicacion" v-model="fecha_publicacion" class="form-control" placeholder="ejemplo: 1995">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Cantidad</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="cantidad" class="form-control" placeholder="cantidad">
                                        <span v-if="errors.fecha_publicacion">{{errors.fecha_publicacion}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">autor</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="autor" class="form-control" placeholder="autor">
                                    </div>
                                </div>
                                <div class="form-group-row">
                                    <label class="col-md-3 form-control-label" for="text-input">Imagen</label>
                                    <div class="col-md-9">
                                        
                                          <div v-if="tipoAccion==1">
                                            <input type="file" @change="subirImagen" class="form-control" placeholder="">
                                            <img :src="imagen"  class="img-responsive" width="100px" height="100px">
                                        </div>
                                             

                                        <div v-if="tipoAccion==2">

                                                <img :src="'img/ejemplar/'+imagen"  width="100px" height="100px">
                                                <input type="file" @change="subirImagen" class="form-control" placeholder="">      
                                                <!--<img :src="'img/ejemplar/'+imagen"  width="100px" height="100px">-->                         
                                        </div>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                </div>
                                <div v-show="errorEjemplar" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjEjemplar" :key="error" v-text="error"></div>
                                    </div>
                                    <div class="text-center text-error">
                                        <span v-if="errors.fecha_publicacion">{{errors.fecha_publicacion}}</span>
                                    </div>
                                </div>


                                
                                <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjEjemplar" :key="error" v-text="error"></div>
                                </div>
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="submit" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarEjemplar()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarEjemplar()">Actualizar</button>
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
            ejemplar_id:0,
            idcategoria:0,
            idcoleccion:0,
            nombre_categoria:'',
            nombre_coleccion:'',
            titulo :"",
            descripcion : "",
            elaborado:0,
            editorial :"",
            fecha_publicacion: '',
            cantidad :0,
            imagen :'',
            autor :"",
            arrayEjemplar: [],
            modal:0,
            tituloModal:"",
            tipoAccion:0,
            errorEjemplar :0,
            errorMostrarMsjEjemplar:[],
            errors:[],
           
            pagination:{
 
                'total'        :0,
                'current_page' :0,
                'per_page'     :0,
                'last_page'    :0,
                'from'         :0,
                'to'           :0 
                 },
                 offset :3,
                 criterio : 'titulo',
                buscar : '',
                arrayCategoria:[],
                arrayColeccion:[]
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
            cargarPdf(){
                window.open('http://localhost:8000/ejemplar/listarPdf','_blank');
            },
           subirImagen(e){

               let me=this;//hace referencia a esta clase
               let file = e.target.files[0];
               let reader = new FileReader();//Instanciamos un lector de archuvos
               reader.onloadend=(file)=>{
                   me.imagen = reader.result;
               }
               reader.readAsDataURL(file);
           },
            listarEjemplar (page,buscar,criterio){
               let me=this;
                var url='/ejemplar?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEjemplar = respuesta.ejemplares.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            selectCategoria(){
                let me=this;
                var url='/categoria/selectCategoria';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCategoria = respuesta.categorias;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectColeccion(){
                let me=this;
                var url='/coleccion/selectColeccion';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayColeccion = respuesta.colecciones;
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
                me.listarEjemplar(page,buscar,criterio);
            },
            registrarEjemplar(){
                this.titulo= this.titulo.normalize('NFD').replace(/[\u0300-\u036f]/g,"");
                //texto.normalize('NFD').replace(/[\u0300-\u036f]/g,"");
                this.titulo = this.titulo.toUpperCase();
                //texto.normalize('NFD').replace(/[\u0300-\u036f]/g,"");

                if(this.validarEjemplar()){
                    return;
                }
                let me= this;
                axios.post('/ejemplar/registrar',{
                    'idcoleccion':this.idcoleccion,
                    'idcategoria':this.idcategoria,
                    'titulo': this.titulo,
                    'descripcion':this.descripcion,
                    'elaborado':this.elaborado,
                    'editorial':this.editorial,
                    'fecha_publicacion':this.fecha_publicacion,
                    'cantidad': this.cantidad,
                    'imagen': this.imagen,
                    'autor':this.autor
                }).then(function(response){
                    me.cerrarModal();
                    me.listarEjemplar(1,'','titulo');
                    this.fecha_publicacion=''
                })
                .catch(error =>{
                    if(error.response.status == 422){
                        this.errors= error.response.data.errors;
                        this.errorMostrarMsjEjemplar.push("El formato del año de publicación No es válido");
                    }
                });
                //.catch(function(error => ){
                  //  console.log(error.response);
                //});
            },
            validarEjemplarActualizar(){
                this.errorEjemplar=0;
                this.errorMostrarMsjEjemplar =[];            
                    
                if (this.idcategoria==0) this.errorMostrarMsjEjemplar.push("Debe seleccionar una categoría.");
                if (this.idcoleccion==0) this.errorMostrarMsjEjemplar.push("Debe eleccionar una colección.");
                if (!this.descripcion) this.errorMostrarMsjEjemplar.push("Debe ingresar una descripción.");
                if (!this.elaborado) this.errorMostrarMsjEjemplar.push("Debe ingresar si el ejemplar fue elaborado o no.");
                //if (!this.editorial) this.errorMostrarMsjEjemplar.push("Debe ingresar la editorial.");
                if (!this.titulo) this.errorMostrarMsjEjemplar.push("El nombre del ejemplar no puede estar vacío.");
                if (!this.cantidad) this.errorMostrarMsjEjemplar.push("La cantidad no puede ser nula.");
                if (!this.imagen) this.errorMostrarMsjEjemplar.push("Debe seleccionar una imagen");   
                if (this.errorMostrarMsjEjemplar.length) this.errorEjemplar = 1;

                return this.errorEjemplar;
            },
            validarEjemplar(){
                this.errorEjemplar=0;
                this.errorMostrarMsjEjemplar =[];
                    this.arrayEjemplar.forEach(element => {
                    if(element.nombre == this.nombre){
                        //this.errorCategoria=0;
                        this.errorMostrarMsjEjemplar.push("Este Ejemplar ya existe, por favor registrelo con otro titulo");
                        if(this.errorMostrarMsjEjemplar.length) this.errorEjemplar=1;
                        alert(element.titulo);
                        return this.errorEjemplar;
                    }
                        
                }); 
                
               // var expreg = /^[A-Z]{1,2}\s\d{4}\s([B-D]|[F-H]|[J-N]|[P-T]|[V-Z]){3}$/;
                //var expreg = /\b[0-9]{4}/;
        
                if (!this.titulo) this.errorMostrarMsjEjemplar.push("El titulo del ejemplar no puede estar vacío.");
                if (!this.descripcion) this.errorMostrarMsjEjemplar.push("Debe ingresar una descripción.");
                if (this.idcategoria==0) this.errorMostrarMsjEjemplar.push("Debe seleccionar una categoría.");
                if (this.idcoleccion==0) this.errorMostrarMsjEjemplar.push("Debe eleccionar una colección.");
                if (!this.elaborado) this.errorMostrarMsjEjemplar.push("Debe ingresar si el ejemplar fue elaborado o no.");
                //if (!this.editorial) this.errorMostrarMsjEjemplar.push("Debe ingresar la editorial.");
                if (!this.cantidad) this.errorMostrarMsjEjemplar.push("La cantidad no puede ser nula.");
                //if (!this.fecha_publicacion) this.errorMostrarMsjEjemplar.push("La fecha de publicación no puede ser nula");
                if (!this.autor) this.errorMostrarMsjEjemplar.push("El autor no puede ser nulo");
                if (!this.imagen) this.errorMostrarMsjEjemplar.push("Debe seleccionar una imagen");  
                
                /*else if (!this.validEmail(this.fecha_publicacion)) {
                        this.errorMostrarMsjEjemplar.push('El correo electrónico debe ser válido.');
                }*/
                //alert(this.fecha_publicacion);
                //console.log(this.fecha_publicacion);
                //str.length == 0
                /*if(this.fecha_publicacion){
                     if(expresion.test(fecha_publicacion) == false)
                     {
                        this.errorMostrarMsjEjemplar.push("El formato del año de publicación no es válido"); 
                     }         
                }
               
                if (this.errorMostrarMsjEjemplar.length) this.errorEjemplar = 1;*/            
                return this.errorEjemplar;
            },
            /*validEmail(fecha_publicacion) {
                 //var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var expreg = /\b[0-9]{4}/;
           return expreg.test(fecha_publicacion);
            },*/
            actualizarEjemplar(){
                
               if (this.validarEjemplarActualizar()){
                    return;
                }
                
                let me = this;

                axios.put('/ejemplar/actualizar',{
                    
                    'idcoleccion':this.idcoleccion,
                    'idcategoria':this.idcategoria,
                    'titulo': this.titulo,
                    'descripcion':this.descripcion,
                    'elaborado':this.elaborado,
                    'editorial':this.editorial,
                    'fecha_publicacion':this.fecha_publicacion,
                    'cantidad': this.cantidad,
                    'imagen': this.imagen,
                    'autor':this.autor,
                    'id': this.ejemplar_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarEjemplar(1,'','titulo');
                }).catch(error =>{
                    if(error.response.status == 422){
                        this.errors= error.response.data.errors;
                        this.errorMostrarMsjEjemplar.push("El formato del año de publicación no es válido");
                    }
                }); 
                

            },
            desactivarEjemplar(id){
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

                    axios.put('/ejemplar/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEjemplar(1,'','titulo');
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
            activarEjemplar(id){
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

                    axios.put('/ejemplar/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEjemplar(1,'','titulo');
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
            validarEjemplar(){
                this.errorEjemplar=0;
                this.errorMostrarMsjEjemplar=[];
                 if (!this.titulo) this.errorMostrarMsjEjemplar.push("El título del ejemplar no puede estar vacío.");
                 if (!this.descripcion) this.errorMostrarMsjEjemplar.push("Debe ingresar una descripción.");
                 if (this.idcategoria==0) this.errorMostrarMsjEjemplar.push("Debe seleccionar una categoría.");
                 if (this.idcoleccion==0) this.errorMostrarMsjEjemplar.push("Debe eleccionar una colección.");
                 if (!this.elaborado) this.errorMostrarMsjEjemplar.push("Debe ingresar si el ejemplar fue elaborado o no.");
                 if (!this.cantidad) this.errorMostrarMsjEjemplar.push("La cantidad no puede ser nula.");
                 if (!this.autor) this.errorMostrarMsjEjemplar.push("El autor no puede ser nulo.");
                 if(this.errorMostrarMsjEjemplar.length) this.errorEjemplar=1;
                return this.errorEjemplar;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal= "";
                this.titulo="";
                this.idcoleccion=0;
                 this.idcategoria=0;
                this.nombre_categoria="";
                this.nombre_coleccion="";
                this.descripcion="";
                this.elaborado="";
                this.editorial="";
                this.fecha_publicacion="";
                this.cantidad=0;
                this.imagen="";
                this.autor="";
                this.errorEjemplar=0;
            },
            abrirModal(modelo,accion,data=[]){
                switch(modelo){
                    case "ejemplar":{
                        switch(accion){
                            case "registrar":
                            {
                                this.modal=1;
                                this.titulo="";
                                this.descripcion="";
                                this.tituloModal="Registrar Ejemplar";
                                this.idcategoria=0;
                                this.nombre_categoria="";
                                this.idcoleccion=0;
                                this.nombre_coleccion="";
                                this.tipoAccion=1;
                                this.elaborado="";
                                this.editorial="";
                                this.fecha_publicacion=0;
                                this.cantidad=0;
                                this.imagen="";
                                break;
                            }
                            case "actualizar":
                            {
                    
                                this.modal=1;
                                this.tipoAccion=2;
                                this.tituloModal="Actualizar Ejemplar";
                                
                                this.ejemplar_id=data["id"];
                                this.titulo=data["titulo"];
                                this.autor=data["autor"];
                                this.descripcion= data["descripcion"];
                                //this.categoria=data['idcategoria'];
                                this.coleccion=data["coleccion"];
                                this.fecha_publicacion= data["fecha_publicacion"];
                                this.cantidad=data["cantidad"];
                                this.imagen=data["imagen"];
                                this.condicion=data["condicion"];
                                this.elaborado=data["elaborado"];
                                this.editorial=data["editorial"]
                               
                                
                                this.idcategoria=data["idcategoria"];
                                this.idcoleccion=data["idcoleccion"];
                            }    
                        }
                    }
                }
                this.selectCategoria();
                this.selectColeccion();
            }
        },
        mounted() {
            this.listarEjemplar(1,this.buscar,this.criterio);
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