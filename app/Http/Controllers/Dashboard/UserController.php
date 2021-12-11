<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  
 use App\Models\User;
 use App\Models\Roles; 

use Validator,Config,Image,Str;

class UserController extends Controller
{
     
     //---> CONSTRUCTOR
    public function __construct(){
         $this->middleware('auth');
         $this->middleware('isadmin');
    }

    //---> VISTA USUARIOS
    public function getHomeUser(){ 
        $user = User::all();
        $data =['user'=>$user];
        return view ('Backend/User/home',$data);       
    }

    //---> USER CREATE
    public function getAddUser(){ 
         
        return view ('Backend/User/add' );       
    } 


 	//---> GUARDA USER
    public function postAddUser(Request $request){
        $rules =[
	        'selecperfil'=>'required',
	        'first_name' =>'required|min:2|max:25',
	        'last_name'  =>'required|min:2|max:25',
	        'email'      =>'required|email|unique:users',
	        'password'   =>'required|min:6|max:10',
	        'conf_pass'  =>'required|same:password',
	        ];
        $messages =[
            'first_name.required' =>'Su nombre es requerido.',
            'last_name.required'  =>'Su apellido es requerido.',
            'email.required'      =>'Su correo electronico es requerido.',
            'email.email'         =>'El formato de su correo electronico es invalido.',
            'email.unique'        =>'Ya existe un usuario registrado con ese correo.',
            'password.required'   =>'Por favor escriba su contraseña.',
            'password.min'        =>'La contraseña debe de tener al menos 6 caracteres.',
            'password.max'        =>'La contraseña debe de tener maximo 10 caracteres.',
            'conf_pass.required'  =>'Por favor Confirma su contraseña.',
            'conf_pass.same'      =>'La contraseña no coinciden.' ,
            'selecperfil.required'=>'Su Perfil es necesario !!!'   ,
                 ];      

        $valida=Validator::make($request->all(),$rules,$messages);
        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{

        	if ($request->hasfile('avatar')) {
                $rules =[
                 	'avatar'    =>'required|mimes:png,jpg,jpeg|max:2048',//max. 2megabyt
                 ];
                 $messages =[
                 	'avatar.required'=>'Su Imagen es requerido !!!',
            		'avatar.mimes'   =>'Este formato de archivo no es una imagen !!!',
            		'avatar.max'     =>'Peso maximo de imagen 2MB !!!',
                 ];
                 $valida=Validator::make($request->all(),$rules,$messages);
		        if ($valida->fails()) {
		            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
		        }else{
		        	$fileExt = trim($request->file('avatar')->getClientOriginalExtension());
                	$upload_path = Config::get('filesystems.disks.uploads_user.root');
                	$name = Str::slug(str_replace($fileExt,'',$request->file('avatar')->getClientOriginalName()));
                	$filename = rand(1,999).'_'.$name.'.'.$fileExt;
                	$user=User::create([
                        'name'     =>e($request->input('first_name')),
                        'lastname' =>e($request->input('last_name')),                           
                        'email'    =>e($request->input('email')),                           
                		'password' =>bcrypt($request->password),
                		'perfil'   =>$request->selecperfil,
                        'avatar'   =>$filename ,
                        'role'   =>'1' 
                        ]);
                	if ($user->save()) {
	                 	$path = '/usu_'.$user->id;
	                 	$file_file = $upload_path.'/'.$path.'/'.$filename;
	                    $fl = $request->avatar->storeAs($path,$filename, 'uploads_user');
	                    $img = Image::make($file_file);
	                    $img->fit(200,200,function($constraint){
	                        $constraint->upsize();
	                    });
	                    $img->save($upload_path.'/'.$path.'/av_'.$filename);
	                    	                     
            		return redirect ('/usuarios')->with('success','Usuario creado con exito!!!')->with('title','💌 Su usuario se creo con exito !!!.');
                	}
		        }

                
            }else{
            	$user=User::create([
                'name'=>$request->first_name,
                'lastname'=>$request->last_name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'perfil'=>$request->selecperfil,
                'role'   =>'1' 
            	]);
            	return redirect ('/usuarios')->with('success','Usuario creado con exito!!!')->with('title','💌 Su usuario se creo con exito !!!.');

             
            }


			

        }
    } 


	//--->VALIDA EMAIL (jquery validate)
    public function checkemail(Request $request){
        $user=User::where('email',$request->email)->first();
        if($user){
            echo 'false';
        }else{
            echo 'true';
        }       
    }

    //---> USER UPDATE
    public function getEditUser($id){ 
        $usu= User::findOrFail($id); 
        $dataperfil = Roles::get();  
        (count($dataperfil) > 0)? $marc= Roles::pluck('tipo' , 'id'): $marc= null; 
        $data = [ 'usu'=>$usu,'marc'=>$marc ];
        return view ('Backend/User/edit' ,$data);       
    }

    //--->UPDATE USER POST
    public function postEditUser(Request $request, $id){
    	$bdd =User::findOrFail($id);
        $rules =[
        'selecperfil'=>'required',
        'first_name' =>'required|min:2|max:25',
        'last_name'  =>'required|min:2|max:25',
        'email'      =>'required|email|unique:users,email,'.$bdd->id,
         ];
        $messages =[
            'first_name.required' =>'Su nombre es requerido.',
            'last_name.required'  =>'Su apellido es requerido.',
            'email.required'      =>'Su correo electronico es requerido.',
            'email.email'         =>'El formato de su correo electronico es invalido.',
            'email.unique'        =>'Ya existe un usuario registrado con ese correo.',
            'selecperfil.required'=>'Su Perfil es necesario !!!'   ,
                 ];      

        $valida=Validator::make($request->all(),$rules,$messages);
        if ($valida->fails()) {
            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
        }else{

        	if ($request->hasfile('avatar')) {

                $rules =[
                 	'avatar'    =>'required|mimes:png,jpg,jpeg|max:2048',//max. 2megabyt
                 ];
                 $messages =[
                 	'avatar.required'=>'Su Imagen es requerido !!!',
            		'avatar.mimes'   =>'Este formato de archivo no es una imagen !!!',
            		'avatar.max'     =>'Peso maximo de imagen 2MB !!!',
                ];
                 $valida=Validator::make($request->all(),$rules,$messages);
		        if ($valida->fails()) {
		            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
		        }else{
		        	 

				 
				 if ($request->password !== null) {
            		$rules =[
					 'password'   =>'min:6|max:10',
        			 'conf_pass'  =>'same:password',
            		];
            		$messages =[
						'password.min'  =>'La contraseña debe de tener al menos 6 caracteres.',
            			'password.max'  =>'La contraseña debe de tener maximo 10 caracteres.',
            			'conf_pass.same'=>'La contraseña no coinciden.' ,            		 ];
            		$valida=Validator::make($request->all(),$rules,$messages);
			        if ($valida->fails()) {
			            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
			        }else{

						$path = '/usu_'.$id;
	                	$fileExt = trim($request->file('avatar')->getClientOriginalExtension());
	                	$upload_path = Config::get('filesystems.disks.uploads_user.root');
	                	$name = Str::slug(str_replace($fileExt, '',$request->file('avatar')->getClientOriginalName()));
	                	$filename = rand(1,999).'_'.$name.'.'.$fileExt;
	                	$file_file = $upload_path.'/'.$path.'/'.$filename;

	                	$user =  User::findOrFail($id);
	                	$user->name     = e($request->input('first_name'));
	            		$user->lastname = e($request->input('last_name'));
	            		$user->email = e($request->input('email'));
	            		$user->password = bcrypt($request->input('password'));
	                	$user->perfil   =$request->selecperfil;
	                	$user->role   ='1';   
	                	$aa= $user->avatar;          
	                	$user ->avatar = $filename;

	                	if ($user->save()) {
		                    if ($request->hasFile('avatar')) {
		                        $fl = $request->avatar->storeAs($path,$filename, 'uploads_user');
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
	                    	return back()->with('success','AVatar ACtulizado con éxito.')->with('title','💌 AVatar actualizado con exito !!!.');
	                	}
			        }
			     }else{
					$path = '/usu_'.$id;
                	$fileExt = trim($request->file('avatar')->getClientOriginalExtension());
                	$upload_path = Config::get('filesystems.disks.uploads_user.root');
                	$name = Str::slug(str_replace($fileExt, '',$request->file('avatar')->getClientOriginalName()));
                	$filename = rand(1,999).'_'.$name.'.'.$fileExt;
                	$file_file = $upload_path.'/'.$path.'/'.$filename;

                	$user =  User::findOrFail($id);
                	$user->name     = e($request->input('first_name'));
            		$user->lastname = e($request->input('last_name'));
            		$user->email = e($request->input('email'));
                 	$user->perfil   =$request->selecperfil;
                	$user->role   ='1';   
                	$aa= $user->avatar;          
                	$user ->avatar = $filename;

                	if ($user->save()) {
	                    if ($request->hasFile('avatar')) {
	                        $fl = $request->avatar->storeAs($path,$filename, 'uploads_user');
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
                    	return back()->with('success','AVatar ACtulizado con éxito.')->with('title','💌 AVatar actualizado con exito !!!.');
	                }
            	 }
	 
                	$user =User::findOrFail($id); 
            		$user->name     = e($request->input('first_name'));
            		$user->lastname = e($request->input('last_name'));
            		$user->email = e($request->input('email'));
            		$user->password = bcrypt($request->input('password'));
                	$user->perfil   =$request->selecperfil;
                	$user->role   ='1';

            		if ($user->save()) {

                    	return back()->with('success','Información actualizada')->with('title','💌 Usuario actualizado con exito !!!.');
                	}
                 

		        }
            }else{
            	 
            	if ($request->password !== null) {
            		$rules =[
					 'password'   =>'min:6|max:10',
        			 'conf_pass'  =>'same:password',
            		];
            		$messages =[
					'password.min'  =>'La contraseña debe de tener al menos 6 caracteres.',
            		'password.max'  =>'La contraseña debe de tener maximo 10 caracteres.',
            		'conf_pass.same'=>'La contraseña no coinciden.' ,            		 ];

            		$valida=Validator::make($request->all(),$rules,$messages);
			        if ($valida->fails()) {
			            return back()->withErrors($valida)->with('errores','Se ha producido un error :')->withInput();
			        }else{
							$user =User::findOrFail($id); 
			            	$user->name     = e($request->input('first_name'));
			            	$user->lastname = e($request->input('last_name'));
			                $user->email    = $request->email;
			                $user->password = bcrypt($request->password);
			                $user->perfil   = $request->selecperfil;
			                $user->role     = '1';
			                if ($user->save()) {
			            	return back()->with('success','Usuario ACtulaizado con exito!!!')->with('title','💌 Su usuario se creo con exito !!!.');
			            	}
			        }

            	}else{
            		$user =User::findOrFail($id); 
			        $user->name     = e($request->input('first_name'));
			        $user->lastname = e($request->input('last_name'));
			        $user->email    = $request->email;
 			        $user->perfil   = $request->selecperfil;
			        $user->role     = '1';
			                if ($user->save()) {
			            	return back()->with('success','Usuario ACtulaizado con exito!!!')->with('title','💌 Su usuario se creo con exito !!!.');
			            	}
            	}  
            }


			

        }
    }


 
	//---> GET DELETE USER
    public function getuserdelete($id){
        $borra =User::findOrFail($id);

        if ($borra->delete()) {
            return back()->with('success','Registro borrado con exito')->with('title',' Registro eliminado !!!.');
        }
    }

}
