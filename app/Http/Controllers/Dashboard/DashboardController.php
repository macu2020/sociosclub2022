<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  
use App\Models\Socio;
use App\Models\Invitado; 
use App\Models\Clase;  
use App\Models\ReporteSociDia;   
use Validator,Config,Image,Str;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
date_default_timezone_set('America/Bogota');

class DashboardController extends Controller
{
     //---> CONSTRUCTOR
    public function __construct(){
         $this->middleware('auth');
         $this->middleware('isadmin');
    }

    //---> VISTA HOME DASHBOARD
    public function getHome(){
        $datacateg = Clase::get();  
        (count($datacateg) > 0)? $class= Clase::all() : $class= null; 
        $data = ['class'=>$class]; 

        return view ('Backend/homePrincipal' ,$data);
    } 
 

    //----> MOSTRAR EL SOCIO X CLAVE
    public function getshowsoci(Request $request){
        $rules =[ 'clave'=>'required'];
        $messages =[ 'clave.required' =>'Debe de seleccionar su Clave.' ];      

        $valida=Validator::make($request->all(),$rules,$messages);
        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{
          $cardarti =  Socio::join('perfils','perfils.id','=','socios.perfil_id')->join('clases','clases.id','=','socios.clase_id')->select( 'socios.estado as estadosoc','socios.id as idsoc','name' ,'lastname','dni','avatar','clave','perfils.tipo as tipo','clases.clase as clase','placa' )
                        ->where('clave','=',$request->clave)
                        ->groupBy( 'name','lastname','dni','avatar','clave','tipo','clase','idsoc','estadosoc','placa')->get()->toArray(); 
          $data =['datacla'=> $cardarti ]; 
          echo  json_encode($data);
        }
    }


    //----> INGRESO SOCIO X CLAVE PARA MODAL
    public function getshowsocimodal(Request $request){
        $rules =[ 'clave'=>'required'];
        $messages =[ 'clave.required' =>'Debe de seleccionar su Clave.' ];      

        $valida=Validator::make($request->all(),$rules,$messages);
        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{
          $cardarti =  Socio::join('perfils','perfils.id','=','socios.perfil_id')
          ->join('clases','clases.id','=','socios.clase_id')
          ->select(  DB::raw('CONCAT(name, " ", lastname) AS full_name')  ,'dni','avatar','clave','perfils.tipo as tipo','socios.created_at as diasox','socios.id as idsoc' )->where('socios.estado','=',1)
                        ->where('clave','=',$request->clave)
                        ->groupBy( 'full_name' ,'dni','avatar','clave','tipo','diasox' ,'idsoc')->get()->toArray(); 
          $data =['datacla'=> $cardarti ]; 
          echo  json_encode($data);
        }
    } 

    //----> INGRESO INVITADOS X CLAVE PARA MODAL 
    public function getshowinvimodal(Request $request){
        $rules =[ 'clave'=>'required'];
        $messages =[ 'clave.required' =>'Debe de seleccionar su Clave.' ];      

        $valida=Validator::make($request->all(),$rules,$messages);
        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{
          $cardarti =  Invitado::join('clases','clases.id','=','invitados.clase_id')
          ->join('socios','socios.id','=','invitados.socio_id')
          ->select(  DB::raw('CONCAT(invitados.name, " ", invitados.lastname) AS full_name')  ,'invitados.dni as dniinvi' ,'clases.clase as clasesoc'  ,'invitados.created_at as diasox','socios.clave AS claves' )->where('invitados.estado','=',1)
                        ->where('socios.clave','=',$request->clave)
                        ->groupBy( 'full_name' ,'dniinvi','clasesoc' ,'diasox','claves' )->get()->toArray(); 
             $data =['datacla'=> $cardarti ]; 
           
          echo  json_encode($data);
        }
    }



    //----> BUSCA KEYUP SOCIO - INVITADO
    public function buscaSoccio(Request $request){
        $datasoc =Socio::select('clave','perfil_id','name','lastname','id')->where('clave','LIKE',$request->inputclav)->where('perfil_id',1)->first(); 
        if ($datasoc !== null) {
            $continvit = Invitado::select('socio_id')->where('socio_id',$datasoc->id)->count();
            $adulto = Invitado::select('clase_id')->where('socio_id',$datasoc->id)->where('clase_id',1)->count();
            $nino = Invitado::select('clase_id')->where('socio_id',$datasoc->id)->where('clase_id',2)->count();
        }else{
            $continvit = null;
            $adulto = null;
            $nino = null;
        }
        $data =['datasoc'=> $datasoc ,'continvit'=>$continvit,'adulto'=>$adulto, 'nino'=>$nino];
        echo  json_encode($data);
    }


    //----> GUARDA INVITADO NUEVO
    public function saveInvitad(Request $request){
     
        $rules    =[
            'name'       =>'required|min:2|max:25',
            'lastname'   =>'required|min:2|max:25',
            'dni'        =>'required|unique:invitados',
            'clasoc'     =>'required',
            'selecatego' =>'required',
            ];
        $messages =[
              'name.required'    =>'Su nombre es requerido.',
              'lastname.required'=>'Su apellido es requerido.',
              'dni.required'     =>'Su Dni es requerido.',
              'dni.unique'       =>'Ya existe un Socio registrado con este DNi.',
              'clasoc.required'  =>'Su Clave del socio es requerido.',
              'selecatego.required' =>'Debe indicar si es Adulto o niño.',
                  ];      

        $valida=Validator::make($request->all(),$rules,$messages);
        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{
          //----> MOSTRAR EL "ID" DE LA CLAVE DEL SOCIO
          $dataclave =Socio::select('clave','id')->where('clave','LIKE',$request->clasoc)->where('perfil_id',1)->first();   

            if ($dataclave) {
              //---> MOSTRAR LA CANTIDAD DE INIVTADOS DEL MISMO SOCIO
             
          $continvit = Invitado::select('socio_id')->where('socio_id',$dataclave->id)->count();
            //-----> MAXIMO INIVITADOS  ES 4
            if ($continvit < 4) {
              $user=Invitado::create([
                  'name'      =>$request->name,   
                  'lastname'  =>$request->lastname,
                  'dni'       =>$request->dni,
                  'socio_id'  =>$dataclave->id ,
                  'clase_id'  =>$request->selecatego ,
                  'created_at'=> now(),
                  'updated_at'=> now(), 
                  'estado'    => 1,
                  'horas'     => DATE(NOW()->format("H")),
               ]);
               return redirect ()->back()->with('success','invitado registrado con exito!!!')->with('title','💌 Su invitado se registro con exito !!!.');
             }else{
              return redirect()->back()->with('errores','Alcanzo el limite de invitado!!!')->withInput();

            }

                 

              
            }else{
              return redirect()->back()->with('errores','Esta clave de socio no existe !!!')->withInput();
            }
          }  
    }


    //----> ACTUALIZA INGRESO DE SOCIO
    public function getUpdateSoccio(Request $request){ 
        $rules =[ 'clave'=>'required',  ];
        $messages =[ 'clave.required' =>'Debe de seleccionar su asistencia.', ];      

        $valida=Validator::make($request->all(),$rules,$messages);
        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{
            $datasoc =  Socio::findOrFail($request->clave);
            $datasoc->name = $datasoc->name;
            $datasoc->estado = 1;
            $datasoc->created_at = now();
            $datasoc->updated_at = now();
            $datasoc->horas = DATE(NOW()->format("H"));

            if ($datasoc->save()) {
              $data=DB::select('call insertsociodia(?,?,?,?,?,?,?,?,?,?,?,?,?)',array($datasoc->id,$datasoc->clave,$datasoc->name,$datasoc->lastname,$datasoc->dni,$datasoc->perfil_id,$datasoc->parentesco_id,$datasoc->clase_id,$datasoc->email,$datasoc->estado,$datasoc->avatar,
              DATE(NOW()->format("H:i:s")),DATE(NOW()->format("Y-m-d")) ));

              $mensaje = "exito";
            }else{
                   $mensaje = "falso";
            }

            $data =['mensaje'=> $mensaje  ];
            echo  json_encode($mensaje);
        }
    }


    //----> ACTUALIZA SALIDA DE SOCIO
    public function getUpdatenullSoccio(Request $request){
        $rules =[ 'clave'=>'required', ];
        $messages =[  'clave.required' =>'Debe de seleccionar su asistencia.', ];      

        $valida=Validator::make($request->all(),$rules,$messages);
        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{
            $datasoc =  Socio::findOrFail($request->clave);
            $datasoc->estado = 0;
            $datasoc->created_at = now();
            $datasoc->updated_at = now();
            $datasoc->horas = 0;

            if ($datasoc->save()) {
                  $mensaje = "exitoso";
            }else{
                   $mensaje = "falso";
            }

            $data =['mensaje'=> $mensaje  ];
            echo  json_encode($data);
        }
    }


    //----> VALIDA DNI INVITADO
    public function checkdni(Request $request){
      $invitado=Invitado::where('dni',$request->dni)->first();
        if($invitado){
            echo 'false';
        }else{
            echo 'true';
      } 
    }


    //---> GRAFICOS
    public function postDashboard(Request $request){  
        $result1 =array(); //--->socios
        $result2 =array();
        $result3 =array();
        $result4 =array();

        $result5 =array(); //--->invitados 
        $result6 =array();  
  
        $sociXadul =Socio::join('clases', 'clases.id', '=', 'socios.clase_id')
                    ->select('clases.clase',
                                DB::raw('SUM(socios.estado) as m_total'))
                    ->groupBy('clases.id','clases.clase')->where('socios.estado',1)->where('socios.horas','>',0)
                    ->get();
          
        $sociXhora =DB::table('socios')
            ->select('socios.horas',DB::raw('sum(socios.estado) as cantidad'))
            ->groupBy('socios.horas')->where('estado',1)->where('horas','>',0)
            ->get()->toArray();    

        $sociXdia =DB::table('reporte_soci_dias')
            ->select('reporte_soci_dias.dia',DB::raw('sum(reporte_soci_dias.estado) as cantidad'))
            ->groupBy('reporte_soci_dias.dia')->where('estado',1) 
            ->get()->toArray();     



          foreach ($sociXhora as $value) {
            array_push($result1, array($value->horas, $value->cantidad));                                                    
          } 
          foreach ($sociXadul as $valpie) {
            array_push($result2, array($valpie["clase"], $valpie["m_total"]));                 
          } 
          foreach ($sociXdia as $value) {
            array_push($result3, array($value->dia, $value->cantidad));                                                    
          } 
  
        
        $inviXadul =Invitado::join('clases', 'clases.id', '=', 'invitados.clase_id')
                    ->select('clases.clase',
                                DB::raw('SUM(invitados.estado) as m_total'))
                    ->groupBy('clases.id','clases.clase')->where('invitados.estado',1)->where('invitados.horas','>',0)
                    ->get();
        $inviXhora =DB::table('invitados')
            ->select('invitados.horas',DB::raw('sum(invitados.estado) as cantidad'))
            ->groupBy('invitados.horas')->where('estado',1)->where('horas','>',0)
            ->get()->toArray();     
        $inviXdia =DB::table('reporte_invi_dias')
            ->select('reporte_invi_dias.dia',DB::raw('sum(reporte_invi_dias.estado) as cantidad'))
            ->groupBy('reporte_invi_dias.dia')->where('estado',1) 
            ->get()->toArray();     
    

        foreach ($inviXhora as $value) {
            array_push($result5, array($value->horas, $value->cantidad));                                                    
          }    
        foreach ($inviXadul as $valpie) {
            array_push($result6, array($valpie["clase"], $valpie["m_total"]));                 
          }
        foreach ($inviXdia as $value) {
            array_push($result4, array($value->dia, $value->cantidad));                                                    
          }  
            
        $data = [1 =>$result1,2=> $result2,3=>$result3,4=>$result4, 5=> $result5,6=> $result6 ];
        print json_encode($data, JSON_NUMERIC_CHECK) ;
    }

 
     

    //----> GET DASHBOARD
    /*public function getDashboard(){

         return redirect('/home');
    }*/


    //----> CONSULATA DE INGRESOS
    public function getConsulIngreso(){
        $user = Socio::select('id','name','lastname','dni','perfil_id','clave','email','estado','created_at','avatar')->where('estado',1)->get();
         $data =['user'=>$user];
         return view ('Backend/Consultas/ingresosocy',$data  );
    }
    


    //---> VISTA INVITADOS
    public function getConsulIngresoinvi(){ 

      $datos=Invitado::join('socios','socios.id','=','invitados.socio_id')
      ->join('clases','clases.id','=','invitados.clase_id')
      ->select('invitados.id as idinvit','invitados.name as name','invitados.lastname as lastname','invitados.dni as dniinvit','socios.clave as clave','clases.clase as clase','invitados.created_at')->get();
        $data =['datos'=>$datos];
        return view ('Backend/Consultas/ingresoinvi',$data);       
    }


    //----> CONSULTA DEGET DE INVITADOI EDITAR
    public function getEditInvitconsu($id){ 
        $invit= Invitado::join('socios','socios.id','=','invitados.socio_id')
                ->select('invitados.id as idinvit','invitados.name as name','invitados.lastname as lastname','invitados.dni as dniinvit','invitados.socio_id as socio_id' )->where('invitados.id',$id)->first();

        $datacateg = Clase::get();  
        (count($datacateg) > 0)? $marc= Clase::pluck('clase' , 'id') : $marc= null; 
        $datac = Socio::get();  
        (count($datac) > 0)? $socys= Socio::where('perfil_id',1)->pluck('clave' , 'id') : $socys= null; 

        $data =['invit'=>$invit,'marc'=>$marc ,'socys'=>$socys];
        return view ('Backend/Consultas/editinvi',$data);       
    }


      
    //----> MOSTRAR EL SOCIO X CLAVE
    public function postBuscasoci(Request $request){
        $rules =[ 'clave'=>'required'];
        $messages =[ 'clave.required' =>'Debe de seleccionar su Clave.' ];      

        $valida=Validator::make($request->all(),$rules,$messages);
        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{
          $cardarti =  Socio::join('perfils','perfils.id','=','socios.perfil_id')->join('clases','clases.id','=','socios.clase_id')->select( 'socios.estado as estadosoc','socios.id as idsoc','name' ,'lastname','dni','avatar','clave','perfils.tipo as tipo','clases.clase as clase' )
                        ->where('clave','=',$request->clave)->where('socios.estado','=',1)
                        ->groupBy( 'name','lastname','dni','avatar','clave','tipo','clase','idsoc','estadosoc')->get()->toArray(); 
          $data =['datacla'=> $cardarti ]; 
          echo  json_encode($data);
        }
    }


    public function getHomeqr(){
      $datacateg = Clase::get();  
        (count($datacateg) > 0)? $class= Clase::all() : $class= null; 
        $data = ['class'=>$class]; 

        return view ('Backend/Adminqr/home' ,$data);
    }

    
     // public function checkQrcode(Request $request){
       public function postcamarasca(Request $request, $id){
        header('Access-Control-Allow-Origin: *');

        $dni = substr($id, -8, 8); // devuelve "d"


        
        $dataajax = Socio::select('name','lastname','id')->where("dni",$dni)->first()  ;
       


        $msg='';
        if($dataajax){
             $datasoc = Socio::findOrFail($dataajax->id);
            if ($datasoc->estado == 1) {
                $msg="existe";
            }else{
                $datasoc->estado = 1;
                $datasoc->created_at = now();
                $datasoc->updated_at = now();
                $datasoc->horas = DATE(NOW()->format("H"));
                if ($datasoc->save()) {
                $msg='ok';
                }
            }
        }else{
            $msg='error';
        }
        return response()->json(['msg'=>$msg,'datasocio'=>$datasoc]);
    }
}

