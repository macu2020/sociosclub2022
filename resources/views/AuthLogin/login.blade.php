@extends('Template.master')
@section('contenido')
<style>
  	body{		background:url({{ asset('img/login/fondo.jpg') }});background-position: center ;
        background-size: cover; background-repeat: no-repeat;background-attachment: fixed;	   	}
</style>
 

<div class="row p-4">
 	<div class="col-md-6 d-flex flex-column justify-content-center align-items-end ">
 	  	<div class="form-login col-md-12 col-lg-8  ">
      		{!! Form::open(['url'=>'login','method'=>'POST','class'=>'auth-form','id'=>'login_form'])!!}	
     	  	@csrf

			<!--- FORMLARIO---->
          	<div class="row d-flex flex-column justify-content-center align-items-center text-center">
          		<div class="col-md-8">
			  		<div class="form-group mt-4">
						<select name="selecperfil" id="selecperfil" class="custom-select text-center">
			  				<option value="">-- Perfil --</option>
			  				<option value="3">Recepcionista</option>
			  				<option value="1">Administrador</option>
			  				<option value="2">Inspector</option>
 			  			</select>
						@if($errors->any('selecperfil'))
						<span class="text-danger">{{$errors->first('selecperfil')}}</span>
						@endif
			  		</div>     	  		
     	  		</div>
	      	  	<div class="col-md-12">
				  <div class="form-group row" >
				    <label for="user" class="col-sm-4 col-md-12 col-lg-4 col-form-label subtit" >Usuario</label>
				    <div class="col-sm-8 col-md-12 col-lg-8">
 				      	{!!Form::email('email',old('email'),['class'=>'form-control' ,'placeholder'=>'Email','id'=>'email'])!!}		
 				      		@if($errors->any('email'))
							<span class="text-danger">{{$errors->first('email')}}</span>
							@endif								
				    </div>
				  </div>     	  		
	     	  	</div> 
	     	  	<div class="col-md-12">
				  	<div class="form-group row form-logins">
				    	<label for="password" class="col-sm-4 col-md-12 col-lg-4 col-form-label subtit">Contraseña</label>
				    	<div class="col-sm-8 col-md-12 col-lg-8">
				    	{!!Form::password('password',['class'=>'form-control text-center','id'=>'password'])!!}
				    	<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" ></span>
				        </div>
			            
						@if($errors->any('password'))
							<span class="text-danger">{{$errors->first('password')}}</span>
						@endif
				  </div>     	  		
	     	  	</div>         	
          	</div>


 
          	<!--- RECUERDA SESION---->
     	  	<div class="row d-flex flex-column justify-content-center align-items-center text-center">
     	  		<div class="col-md-12 ">
			   <div class="form-check">
			    <input type="checkbox" {{(old('remember_me'))?'checked':''}} value="true" name="remember_me" id="remember_me" class="form-check-input" >
			    <label class="form-check-label" for="remember_me">Recordar sesión</label>
			  </div>  		
     	  		</div>
     	  	</div>

     	  	<!--- CAPTCHA---->
     	  	<div class="row ">
     	  		<div class="col-md-12 d-flex flex-column justify-content-center align-items-center text-center">
					<div class="g-recaptcha" data-sitekey="{{env('GOOGLE_CAPTCHA_KEY')}}"  data-callback="recaptchaDataCallbackLogin"  data-expired-callback="recaptchaExpireCallbackLogin"></div>   
		   			<input type="hidden"  name="grecaptcha" id="hiddenRecaptchaLogin" >
           			<div id="hiddenRecaptchaLoginError"></div>
				    @if($errors->any('grecaptcha'))
						<span class="text-danger">{{$errors->first('grecaptcha')}}</span>
					@endif
     	  		</div>	   	     	  	
     	  	</div> 

     	  	<div class="row ">
     	  		<div class="col-md-12 text-center" >
     	  		<input type="submit" class="form-control btn btn-primary submit px-3 mt-2" value="Ingresar" style="width: 28%;"></input>
      	  		</div>
     	  	</div>
			    

      	  	<div class="row">
     	  		<div class="col-md-12 text-center">
				<span style="color: #fff">&nbsp; No tienes una cuenta <a href="{{ url('registr') }}" class="text-danger">Registrate aquí</a> </span>  	  		 
     	  		</div>
     	  	</div>

 
 			{!!Form::close()!!}
 		</div>
    </div>

	<div class=" col-md-6 d-flex flex-column justify-content-center align-items-center  " >
		<div class="img-login col-md-12 col-lg-8  d-flex flex-column justify-content-center align-items-center">
			<img src="{{ asset('img/login/macuri21.jpg') }}" alt="" class="img-fluid mt-4"  >
		</div>
	</div>
</div>



	<!--- Validaciones ----->
	@if(Session::has('success'))
	  <script>
		Swal.fire({
		title: " <strong style='color:#21B0B4;text-shadow: 1px 1px 1px #460b09;font-weight: bold;font-family: Raleway;'>{{Session::get('success')}}</strong>  ",
		imageUrl: "{{asset('img/login/logos.jpeg')}}",
		imageWidth: 190,
		imageHeight: 125,
		background: '#fff ',
		imageAlt: "Country club",
		});
	  </script>			
	@elseif(Session::has('errors'))
	<div class="mensa">
	 	<div class="container">
			<div class="alert" style="display:none;" >			 
			@if($errors->any())
				<ul class="ulerror">
					@foreach($errors->all() as $error)
					<li> <i class="fas fa-exclamation-triangle text-danger"  ></i> {{$error}}</li>
					@endforeach
				</ul> 
			@else
				<ul>
					<li class="ulerror" style="font-weight: bold !important">{{ session()->get("errores") }}</li>
				</ul>					 
			@endif
		    </div>
		</div>
		 
	</div>
	@endif 

	@if(Session::has('error'))
	<div class="mensa">
	 	<div class="container">
			<div class="alert" style="display:none;" >			 
			@if($errors->any())
				<ul class="ulerror">
					@foreach($error->all() as $error)
					<li> <i class="fas fa-exclamation-triangle text-danger"  ></i> {{$error}}</li>
					@endforeach
				</ul> 
			@else
				<ul>
					<li class="ulerror" style="font-weight: bold !important">{{ session()->get("error") }}</li>
				</ul>					 
			@endif
		    </div>
		</div>
		 
	</div>
	@endif 

@endsection