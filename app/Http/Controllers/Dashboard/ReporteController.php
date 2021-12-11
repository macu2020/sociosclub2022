<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\Invitado; 
use App\Models\Clase;  
use App\Models\ReporteSociDia; 
use App\Models\Reporte_invi_dia;  

use Carbon\Carbon;
date_default_timezone_set('America/Bogota');
class ReporteController extends Controller
{
    //---> CONSTRUCTOR
    public function __construct(){
         $this->middleware('auth');
         $this->middleware('isadmin');
    }


    //---> VISTA REPORTE HOME SOCIO
    public function getReporHome(){
    	$datarepor = ReporteSociDia::get();  
        (count($datarepor) > 0)? $user= ReporteSociDia::all() : $user= null; 
        $data = ['user'=>$user]; 
        return view ('Backend/Reportes/reportesocio' ,$data);
    }	

    //---> VISTA REPORTE HOME INVITADOS
    public function getReporHomeinvi(){
    	$datarepor = Reporte_invi_dia::get();  
        (count($datarepor) > 0)? $datos= Reporte_invi_dia::all() : $datos= null; 
        $data = ['datos'=>$datos]; 
        return view ('Backend/Reportes/reporteinvitado' ,$data);
    } 
}
