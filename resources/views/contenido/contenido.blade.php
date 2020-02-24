    @extends('principal')
    @section('contenido')
        <template v-if="menu==0">
            <dashboard></dashboard>
        </template>

        <template v-if="menu==1"><categoria></categoria> </template>

        <template v-if="menu==2">
            <coleccion></coleccion>
        </template>  

        <template v-if="menu==4">
            <ejemplar></ejemplar>
        </template>

        <template v-if="menu==5">
            <registro></registro>
        </template>


        <template v-if="menu==6">
            <user></user>
        </template>

        <template v-if="menu==7">
        <rol><rol>
            
        </template>

       <!-- <template v-if="menu==8">
        <h1>Contenido del menú 8</h1>
        </template>-->

        <template v-if="menu==9">
            <ayuda></ayuda>
        </template>

        <template v-if="menu==10">
            <h1>Contenido del menú 10</h1>
        </template>

        <template v-if="menu==11">
            <h1>Contenido del menú 11</h1>
        </template>

        <template v-if="menu==12">
            <h1>Contenido del menú 12</h1>
        </template>
        
    @endsection