<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use App\Models\User;


class ConectController extends Controller
{
    public function __construct(){

         $this->middleware('guest')->except(['getlogout']);
    }
    
    //--->INGRESO LOGIN
    public function getlogin(){

    	return view('AuthLogin.login') ;
    } 

    //--->INGRESO LOGIN
    public function getlogin2(){

        return view('AuthLogin.login') ;
    } 

    //--->INGRESO REGISTRO
    public function getRegister(){

    	return view('AuthLogin.register');
    }

     
    //--->GUARDA REGISTRO
    public function postRegister(Request $request){

        $request->validate([
        'selecperfil'     =>'required',
        'first_name'      =>'required|min:2|max:25',
        'last_name'       =>'required|min:2|max:25',
        'email'           =>'required|email|unique:users',
        'password'        =>'required|min:6|max:100',
        'conf_pass'=>'required|same:password',
        'grecaptcha'      =>'required'
        ],[
            'first_name.required'=>'Su nombre es requerido.',
            'last_name.required' =>'Su apellido es requerido.',
            'email.required'     =>'Su correo electronico es requerido.',
            'email.email'        =>'El formato de su correo electronico es invalido.',
            'email.unique'       =>'Ya existe un usuario registrado con ese correo.',
            'password.required'  =>'Por favor escriba su contraseña.',
            'password.min'       =>'La contraseña debe de tener al menos 6 caracteres.',
            'password.max'       =>'La contraseña debe de tener maximo 100 caracteres.',
            'conf_pass.required'=>'Por favor Confirma su contraseña.',
            'conf_pass.same'    =>'La contraseña no coinciden.' ,
            'grecaptcha.required'      =>'El recaptcha es requerido.',
            'selecperfil.required'=>'Su Perfil es necesario !!!'   ,
                 ]);      

        $grecaptcha=$request->grecaptcha;

        $client = new Client();

        //form_params= se utilizar para enviar una solicitud post
        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params'=>
                [
                    'secret'=>env('GOOGLE_CAPTCHA_SECRET'),
                    'response'=>$grecaptcha
                 ]
            ]
        );
            
        $body = json_decode((string)$response->getBody());
        
        if($body->success==true){

            $user=User::create([
                'name'=>$request->first_name,
                'lastname'=>$request->last_name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'perfil'=>$request->selecperfil,
                //'email_verification_code'=>Str::random(40)
            ]);

            //Mail::to($request->email)->send(new EmailVerificationMail($user));

             
            return redirect ('/')->with('success','Hola '.$request->input('name').', te damos la bienvenida    ingresa para empezar!!!')->with('title','💌 Su usuario se creo con exito !!!.');
          
        }else{
            return redirect()->back()->with('error','Invalid recaptcha');
        }  
        /*************************/
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

 
    //--->PROCESA LOGIN
    public function postLogin(Request $request){
        $request->validate([
                'email'=>'required|email',
                'selecperfil' =>'required|numeric',
                'password'=>'required|min:6|max:100',
                'grecaptcha'=>'required'
                ],[
                	'email.required'     =>'Su correo electronico es requerido.',
                    'email.email'        =>'El formato de su correo electronico es invalido.',
                	'selecperfil.required'=>'Su Perfil es necesario !!!'   ,
                    'user.required'     =>'Su Usuario es requerido.',
                    'password.required'  =>'Por favor escriba su contraseña.',
                    'password.min'       =>'La contraseña debe de tener al menos 6 caracteres.',
                    'password.max'       =>'La contraseña debe de tener maximo 100 caracteres.',
                    'grecaptcha.required'=>'El recaptcha es requerido.',
                 ]); 
         $grecaptcha=$request->grecaptcha;


        $client = new Client();

        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params'=>
                [
                    'secret'=>env('GOOGLE_CAPTCHA_SECRET'),
                    'response'=>$grecaptcha
                ]
            ]
        );
      
        $body = json_decode((string)$response->getBody());
 
        if($body->success==true){ 
            $user=User::where('email',$request->email)->first();
            if(!$user){
                return back()->with('error','El correo electrónico no está registrado')->withInput();
            }else{
                  if ($user->perfil !== $request->selecperfil) {
                        return back()->with('error','El Perfil es incorrecto')->withInput();
                    }else
                    if($user->role == 0){
                        return redirect()->back()->with('error','El usuario no está activo. Comuníquese con el administrador')->withInput();
                    }else{

                        $remember_me=($request->remember_me)?true:false;
                        if(auth()->attempt($request->only('email','password'),$remember_me)){
                             return redirect('/home');
                        }else{
                            return redirect()->back()->with('error','Contraseña no valida')->withInput();
                        }

                    }
            }
          
         }else{
             return redirect()->back()->with('error','Recaptcha invalida');
         }     
    }


    //--->SALIR 
    public function getlogout(){
        auth()->logout();
        return redirect('/')->with('success','Sesión cerrada correctamente');        
    }

}
