<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 use App\Models\Invitado; 
use App\Models\Perfil; 
 use App\Models\Socio; 
 use App\Models\Clase;
 use Validator,Config,Image,Str;
 
class InvitadoController extends Controller
{
 
     //---> CONSTRUCTOR
    public function __construct(){
         $this->middleware('auth');
         $this->middleware('isadmin');
    }

    //---> VISTA INVITADOS
    public function getInvitados(){ 

    	$datos=Invitado::join('socios','socios.id','=','invitados.socio_id')
    	->join('clases','clases.id','=','invitados.clase_id')
    	->select('invitados.id as idinvit','invitados.name as name','invitados.lastname as lastname','invitados.dni as dniinvit','socios.clave as clave','clases.clase as clase','invitados.created_at')->get();
        $data =['datos'=>$datos];
        return view ('Backend/Invitado/home',$data);       
    }




    
    public function getEditInvit($id){ 
        $invit= Invitado::join('socios','socios.id','=','invitados.socio_id')
                ->select('invitados.id as idinvit','invitados.name as name','invitados.lastname as lastname','invitados.dni as dniinvit','invitados.socio_id as socio_id' )->where('invitados.id',$id)->first();

        $datacateg = Clase::get();  
        (count($datacateg) > 0)? $marc= Clase::pluck('clase' , 'id') : $marc= null; 
        $datac = Socio::get();  
        (count($datac) > 0)? $socys= Socio::where('perfil_id',1)->pluck('clave' , 'id') : $socys= null; 

        $data =['invit'=>$invit,'marc'=>$marc ,'socys'=>$socys];
        return view ('Backend/Invitado/edit',$data);       
    }


    public function postEditInvit(Request $request, $id){

        $bdd =Invitado::findOrFail($id);

        $rules   =[
                'first_name' =>'required|min:2|max:25',
                'last_name'  =>'required|min:2|max:25',
                'dni'        =>'required|unique:invitados,dni,'.$bdd->id,
                'selecperfil'=>'required',
                'selecclave'=>'required',
               ];
        $messages =[
                'first_name.required' =>'Su nombre es requerido.',
                'first_name.min'      =>'El Nombre debe de tener al menos 2 caracteres.',
                'first_name.max'      =>'El Nombre debe de tener maximo 25 caracteres.',
                'last_name.required'  =>'Su apellido es requerido.',
                'last_name.min'       =>'El Apellido debe de tener al menos 2 caracteres.',
                'last_name.max'       =>'El Apellido debe de tener maximo 25 caracteres.',
                'dni.required'        =>'Su Dni es requerido.',
                'dni.unique'          =>'Ya existe un Socio registrado con este DNi.',
                'selecperfil.required'=>'Tiene que elegir Adulto o Niño'   ,
                'selecclave.required'=>'Tiene que Seleccionar una clave de Socio'   ,
                 ];      

        $valida=Validator::make($request->all(),$rules,$messages);
        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{

            $continvit = Invitado::select('socio_id')->where('socio_id',$request->selecclave)->count();
            if ($continvit < 4) {

                $socy =  Invitado::findOrFail($id);
                $socy->name         = e($request->input('first_name'));
                $socy->lastname     = e($request->input('last_name'));
                $socy->dni          =$request->dni;
                $socy->socio_id     =$request->selecclave;
                $socy->clase_id     =$request->selecperfil;
                $socy->created_at   =$bdd->created_at;
                $socy->updated_at   =$bdd->updated_at;
                if ($socy->save()) {
                    return back()->with('success','Invitado ACtulizado con éxito. ✔️✔️✔️')->with('title','💌 Invitado actualizado con exito !!!.');
                }   
            }else{
                $socy =  Invitado::findOrFail($id);
                $socy->name         = e($request->input('first_name'));
                $socy->lastname     = e($request->input('last_name'));
                $socy->dni          =$request->dni;
                $socy->socio_id     =$bdd->socio_id;
                $socy->clase_id     =$request->selecperfil;
                $socy->created_at   =$bdd->created_at;
                $socy->updated_at   =$bdd->updated_at;
                if ($socy->save()) {
                    return back()->with('success','Datos ACtulizado sin cambio de Clave de socio ⚠️⚠️⚠️')->with('title','💌 datos actualizado!!!.');
                } 
                 

            }    
            
        }
    }



    //---> GET DELETE SOCIO
    public function getinvitdelete($id){
        $borra =Invitado::findOrFail($id);

        if ($borra->delete()) {
            return back()->with('success','Registro borrado con exito')->with('title',' Registro eliminado !!!.');
        }
    }
}
