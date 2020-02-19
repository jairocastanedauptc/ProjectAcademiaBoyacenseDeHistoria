<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="car-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Ejemplares</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="ejemplares">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Ejemplares de los últimos meses.</p>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Ventas</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="ventas">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Ventas de los últimos meses.</p>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>

</main>
</template>
<script>
    export default {
        data (){
            return {
                varEjemplar:null,
                charEjemplar:null,
                ejemplares:[],
                varTotalEjemplar:[],
                varMesEjemplar:[], 
                
                //varVenta:null,
                //charVenta:null,
                //ventas:[],
                //varTotalVenta:[],
                //varMesVenta:[],
            }
        },
        methods : {
            getEjemplares(){
                let me=this;
                var url= '/dashboard';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.ejemplares = respuesta.ejemplares;
                    //cargamos los datos del chart
                    me.loadEjemplares();
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            },
            /*getVentas(){
                let me=this;
                var url= '/dashboard';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.ventas = respuesta.ventas;
                    //cargamos los datos del chart
                    me.loadVentas();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },*/
            loadEjemplares(){
                let me=this;
                me.ejemplares.map(function(x){
                    me.varMesEjemplar.push(x.mes);
                    me.varTotalEjemplar.push(x.total);
                });
                me.varEjemplar=document.getElementById('ejemplares').getContext('2d');

                me.charEjemplar = new Chart(me.varEjemplar, {
                    type: 'bar',
                    data: {
                        labels: me.varMesEjemplar,
                        datasets: [{
                            label: 'Ejemplares',
                            data: me.varTotalEjemplar,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },
           /*loadVentas(){
                let me=this;
                me.ventas.map(function(x){
                    me.varMesVenta.push(x.mes);
                    me.varTotalVenta.push(x.total);
                });
                me.varVenta=document.getElementById('ventas').getContext('2d');

                me.charVenta = new Chart(me.varVenta, {
                    type: 'bar',
                    data: {
                        labels: me.varMesVenta,
                        datasets: [{
                            label: 'Ventas',
                            data: me.varTotalVenta,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            }*/
        },
        mounted() {
            this.getEjemplares();

        }
    }
</script>
