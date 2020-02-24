<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function manualdeusuario(){
        return response()->download(public_path('manualdeusuario.pdf'),'ManualDeUsuario');
    }
}
