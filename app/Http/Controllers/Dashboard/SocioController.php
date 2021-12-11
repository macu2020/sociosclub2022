<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perfil; 
use App\Models\Socio; 
use App\Models\Clase; 
use Mail;
use App\Mail\EmailContact;
use QrCode;
use App\Models\Parentesco; 
use Illuminate\Support\Facades\DB;
use Validator,Config,Image,Str;
use Carbon\Carbon;
date_default_timezone_set('America/Bogota');

class SocioController extends Controller
{
     //---> CONSTRUCTOR
    public function __construct(){
         $this->middleware('auth');
         $this->middleware('isadmin');
    }


    //---> SOCIOS INICIAL TABLE
    public function getHomeSoccio(){ 
        $user = Socio::all();
        $data =['user'=>$user];
        return view ('Backend/Socio/home',$data);       
    }



    //---> SOCIOS CREATE
    public function getAddSoccio(){ 
  
        $datacateg = Clase::get();  
        (count($datacateg) > 0)? $class= Clase::all() : $class= null; 
		$class_1 = Clase::all()->first();
        $dataperfi = Perfil::get();  
        (count($dataperfi) > 0)? $perfi= Perfil::all() : $perfi= null;
        $dataparent = Parentesco::get();  
        (count($dataparent) > 0)? $parent= Parentesco::all() : $parent= null; 
		$parent_1 = Parentesco::take(2)->get();
        $data = ['parent'=> $parent,'class'=>$class,'perfi'=>$perfi ,'class_1'=>$class_1,'parent_1'=>$parent_1]; 
        return view ('Backend/Socio/add',$data  );       
    } 

    
    //---> GUARDA NUEVO SOCIO
    public function postAddSoccio(Request $request){
    	$rules    =[ 'selecperfil'=>'required' ];
        $messages =[ 'selecperfil.required'=>'Su Perfil es necesario !!!' ];
		$valida   =Validator::make($request->all(),$rules,$messages);

        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{

			$rules    =[
		        'first_name' =>'required|min:2|max:25',
		        'last_name'  =>'required|min:2|max:25',
		        'email'      =>'required|email|unique:socios',
		        'dni'        =>'required|min:8|max:8|unique:socios',
		        'selecatego' =>'required',
		        'selecatego' =>'required',
		        'selecparent'=>'required',
		        'placa_socio'=>'max:7',
 	         ];
        	$messages =[
	            'first_name.required' =>'Su nombre es requerido.',
            	'first_name.min'      =>'El Nombre debe de tener al menos 2 caracteres.',
            	'first_name.max'      =>'El Nombre debe de tener maximo 25 caracteres.',
	            'last_name.required'  =>'Su Apellido es requerido.',
            	'last_name.min'       =>'El Apellido debe de tener al menos 2 caracteres.',
            	'last_name.max'       =>'El Nombre debe de tener maximo 25 caracteres.',
	            'email.required'      =>'Su correo electronico es requerido.',
	            'email.email'         =>'El formato de su correo electronico es invalido.',
	            'email.unique'        =>'Ya existe un Socio registrado con ese correo.',
				'dni.required'        =>'Su Dni es requerido.',
	            'dni.email'           =>'Ya existe un Socio registrado con este DNi.',
	            'selecperfil.required'=>'Su Perfil es necesario !!!'   ,
             	'placa_socio.max'     =>'La placa del socio debe de tener maximo 7 caracteres.',
                 ];      

        $valida=Validator::make($request->all(),$rules,$messages);
        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{

        	if ($request->hasfile('avatar')) {
        		//socios guardado con foto
                $rules =['avatar'    =>'required|mimes:png,jpg,jpeg|max:2048'];
                $messages =[
                 	'avatar.required'=>'Su Imagen es requerido !!!',
            		'avatar.mimes'   =>'Este formato de archivo no es una imagen !!!',
            		'avatar.max'     =>'Peso maximo de imagen 2MB !!!',
                ];
                $valida=Validator::make($request->all(),$rules,$messages);
		        if ($valida->fails()) {
		            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
		        }else{
		        	// socio titular con foto
		        	if ($request->selecperfil == 1) {
     		  
		        		$fileExt = trim($request->file('avatar')->getClientOriginalExtension());
                		$upload_path = Config::get('filesystems.disks.uploads_socio.root');
                		$name = Str::slug(str_replace($fileExt,'',$request->file('avatar')->getClientOriginalName()));
                		$filename = rand(1,999).'_'.$name.'.'.$fileExt;

				 	 	$data=DB::select('call inserta(?,?,?,?,?,?,?,?,?)',array($request->first_name,$request->last_name,$request->dni,$request->selecperfil,$request->selecparent,$request->selecatego,$request->email,$filename,$request->placa_socio ));
 						$arrayprocedure = json_decode(json_encode($data), true);
						$path = '/soc_'.$arrayprocedure[0]["LAST_INSERT_ID()"];
						 
	                 	$file_file = $upload_path.'/'.$path.'/'.$filename;
	                    $fl = $request->avatar->storeAs($path,$filename, 'uploads_socio');
	                    $img = Image::make($file_file);
	                    $img->fit(200,200,function($constraint){
	                        $constraint->upsize();
	                    });
	                    $img->save($upload_path.'/'.$path.'/av_'.$filename);
	                    $useremail=$arrayprocedure[0];

	                    QrCode::format('png')->size(300)->generate($arrayprocedure[0]["macuri"].$request->dni,'../public/img/imgqrcode/code-soc-'.$arrayprocedure[0]["LAST_INSERT_ID()"].'.png');

	                    Mail::to($request->email)->send(new EmailContact($useremail));
            		return redirect ('/socios')->with('success','Socio creado con exito!!!')->with('title','💌 Su Socio se creo con exito !!!.');
	            	}
	            	else if ($request->selecperfil == 2){
	            		// socio conyuge con foto
	            		$rules  	=['clavetit' =>'required',];
            			$messages 	=['clavetit.required' =>'Su Clave de Socio es requerido.',];
            			$valida=Validator::make($request->all(),$rules,$messages);
			        	if ($valida->fails()) {
			            	return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
			        	}else{	
				        	//buscamos la clave y comparamos si exiet
				        	$dataclave =Socio::select('clave')->where('clave','LIKE',$request->clavetit)->first();         
				        	if ($dataclave) {

				        		//validamos si hay un conyuge existente
				        		$dataconyuge =Socio::select('name')->where('clave','LIKE',$request->clavetit)->where('perfil_id','LIKE',2)->first();         
				        	 
				        		if ($dataconyuge == null) {
				        			 //no exites conyuge de este socio
				        			$fileExt = trim($request->file('avatar')->getClientOriginalExtension());
	                				$upload_path = Config::get('filesystems.disks.uploads_socio.root');
	                				$name = Str::slug(str_replace($fileExt,'',$request->file('avatar')->getClientOriginalName()));
	                				$filename = rand(1,999).'_'.$name.'.'.$fileExt;


					        		$user=Socio::create([
					                'name'   	   =>$request->first_name,
					                'lastname'	   =>$request->last_name,
					                'dni'	  	   =>$request->dni,
					                'email'	  	   =>$request->email,
					                'perfil_id'    =>$request->selecperfil,
					                'parentesco_id'=>$request->selecparent,
					                'clase_id'     =>$request->selecatego,
					                'avatar'       =>$filename ,
					                'clave'        =>$dataclave->clave ,
					                'placa'        =>$request->placa_socio ,
					             	]);
					             	$path = '/soc_'.$user->id;
				                 	$file_file = $upload_path.'/'.$path.'/'.$filename;
				                    $fl = $request->avatar->storeAs($path,$filename, 'uploads_socio');
				                    $img = Image::make($file_file);
				                    $img->fit(200,200,function($constraint){
				                        $constraint->upsize();
				                    });
				                    $img->save($upload_path.'/'.$path.'/av_'.$filename);
					             	
				                    QrCode::format('png')->size(300)->generate($user->clave.$request->dni,'../public/img/imgqrcode/code-soc-'.$user->id.'.png');
				                    $useremail=array("LAST_INSERT_ID()"=>$user->id,"name"=>$user->name,"macuri"=>$user->clave,'dni'=>$user->dni);

	                    			Mail::to($request->email)->send(new EmailContact($useremail));
					             	return redirect ('/socios')->with('success','Conyuge de Socios creado con exito!!!')->with('title','💌 Su socio se creo con exito !!!.');
				             	}else{
				             		//si existe este conyuge
				             		return redirect()->back()->with('errores','Ya  existe Conyuge para este socio !!!')->withInput();	
				             	}


				        	}else{
				        		return redirect()->back()->with('errores','Esta clave de socio no existe !!!')->withInput();	
				        	}
			        	}

	            	}else if($request->selecperfil == 3){
	            		$rules    =['clavetit' =>'required',];
	            		$messages =['clavetit.required' =>'Su Clave de Socio es requerido.',];
	            		$valida=Validator::make($request->all(),$rules,$messages);
				        if ($valida->fails()) {
				            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
				        }else{
				        	//buscamos la clave y comparamos si existe
				        	$dataclave =Socio::select('clave')->where('clave','LIKE',$request->clavetit)->first();         
				        	if ($dataclave) {
				        		$fileExt = trim($request->file('avatar')->getClientOriginalExtension());
		                		$upload_path = Config::get('filesystems.disks.uploads_socio.root');
		                		$name = Str::slug(str_replace($fileExt,'',$request->file('avatar')->getClientOriginalName()));
		                		$filename = rand(1,999).'_'.$name.'.'.$fileExt;
				        		$user=Socio::create([
					                'name'   	   =>$request->first_name,
					                'lastname'	   =>$request->last_name,
					                'dni'	  	   =>$request->dni,
					                'email'	  	   =>$request->email,
					                'perfil_id'    =>$request->selecperfil,
					                'parentesco_id'=>$request->selecparent,
					                'clase_id'     =>$request->selecatego,
					                'avatar'       =>$filename ,
					                'clave'        =>$dataclave->clave ,
					                'placa'        =>$request->placa_socio ,
					             	]);
				        		$path = '/soc_'.$user->id;
			                 	$file_file = $upload_path.'/'.$path.'/'.$filename;
			                    $fl = $request->avatar->storeAs($path,$filename, 'uploads_socio');
			                    $img = Image::make($file_file);
			                    $img->fit(200,200,function($constraint){
			                        $constraint->upsize();
			                    });
			                    $img->save($upload_path.'/'.$path.'/av_'.$filename);
								QrCode::format('png')->size(300)->generate($user->clave.$request->dni,'../public/img/imgqrcode/code-soc-'.$user->id.'.png');
				                $useremail=array("LAST_INSERT_ID()"=>$user->id,"name"=>$user->name,"macuri"=>$user->clave,'dni'=>$user->dni);
	                    		Mail::to($request->email)->send(new EmailContact($useremail));	
	                    		return redirect ('/socios')->with('success','Familiar de Socios creado con exito!!!')->with('title','💌 Su Socio se creo con exito !!!.');
				        	}else{
				        		return redirect()->back()->with('errores','Esta clave de socio no existe !!!')->withInput();
				        	}

				        }

	            	}//fin de perfiles guardado con foto
	            	 

		        	
                	 
		        }

                
            }else{
            	//socios guardados sin foto

            	if ($request->selecperfil == 1) {
     		  
     		   
			 	  $data= DB::select('call inserta(?,?,?,?,?,?,?,?,?)',array($request->first_name,$request->last_name,$request->dni,$request->selecperfil,$request->selecparent,$request->selecatego,$request->email,NULL,$request->placa_socio));
			 	  $arrayprocedure = json_decode(json_encode($data), true);
			 	  QrCode::format('png')->size(300)->generate($arrayprocedure[0]["macuri"].$request->dni,'../public/img/imgqrcode/code-soc-'.$arrayprocedure[0]["LAST_INSERT_ID()"].'.png');
					$useremail=$arrayprocedure[0];
	                Mail::to($request->email)->send(new EmailContact($useremail));
            		return redirect ('/socios')->with('success','Socio creado con exito!!!')->with('title','💌 Su Socio se creo con exito !!!.');
            	}else if ($request->selecperfil == 2){
            		$rules    =[ 
            					'clavetit' =>'required',];
            		$messages =[
            				    'clavetit.required' =>'Su Clave de Socio es requerido.',];
            		$valida=Validator::make($request->all(),$rules,$messages);
			        if ($valida->fails()) {
			            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
			        }else{	
			        	//buscamos la clave y comparamos si exiet
			        	$dataclave =Socio::select('clave')->where('clave','LIKE',$request->clavetit)->first();         
			        	if ($dataclave) {

			        		//validamos si hay un conyuge existente
			        		$dataconyuge =Socio::select('name')->where('clave','LIKE',$request->clavetit)->where('perfil_id','LIKE',2)->first();         
			        	 
			        		if ($dataconyuge == null) {
			        			 //no exites conyuge de este socio
				        		$user=Socio::create([
				                'name'   	   =>$request->first_name,
				                'lastname'	   =>$request->last_name,
				                'dni'	  	   =>$request->dni,
				                'email'	  	   =>$request->email,
				                'perfil_id'    =>$request->selecperfil,
				                'parentesco_id'=>$request->selecparent,
				                'clase_id'     =>$request->selecatego,
				                'avatar'       =>null ,
				                'clave'        =>$dataclave->clave ,
				                'placa'        =>$request->placa_socio ,
				             	]);
								QrCode::format('png')->size(300)->generate($user->clave.$request->dni,'../public/img/imgqrcode/code-soc-'.$user->id.'.png');
				                $useremail=array("LAST_INSERT_ID()"=>$user->id,"name"=>$user->name,"macuri"=>$user->clave,'dni'=>$user->dni);

	                    		Mail::to($request->email)->send(new EmailContact($useremail));

				             	return redirect ('/socios')->with('success','Conyuge de Socios creado con exito!!!')->with('title','💌 Su Socio se creo con exito !!!.');
			             	}else{
			             		//si existe este conyuge
			             		return redirect()->back()->with('errores','Ya  existe Conyuge para este socio !!!')->withInput();	
			             	}


			        	}else{
			        		return redirect()->back()->with('errores','Esta clave de socio no existe !!!')->withInput();	
			        	}
			        }	    


            	}else if ($request->selecperfil == 3){

            		$rules    =['clavetit' =>'required',];
            		$messages =['clavetit.required' =>'Su Clave de Socio es requerido.',];
            		$valida=Validator::make($request->all(),$rules,$messages);
			        if ($valida->fails()) {
			            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
			        }else{
			        	//buscamos la clave y comparamos si existe
			        	$dataclave =Socio::select('clave')->where('clave','LIKE',$request->clavetit)->first();         
			        	if ($dataclave) {
			        		$user=Socio::create([
				                'name'   	   =>$request->first_name,
				                'lastname'	   =>$request->last_name,
				                'dni'	  	   =>$request->dni,
				                'email'	  	   =>$request->email,
				                'perfil_id'    =>$request->selecperfil,
				                'parentesco_id'=>$request->selecparent,
				                'clase_id'     =>$request->selecatego,
				                'avatar'       =>null ,
				                'clave'        =>$dataclave->clave ,
				                'placa'        =>$request->placa_socio ,
				             	]);
			        		QrCode::format('png')->size(300)->generate($user->clave.$request->dni,'../public/img/imgqrcode/code-soc-'.$user->id.'.png');
				                $useremail=array("LAST_INSERT_ID()"=>$user->id,"name"=>$user->name,"macuri"=>$user->clave,'dni'=>$user->dni);

	                    		Mail::to($request->email)->send(new EmailContact($useremail));
				             	return redirect ('/socios')->with('success','Familiar de Socios creado con exito!!!')->with('title','💌 Su Socio se creo con exito !!!.');
			        	}else{
			        		return redirect()->back()->with('errores','Esta clave de socio no existe !!!')->withInput();
			        	}

			        }
            		 
            	}//finde perfiles guardas sin foto
            	

             
            }


			

        }














			// FINDE VALIDA SELCET
        }	  
    } 



    //----> VALIDA DNI SOCIO
    public function checkdni(Request $request){
      $socio=Socio::where('dni',$request->dni)->first();
        if($socio){
            echo 'false';
        }else{
            echo 'true';
      } 
    }

    //----> VALIDA EMAIL SOCIO
    public function checkemails(Request $request){
    	$socio=Socio::where('email',$request->email)->first();
        if($socio){
            echo 'false';
        }else{
            echo 'true';
      }
    }

 	//----> BUSCA KEYUP SOCIO - INVITADO
    public function buscaSoccio(Request $request){


        $datasoc =Socio::select('clave')->where('clave','LIKE',$request->inputclav)->first(); 
        if ($datasoc !== null) {
            $daresult = true;
        }else{
            $daresult = false;
         }
        $data =['daresult'=> $daresult ];
        echo  json_encode($data);
    }


     //---> VISTA SOCIO UPDATE
    public function getEditSocio($id){ 
        $soci= Socio::findOrFail($id); 
        $dataperfi = Perfil::get();  
        (count($dataperfi) > 0)? $perfi= Perfil::pluck('tipo' , 'id') : $perfi= null;
        $datacateg = Clase::get();  
        (count($datacateg) > 0)? $class= Clase::pluck('clase' , 'id') : $class= null; 
		$class_1 = Clase::all()->first();
        $dataparent = Parentesco::get();  
        (count($dataparent) > 0)? $parent= Parentesco::pluck('tipo_parentesco' , 'id') : $parent= null; 
		$parent_1 = Parentesco::take(2)->get();
        $data = ['parent'=> $parent,'class'=>$class,'perfi'=>$perfi ,'class_1'=>$class_1,'parent_1'=>$parent_1,'soci'=>$soci]; 
        return view ('Backend/Socio/edit',$data  );      
    }



    //---> ACTUALIZA SOCIO
    public function postEditSocio(Request $request, $id){
    	$bdd =Socio::findOrFail($id);
		$rules   =[
		        'first_name' =>'required|min:2|max:25',
		        'last_name'  =>'required|min:2|max:25',
		        'email'      =>'required|email|unique:socios,email,'.$bdd->id,
		        'dni'        =>'required|min:8|max:8|unique:socios,dni,'.$bdd->id,
		        'selecatego' =>'required',
		        'selecatego' =>'required',
		        'selecparent'=>'required',
		        'placa_socio'=>'max:7',
 	         ];
        $messages =[
	            'first_name.required' =>'Su nombre es requerido.',
            	'first_name.min'      =>'El Nombre debe de tener al menos 2 caracteres.',
            	'first_name.max'      =>'El Nombre debe de tener maximo 25 caracteres.',
	            'last_name.required'  =>'Su apellido es requerido.',
            	'last_name.min'       =>'El Apellido debe de tener al menos 2 caracteres.',
            	'last_name.max'       =>'El Nombre debe de tener maximo 25 caracteres.',	            
            	'email.required'      =>'Su correo electronico es requerido.',
	            'email.email'         =>'El formato de su correo electronico es invalido.',
	            'email.unique'        =>'Ya existe un Socio registrado con ese correo.',
				'dni.required'        =>'Su Dni es requerido.',
	            'dni.unique'          =>'Ya existe un Socio registrado con este DNi.',
	            'selecperfil.required'=>'Su Perfil es necesario !!!'   ,
             	'placa_socio.max'     =>'La placa del socio debe de tener maximo 7 caracteres.',
                 ];      

        $valida=Validator::make($request->all(),$rules,$messages);
        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{


        	if ($request->hasfile('avatar')) {
        		//socios guardado con foto
                $rules =['avatar'    =>'required|mimes:png,jpg,jpeg|max:2048'];
                $messages =[
                 	'avatar.required'=>'Su Imagen es requerido !!!',
            		'avatar.mimes'   =>'Este formato de archivo no es una imagen !!!',
            		'avatar.max'     =>'Peso maximo de imagen 2MB !!!',
                ];
                $valida=Validator::make($request->all(),$rules,$messages);
		        if ($valida->fails()) {
		            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
		        }else{
		        	// socio titular con foto
		        	if ($request->selecperfil == 1) {

			 			$path = '/soc_'.$id;
 		        		$fileExt = trim($request->file('avatar')->getClientOriginalExtension());
                		$upload_path = Config::get('filesystems.disks.uploads_socio.root');
                		$name = Str::slug(str_replace($fileExt,'',$request->file('avatar')->getClientOriginalName()));
                		$filename = rand(1,999).'_'.$name.'.'.$fileExt;
	                	$file_file = $upload_path.'/'.$path.'/'.$filename;

	                	$socy =  Socio::findOrFail($id);
	                	$socy->name         = e($request->input('first_name'));
	            		$socy->lastname     = e($request->input('last_name'));
	            		$socy->email        = e($request->input('email'));
 	                	$socy->dni     	    =$request->dni;
 	                	$socy->perfil_id    =$request->selecperfil;
 	                	$socy->parentesco_id=$request->selecparent;
 	                	$socy->clase_id     =$request->selecatego;
 	                	$socy->created_at   =$bdd->created_at;
                		$socy->updated_at   =$bdd->updated_at;
	                	$aa   = $socy->avatar;          
	                	$socy ->avatar = $filename;
                		$socy->placa        = $request->placa_socio;

						if ($socy->save()) {
		                    if ($request->hasFile('avatar')) {
 	                    		$fl = $request->avatar->storeAs($path,$filename, 'uploads_socio');
		                        $img = Image::make($file_file);

		                        $img->fit(200,200,function($constraint){
		                            $constraint->upsize();
		                        });
		                        $img->save($upload_path.'/'.$path.'/av_'.$filename);
		                    }
		                    if (isset($aa)) {                   
		                        unlink($upload_path.$path.'/'.$aa);
		                        unlink($upload_path.$path.'/av_'.$aa);
		                    }
	                    	return back()->with('success','Socio ACtulizado con éxito.')->with('title','💌 Socio actualizado con exito !!!.');
	                	}else{
				             return redirect()->back()->with('errores','No se pudo  ACtualizar !!!')->withInput();	
	                	}

            			return redirect ('/socios')->with('success','Socio creado con exito!!!')->with('title','💌 Su Socio se creo con exito !!!.');
	            	}
	            	else if ($request->selecperfil == 2){
	            		// socio conyuge con foto
	            		$rules  	=['clavetit' =>'required',];
            			$messages 	=['clavetit.required' =>'Su Clave de Socio es requerido.',];
            			$valida=Validator::make($request->all(),$rules,$messages);
			        	if ($valida->fails()) {
			            	return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
			        	}else{	
				        	//buscamos la clave y comparamos si exiet
				        	$dataclave =Socio::select('clave')->where('clave','LIKE',$request->clavetit)->first();         
				        	if ($dataclave) {

				        		//validamos si hay un conyuge existente
				        		$dataconyuge =Socio::select('name')->where('clave','LIKE',$request->clavetit)->where('perfil_id','LIKE',2)->first();         
				        	 
				        		if ($dataconyuge == null) {
				        			 //no exites conyuge de este socio
				        			$path = '/soc_'.$id;
 					        		$fileExt = trim($request->file('avatar')->getClientOriginalExtension());
			                		$upload_path = Config::get('filesystems.disks.uploads_socio.root');
			                		$name = Str::slug(str_replace($fileExt,'',$request->file('avatar')->getClientOriginalName()));
			                		$filename = rand(1,999).'_'.$name.'.'.$fileExt;
				                	$file_file = $upload_path.'/'.$path.'/'.$filename;

				                	$socy =  Socio::findOrFail($id);
				                	$socy->name         = e($request->input('first_name'));
				            		$socy->lastname     = e($request->input('last_name'));
				            		$socy->email        = e($request->input('email'));
			 	                	$socy->dni     	    =$request->dni;
			 	                	$socy->perfil_id    =$request->selecperfil;
			 	                	$socy->parentesco_id=$request->selecparent;
			 	                	$socy->clase_id     =$request->selecatego;
			 	                	$socy->clave        = $request->clavetit;
			 	                	$socy->created_at   =$bdd->created_at;
                					$socy->updated_at   =$bdd->updated_at;
				                	$aa   = $socy->avatar;          
				                	$socy ->avatar = $filename;
                					$socy->placa        = $request->placa_socio;

									if ($socy->save()) {
					                    if ($request->hasFile('avatar')) {
			 	                    		$fl = $request->avatar->storeAs($path,$filename, 'uploads_socio');
					                        $img = Image::make($file_file);

					                        $img->fit(200,200,function($constraint){
					                            $constraint->upsize();
					                        });
					                        $img->save($upload_path.'/'.$path.'/av_'.$filename);
					                    }
					                    if (isset($aa)) {                   
					                        unlink($upload_path.$path.'/'.$aa);
					                        unlink($upload_path.$path.'/av_'.$aa);
					                    }
				                    	return back()->with('success','Socio ACtulizado con éxito.')->with('title','💌 Socio actualizado con exito !!!.');
				                	}else{
							             return redirect()->back()->with('errores','No se pudo  ACtualizar !!!')->withInput();	
				                	}

				             	}else{

									$path = '/soc_'.$id;
					        		$fileExt = trim($request->file('avatar')->getClientOriginalExtension());
			                		$upload_path = Config::get('filesystems.disks.uploads_socio.root');
			                		$name = Str::slug(str_replace($fileExt,'',$request->file('avatar')->getClientOriginalName()));
			                		$filename = rand(1,999).'_'.$name.'.'.$fileExt;
				                	$file_file = $upload_path.'/'.$path.'/'.$filename;

				                	$socy =  Socio::findOrFail($id);
				                	$socy->name         = e($request->input('first_name'));
				            		$socy->lastname     = e($request->input('last_name'));
				            		$socy->email        = e($request->input('email'));
			 	                	$socy->dni     	    =$request->dni;
			 	                	$socy->perfil_id    =$bdd->perfil_id;
			 	                	$socy->parentesco_id=$request->selecparent;
			 	                	$socy->clase_id     =$request->selecatego;
			 	                	$socy->clave        = $request->clavetit;
			 	                	$socy->created_at   =$bdd->created_at;
                					$socy->updated_at   =$bdd->updated_at;
				                	$aa   = $socy->avatar;          
				                	$socy ->avatar = $filename;
                					$socy->placa        = $request->placa_socio;

									if ($socy->save()) {
					                    if ($request->hasFile('avatar')) {
			 	                    		$fl = $request->avatar->storeAs($path,$filename, 'uploads_socio');
					                        $img = Image::make($file_file);

					                        $img->fit(200,200,function($constraint){
					                            $constraint->upsize();
					                        });
					                        $img->save($upload_path.'/'.$path.'/av_'.$filename);
					                    }
					                    if (isset($aa)) {                   
					                        unlink($upload_path.$path.'/'.$aa);
					                        unlink($upload_path.$path.'/av_'.$aa);
					                    }
				                    	 
				                    	return back()->with('success','Datos ACtulizado, pero el Socio ya tiene un conyuge ⚠️⚠️⚠️')->with('title','💌 datos actualizado!!!.');
				                	}else{
							             return redirect()->back()->with('errores','No se pudo  ACtualizar !!!')->withInput();	
				                	}
 				             		//si existe este conyuge
				             		return redirect()->back()->with('errores','Ya  existe Conyuge para este socio !!!')->withInput();	
				             	}


				        	}else{
				        		return redirect()->back()->with('errores','Esta clave de socio no existe !!!')->withInput();	
				        	}
			        	}

	            	}else if($request->selecperfil == 3){
	            		$rules    =['clavetit' =>'required',];
	            		$messages =['clavetit.required' =>'Su Clave de Socio es requerido.',];
	            		$valida=Validator::make($request->all(),$rules,$messages);
				        if ($valida->fails()) {
				            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
				        }else{
				        	//buscamos la clave y comparamos si existe
				        	$dataclave =Socio::select('clave')->where('clave','LIKE',$request->clavetit)->first();         
				        	if ($dataclave) {
				        		$path = '/soc_'.$id;
				        		$fileExt = trim($request->file('avatar')->getClientOriginalExtension());
		                		$upload_path = Config::get('filesystems.disks.uploads_socio.root');
		                		$name = Str::slug(str_replace($fileExt,'',$request->file('avatar')->getClientOriginalName()));
		                		$filename = rand(1,999).'_'.$name.'.'.$fileExt;
			                	$file_file = $upload_path.'/'.$path.'/'.$filename;

			                	$socy =  Socio::findOrFail($id);
			                	$socy->name         = e($request->input('first_name'));
			            		$socy->lastname     = e($request->input('last_name'));
			            		$socy->email        = e($request->input('email'));
		 	                	$socy->dni     	    =$request->dni;
		 	                	$socy->perfil_id    =$request->selecperfil;
		 	                	$socy->parentesco_id=$request->selecparent;
		 	                	$socy->clase_id     =$request->selecatego;
								$socy->clave        = $dataclave->clave;
								$socy->created_at   =$bdd->created_at;
		                		$socy->updated_at   =$bdd->updated_at;
			                	$aa   = $socy->avatar;          
			                	$socy ->avatar = $filename;
                				$socy->placa        = $request->placa_socio;

						if ($socy->save()) {
		                    if ($request->hasFile('avatar')) {
 	                    		$fl = $request->avatar->storeAs($path,$filename, 'uploads_socio');
		                        $img = Image::make($file_file);

		                        $img->fit(200,200,function($constraint){
		                            $constraint->upsize();
		                        });
		                        $img->save($upload_path.'/'.$path.'/av_'.$filename);
		                    }
		                    if (isset($aa)) {                   
		                        unlink($upload_path.$path.'/'.$aa);
		                        unlink($upload_path.$path.'/av_'.$aa);
		                    }
	                    	return back()->with('success','Socio ACtulizado con éxito.')->with('title','💌 Socio actualizado con exito !!!.');
	                	}else{
				             return redirect()->back()->with('errores','No se pudo  ACtualizar !!!')->withInput();	
	                	}

				        	}else{
				        		return redirect()->back()->with('errores','Esta clave de socio no existe !!!')->withInput();
				        	}

				        }

	            	}//fin de perfiles guardado con foto
	            	 

		        	
                	 
		        }

                
            }else{
            	//socios guardados sin foto

            	if ($request->selecperfil == 1) {
			 	 	$socy =Socio::findOrFail($id); 
			        $socy->name     	= e($request->input('first_name'));
			        $socy->lastname 	= e($request->input('last_name'));
			        $socy->email    	= $request->email;
 			        $socy->perfil_id	= $request->selecperfil;
			        $socy->dni      	= $request->dni;
 			        $socy->parentesco_id= $request->selecparent;
			        $socy->clase_id     = $request->selecatego;
			        $socy->created_at   =$bdd->created_at;
                	$socy->updated_at   =$bdd->updated_at;
                	$socy->placa        =$request->placa_socio;
  
			        if ($socy->save()) {
            		return redirect ('/socios')->with('success','Socio Actualizado con exito!!!')->with('title','💌 Su Socio se ACtualizo con exito !!!.');
			        }
 
            	}else if ($request->selecperfil == 2){
            		$rules    =[ 
            					'clavetit' =>'required',];
            		$messages =[
            				    'clavetit.required' =>'Su Clave de Socio es requerido.',];
            		$valida=Validator::make($request->all(),$rules,$messages);
			        if ($valida->fails()) {
			            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
			        }else{	
			        	//buscamos la clave y comparamos si exiet
			        	$dataclave =Socio::select('clave')->where('clave','LIKE',$request->clavetit)->first();         
			        	if ($dataclave) {

			        		//validamos si hay un conyuge existente
			        		$dataconyuge =Socio::select('name')->where('clave','LIKE',$request->clavetit)->where('perfil_id','LIKE',2)->first();         
			        	 
			        		if ($dataconyuge == null) {
			        			
			        			 //no exites conyuge de este socio			        			 
				        		$socy =Socio::findOrFail($id); 
						        $socy->name     	= e($request->input('first_name'));
						        $socy->lastname 	= e($request->input('last_name'));
						        $socy->email    	= $request->email;
			 			        $socy->perfil_id	= $request->selecperfil;
						        $socy->dni      	= $request->dni;
 						        $socy->parentesco_id= $request->selecparent;
						        $socy->clase_id     = $request->selecatego;
						        $socy->clave        = $request->clavetit;
                				$socy->placa        = $request->placa_socio;
						        if ($socy->save()) {
			            		return redirect ('/socios')->with('success','Conyuge de Socios Actualizado con exito!!!')->with('title','💌 Su Socio se ACtualizo con exito !!!.');
						        }
 

			             	}else{
			             		/*var_dump($bdd->created_at);
			             		die();*/
			             		$socy =Socio::findOrFail($id); 
						        $socy->name     	= e($request->input('first_name'));
						        $socy->lastname 	= e($request->input('last_name'));
						        $socy->email    	= $request->email;
			 			        $socy->perfil_id	= $bdd->perfil_id;
						        $socy->dni      	= $request->dni;
 						        $socy->parentesco_id= $request->selecparent;
						        $socy->clase_id     = $request->selecatego;
						        $socy->clave        = $request->clavetit;
						        $socy->created_at   =$bdd->created_at;
                				$socy->updated_at   =$bdd->updated_at;	
			             		//si existe este conyuge
			             		 if ($socy->save()) {
			             		return back()->with('success','Datos ACtulizado, pero el Socio ya tiene un conyuge ⚠️⚠️⚠️')->with('title','💌 datos actualizado!!!.');	
			             		}
			             	}


			        	}else{
			        		return redirect()->back()->with('errores','Esta clave de socio no existe !!!')->withInput();	
			        	}
			        }	    


            	}else if ($request->selecperfil == 3){

            		$rules    =['clavetit' =>'required',];
            		$messages =['clavetit.required' =>'Su Clave de Socio es requerido.',];
            		$valida=Validator::make($request->all(),$rules,$messages);
			        if ($valida->fails()) {
			            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
			        }else{
			        	//buscamos la clave y comparamos si existe
			        	$dataclave =Socio::select('clave')->where('clave','LIKE',$request->clavetit)->first();          
			        	if ($dataclave) {
			        		 
				            $socy =Socio::findOrFail($id); 
						    $socy->name     	= e($request->input('first_name'));
						    $socy->lastname 	= e($request->input('last_name'));
						    $socy->email    	= $request->email;
			 			    $socy->perfil_id	= $request->selecperfil;
						    $socy->dni      	= $request->dni;
 						    $socy->parentesco_id= $request->selecparent;
						    $socy->clase_id     = $request->selecatego;
						    $socy->clave        = $dataclave->clave;
						    $socy->created_at   =$bdd->created_at;
                			$socy->updated_at   =$bdd->updated_at;
                			$socy->placa        = $request->placa_socio;
						        if ($socy->save()) {
			            		return redirect ('/socios')->with('success','Familiar de Socios ACtualizado con exito!!!')->with('title','💌 Su Socio se actualizo con exito !!!.');
						        } 	
			        	}else{
			        		return redirect()->back()->with('errores','Esta clave de socio no existe !!!')->withInput();
			        	}

			        }
            		 
            	}//finde perfiles guardas sin foto
            	      
            }


			

        }


			// FINDE VALIDA SELCET   	  
    }



	//---> GET DELETE SOCIO
    public function getsociodelete($id){
        $borra =Socio::findOrFail($id);

        if ($borra->delete()) {
            return back()->with('success','Registro borrado con exito')->with('title',' Registro eliminado !!!.');
        }
    }



    //---> GET UPDATE QR SOCIO
    public function getupdateQr($id){
        $user =Socio::findOrFail($id);
        if ($user) {
         	$useremail=array("LAST_INSERT_ID()"=>$user->id,"name"=>$user->name,"macuri"=>$user->clave,'dni'=>$user->dni);

	    	QrCode::format('png')->size(300)->generate($user->clave.$user->dni,'../public/img/imgqrcode/code-soc-'.$user->id.'.png');

	    	Mail::to($user->email)->send(new EmailContact($useremail));

        	return back()->with('success','QR creado con exito')->with('title',' Se creo un Codigo QR !!!.');
        }else{
        	 
        	return back()->with('errores','No se pudo  creado el QR !!!')->withInput();
        }     
    }







}