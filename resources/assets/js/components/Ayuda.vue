<template>
<main class="main">
    <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Ayuda</a></li>
                <li class="breadcrumb-item active">Descargas</li>
            </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                        <i class="fa fa-align-justify"></i>Manuales
                        <!--<button type="button" @click="cargarPdf()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button>-->
                             
            </div>
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <h1 class="card-title">Aprende a usar la aplicación descargando las guías</h1>
            
            <br>
            <div >
                <div class="form-row">
                    <div class="form-group col-sm">
                        
                        <img :src="'img/manualp1.jpg'"  width="600px" height="350px">
                    </div>
                    <div class=" form-group col-sm">
                        
                        <img :src="'img/manualp.jpg'"  width="600px" height="350px">
                    </div>
                </div>
                <br>
                <button type="button" @click="cargarPdf()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button>
                <div class="form-row">
                    <button type="button" @click="cargarPdf()" class="btn btn-dark col-sm">Descargar Manual de usuario</button>&nbsp;&nbsp;
                    <button type="reset" class="btn btn-dark col-sm">Descargar Manual de programador</button>
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
        data(){},
methods: {
    cargarPdf(){
                window.open('http://localhost:8000/file/manualdeusuario','_blank');
            }
},
mounted() {}
        
}
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


