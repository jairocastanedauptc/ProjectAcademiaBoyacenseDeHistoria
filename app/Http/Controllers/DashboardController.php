<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $anio=date('Y');
        $ejemplares=DB::table('ejemplares as i')
        ->select(DB::raw('MONTH(i.created_at) as mes'),
        DB::raw('YEAR(i.created_at) as anio'))
//DB::raw('SUM(i.total) as total'))
        //DB::raw('YEAR(i.fecha_hora) as anio'),
        //DB::raw('SUM(i.total) as total'))
        ->whereYear('i.created_at',$anio)
        ->groupBy(DB::raw('MONTH(i.created_at)'),DB::raw('YEAR(i.created_at)'))
        ->get();
 
        return ['ejemplares'=>$ejemplares,'anio'=>$anio];      
 
    }
}
