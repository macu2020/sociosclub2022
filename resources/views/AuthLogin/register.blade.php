@extends('Template.master')
@section('contenido')
<style>
	  	body{		background:url({{ asset('img/login/fondo.jpg') }});	   	}

</style>
 


 <div class="row mb-3 m-2">
      {!! Form::open(['url'=>'/registr','method'=>'POST','class'=>'col-md-6 col-xs-12 offset-md-3  regis-form','id'=>'regitration_form'])!!}	
     	  
          <div>
              <h2 class="text-center home-text">Registrarce</h2> 
          </div>
     	  <div class="row">
     	   	<div class="col-12  col-sm-12 col-md-6">
	     	  <div class="form-group">
			    <label for="first_name" class="subtit">Nombre</label>
			    {!!Form::text('first_name',old('first_name'),['class'=>'form-control' ,'placeholder'=>'Nombre','id'=>	'first_name'])!!}
				@if($errors->any('first_name'))
					<span class="text-danger">{{$errors->first('first_name')}} </span>
				@endif
			  </div>
     	   	</div>  
     	   	<div class="col-12   col-sm-12 col-md-6">
	     	  <div class="form-group">
			    <label for="last_name" class="subtit">Apellido</label>				
				{!!Form::text('last_name',old('last_name'),['class'=>'form-control' ,'placeholder'=>'Apellido','id'=>'last_name'])!!}
			    @if($errors->any('last_name'))
					<span class="text-danger">{{$errors->first('last_name')}}</span>
				@endif
			  </div>
     	   	</div>
     	   </div>

     	  <div class="row">
     	  	<div class="col-md-6">
			  <div class="form-group passregi">
			    <label for="password" class="subtit">Contraseña</label>
			    {!!Form::password('password',['class'=>'form-control'  ,'placeholder'=>'Password','id'=>'password'])!!}
		         <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>

				@if($errors->any('password'))
					<span class="text-danger">{{$errors->first('password')}}</span>
				@endif
			  </div>     	  		
     	  	</div>
     	  	<div class="col-md-6">
			  <div class="form-group passregi">
			    <label for="conf_pass" class="subtit">Confirmar </label>
			    {!!Form::password('conf_pass',['class'=>'form-control' ,'id'=>'conf_pass','placeholder'=>'Confirm Password'])!!}
		        <span toggle="#conf_pass" class="fa fa-fw fa-eye field-icon toggle-password"></span>
				@if($errors->any('conf_pass'))
					<span class="text-danger">{{$errors->first('conf_pass')}}</span>
				@endif
			  </div>     	  		
     	  	</div>
     	  </div>

     	  <div class="row">
     	  	<div class="col-md-6">
			  <div class="form-group ">
			    <label for="email" class="subtit">Email address</label>
				{!!Form::email('email',old('email'),['class'=>'form-control' ,'placeholder'=>'Email','id'=>'email'])!!}		    
			    <small id="emailHelp" class="form-text text-muted">Nunca compartiremos su correo electrónico con nadie más.</small>
				@if($errors->any('email'))
					<span class="text-danger">{{$errors->first('email')}}</span>
				@endif
			  </div>     	  		
     	  	</div>
     	  	<div class="col-md-6 col-sm-12 ">
    		     <div class="form-group  ">
			    <label for="selecperfil" class="subtit">Perfil </label>
						<select name="selecperfil" id="selecperfil" class="custom-select text-center">
			  				<option value="">-- Perfil --</option>
			  				<option value="3">Recepcionista</option>
			  				<option value="1">Administrador.</option>
			  				<option value="2">Inspector</option>
 			  			</select>
						@if($errors->any('selecperfil'))
						<span class="text-danger">{{$errors->first('selecperfil')}}</span>
						@endif
			  		</div>	  		
     	  	</div>
     	  </div>

     	  <div class="row">
     	  	<div class="col-md-12">
					<div class="g-recaptcha" data-sitekey="{{env('GOOGLE_CAPTCHA_KEY')}}"  data-callback="recaptchaDataCallbackRegister"  data-expired-callback="recaptchaExpireCallbackRegister"></div>
		   			<input type="hidden"  name="grecaptcha" id="hiddenRecaptchaRegister" >
				   	<div id="hiddenRecaptchaRegisterError"></div>
				    @if($errors->any('grecaptcha'))
						<span class="text-danger">{{$errors->first('grecaptcha')}}</span>
					@endif
     	  	</div>	   	     	  	
     	  </div> 

     	  <div class="row">
     	  	<div class="col-md-12">
     	  		<input type="submit" class="form-control btn btn-primary submit px-3 mt-2" value="Guardar" style="width: 28%;"></input>
				<span style="color: #fff">&nbsp; Ya tienes una cuenta <a href="{{ url('/') }}" class="text-danger">iniciar sesión aqui </a></span>  	  		 
     	  	</div>
     	  </div>

  


 		  {!!Form::close()!!}


</div>


@if(Session::has('errors'))
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
		<script>
		Swal.fire({
		title: 'Se aproducido un error :',
		icon: 'error',
		imageWidth: 190,
		html:  $('.alert').html()  ,
		imageHeight: 125,
		background: '#fff ',
		imageAlt: "Country club",
		});
		</script>
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
		<script>
		Swal.fire({
		title: 'Se aproducido un error :',
		icon: 'error',
		imageWidth: 190,
		html:  $('.alert').html()  ,
		imageHeight: 125,
		background: '#fff ',
		imageAlt: "WebmacEmprendedor",
		});
		</script>
	</div>
	@endif 


@endsection