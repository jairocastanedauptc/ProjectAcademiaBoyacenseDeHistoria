<template>
<main class="main">
    <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Acerca de</a></li>
            </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                        <i class="fa fa-align-justify"></i>PROYECTO FINAL -->GERENCIA DE PROYECTOS
                        <!--<button type="button" @click="cargarPdf()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button>-->
                             
            </div>
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <br>
                    <div class="container-fluid">
                        <div class="row text-black text-center border">
                                <div class="col-4 bg-white ">
                                    <img  :src="'img/sistemas.png'" style="width: 100%; height:100%;" >
                                </div>
                                <div class="col-8 bg-white ">
                                    <h5 class="text-justify">Sistema bibliotecario realizado para la Academia Boyacense de Historia como trabajo final de la materia GERENCIA INFORMÁTICA de Ingeniería de Sistemas y Computación de la Universidad Pedagógica y Tecnológica de Colombia Seccional Sogamoso, un proyecto desarrollado por: </h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">Hans Arevalo Barrera
                                            <span class="badge badge-primary badge-pill">DIRECTOR</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">Karen Juliana Cano Vega

                                            <span class="badge badge-primary badge-pill">ANALISTA DE REQUISITOS</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">Miler Yesid Menjure Barrera

                                            <span class="badge badge-primary badge-pill">TESTER</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">Jimmy Alejandro plazas López
                                            <span class="badge badge-primary badge-pill">SEGUIMIENTO</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">Jairo Alejandro Castañeda Pedraza
                                            <span class="badge badge-primary badge-pill">DESARROLLADOR</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">Edmundo Arturo Junco Orduz
                                            <span class="badge badge-primary badge-pill">DOCENTE DE ASIGNATURA</span>
                                        </li>
                                    </ul>
                                </div>
                        </div>
                        <div class="row text-black text-center border">
                                <div class="col-3 bg-white ">
                                    <img  :src="'img/laravel2.jpg'" style="width: 100%; height:100%;" >
                                </div>
                                <div class="col-9 bg-white ">
                                    <h2>FRAMEWORK BACK-END</h2><br>
                                    <h5 class="text-justify">Laravel en su versión 5.6 es estable,  permita el uso de una sintaxis elegante y expresiva para crear código de forma sencilla y permitiendo multitud de funcionalidades.
                                    Gran parte de Laravel está formado por dependencias, especialmente de Symfony, esto implica que el desarrollo de Laravel dependa también del desarrollo de sus dependencias.</h5>
                                    <h5 class="text-justify">Laravel propone en el desarrollo usar 'Routes with Closures', en lugar de un MVC tradicional con el objetivo de hacer el código más claro. Por estas razones se decidió trabajar con este robusto framework de php</h5>
                                </div>
                        </div>
                         <div class="row text-black text-center border">
                                <div class="col-3 bg-white ">
                                    <img  :src="'img/vue2.jpg'" style="width: 100%; height:100%;" >
                                </div>
                                <div class="col-9 bg-white ">
                                    <h2>FRAMEWORK FONT-END</h2><br>
                                    <h5 class="text-justify">Para implementar de una manera moderna la vista se utilió Vuejs, el cual es un framework open source de JavaScript, el cual nos permite construir interfaces de usuarios de una forma muy sencilla.Una de las características más importantes de Vue es el trabajo con componentes. Un componente Vue, en términos simples, es un elemento el cual se encapsula código reutilizable. Dentro de un componente podremos encontrar etiquetas HTML, estilos de CSS y código JavaScript</h5>
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
</script>
<style>
.top {
    padding-top:50px;
    height:92px;
    overflow:hidden;
}
.top .addthis {
    float: left;
    width: 995px;
}
</style>


