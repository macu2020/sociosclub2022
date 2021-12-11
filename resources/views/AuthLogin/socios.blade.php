@extends('Template.master')
@section('contenido')
<style>
  	body{		background:url({{ asset('img/login/fondo.jpg') }});	   	}
</style>
 
<div class="container mt-4">
	<div class="row">
		
		<div class="col-md-8 ">
		<h2>Titular y conyuge</h2>
		<div class="container p-4" style="border:1px solid #000;text-align: center;">
			<img src="{{ asset('img/login/hombre.jpg') }}" alt="" width="300" height="200">
			<img src="{{ asset('img/login/mujer.jpg') }}" alt="" width="300" height="200">
		</div>
		<h2>familiares</h2>
		<div class="container p-4" style="border:1px solid #000;text-align: center;">
			<img src="{{ asset('img/login/per1.jpg') }}" alt="" width="150" height="200">
			<img src="{{ asset('img/login/per2.jpg') }}" alt="" width="150" height="200">
			<img src="{{ asset('img/login/per3.jpg') }}" alt="" width="150" height="200">
		</div>
		</div>
		<div class="col-md-4">
 <div class="form-login col-md-12 col-lg-12  ">
      		{!! Form::open(['url'=>'/login','method'=>'POST','class'=>'auth-form','id'=>'login_form'])!!}	
     	  	@csrf
          	 
          	<div class="row d-flex flex-column justify-content-center align-items-center text-center">
          		<div class="col-md-8">
			  		<div class="form-group mt-4">
						<select name="selecperfil" id="capacid" class="custom-select text-center">
			  				<option value="">-- Perfil --</option>
			  				<option value="1000">Recepcionista</option>
			  				<option value="750" >Administrador.</option>
			  				<option value="700">Insprector</option>
 			  			</select>
						@if($errors->any('selecperfil'))
						<span class="text-danger">{{$errors->first('selecperfil')}}</span>
						@endif
			  		</div>     	  		
     	  		</div>
	      	  	<div class="col-md-12">
				  <div class="form-group row">
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
				  	<div class="form-group row">
				    	<label for="password" class="col-sm-4 col-md-12 col-lg-4 col-form-label subtit">Contraseña</label>
				    	<div class="col-sm-8 col-md-12 col-lg-8">
				    	{!!Form::password('password',['class'=>'form-control text-center','id'=>'password'])!!}
				        </div>
			            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
						@if($errors->any('password'))
							<span class="text-danger">{{$errors->first('password')}}</span>
						@endif
				  </div>     	  		
	     	  	</div>         	
          	</div>


 

     	  	<div class="row d-flex flex-column justify-content-center align-items-center text-center">
     	  		<div class="col-md-12 ">
			   <div class="form-check">
			    <input type="checkbox" {{(old('remember_me'))?'checked':''}} value="true" name="remember_me" id="remember_me" class="form-check-input" >
			    <label class="form-check-label" for="remember_me">Recordar sesión</label>
			  </div>  		
     	  		</div>
     	  	</div>

     	  	<div class="row d-flex flex-column justify-content-center align-items-center text-center">
     	  		<div class="col-md-12">
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
				<span style="color: #fff">&nbsp; No tienes una cuenta <a href="{{ url('registr') }}" style="color: red">Registrate aquí</a> </span>  	  		 
     	  		</div>
     	  	</div>

 			{!!Form::close()!!}
 		</div>
		</div>
	</div>
</div>
 

@endsection