@extends('Template.home')
@section('content')

<div class="page" >
	<div class="container-fluid">
	  <nav arial-label="breadcrumb shadow" >
		<div class="container-fluid" style="margin-top: 110px;margin-bottom: 40px">
   		  <div class="row">
   		  	@if (Auth::user()->perfil == 1)	  <!---- ROL => administrador --->

			<div class="col-md-9"><!------ Table Category ---->
		   	 	<div class="panel shadow" style="border-top: 1px solid hsla(0, 0%, 71%, .3)">
				  	<div class="header">
				  		<h2 class="title"><i class="fas fa-user-plus"></i> Actualizar Socio</h2>
				  	</div>	
 			    		
					{!! Form::open(['url'=>'/edit/'.$soci->id.'/socio','method'=>'POST','class'=>'col-md-9 col-xs-12 regis-form','id'=>'edit_soci','files'=>true,])!!}	
      	  			<div class="row"> <!------- Name -Lastname --------->
			     	   	<div class="col-12  col-sm-12 col-md-6"  >
				     	  <div class="form-group">
						    <label for="first_name" class="subtit">Nombre</label>
						    {!!Form::text('first_name',$soci->name,['class'=>'form-control' ,'placeholder'=>'Nombre','id'=>	'first_name'])!!}
							@if($errors->any('first_name'))
								<span class="text-danger">{{$errors->first('first_name')}} </span>
							@endif
						  </div>
			     	   	</div>  
			     	   	<div class="col-12   col-sm-12 col-md-6">
				     	  <div class="form-group">
						    <label for="last_name" class="subtit">Apellido</label>				
							{!!Form::text('last_name',$soci->lastname,['class'=>'form-control' ,'placeholder'=>'Apellido','id'=>'last_name'])!!}
						    @if($errors->any('last_name'))
								<span class="text-danger">{{$errors->first('last_name')}}</span>
							@endif
						  </div>
			     	   	</div>
     	   			</div>

     	   			<div class="row"> <!--------- DNI - Perfil --------->
			     	   	<div class="col-12  col-sm-12 col-md-6"  >
				     	  <div class="form-group">
						    <label for="dni" class="subtit">Dni</label>
						    {!!Form::number('dni',$soci->dni,['class'=>'form-control' ,'id'=>'dni'])!!}
							@if($errors->any('dni'))
								<span class="text-danger">{{$errors->first('dni')}} </span>
							@endif
						  </div>
			     	   	</div>  
			     	   	<div class="col-12   col-sm-12 col-md-6">
				     	  <div class="form-group  text-center">
						    	<label for="selecperfil" class="subtit ">PERFIL SOCIO </label>
								@if ($perfi != null)
			  					{!!Form::select('selecperfil', $perfi,$soci->perfil_id,['class'=>'custom-select text-center','id'=>"selecperfil"])!!}
			  					@else
									<h4 class="inva-categor">Sin Perfil de Socio</h4>
			  					@endif	
			  					@if($errors->any('selecperfil'))
									<span class="text-danger">{{$errors->first('selecperfil')}} </span>
								@endif

						  </div>
			     	   	</div>
     	   			</div>

     	   			<div class="row" id="rowtit"><!-- CLAVE - SOCIO ---->
     	   				<div class="col-12  col-sm-12 col-md-12"  >
                			<div class="form-group text-center">
                				<label for="clavetit" class="subtit">Clave de Titular</label>
                				<p id="perorso" style="color: red;position: absolute;font-weight: 300;top: 13px">Campo Requerido</p>
                				 
						    {!!Form::text('clavetit',$soci->clave,['class'=>'form-control text-center inputcla' ,'id'=>	'clavetit'])!!}


              				</div>
                		</div> 
     	   			</div>

     	   			<div class="row" id="notitu"> <!-- No es titular --->
			     	   	<div class="col-12  col-sm-12 col-md-6"  >
				     	  <div class="form-group">
						    <label for="selecatego" class="subtit">Categoria</label>
						    	@if ($class != null)
			  					{!!Form::select('selecatego', $class,$soci->clase_id,['class'=>'custom-select text-center' ])!!}
			  					@else
									<h4 class="inva-categor">Sin Categoria</h4>
			  					@endif
			  					@if($errors->any('selecatego'))
									<span class="text-danger">{{$errors->first('selecatego')}} </span>
								@endif
						  </div>
			     	   	</div> 
			     	   	<div class="col-12   col-sm-12 col-md-6">
				     	  <div class="form-group">
						    <label for="selecparent" class="subtit">Parentesco</label>				
								@if ($parent != null)
			  					 
			  					{!!Form::select('selecparent', $parent,$soci->parentesco_id,['class'=>'custom-select text-center' ])!!}
			  					@else
									<h4 class="inva-categor">Sin Datos de parentesco</h4>
			  					@endif
			  					@if($errors->any('selecparent'))
									<span class="text-danger">{{$errors->first('selecparent')}} </span>
								@endif
						  </div>
			     	   	</div>
     	   			</div>

     	   			<div class="row" id="sititu"> <!-- Socios titula --->
			     	   	<div class="col-12  col-sm-12 col-md-6"  >
				     	  <div class="form-group">
						    <label for="selecatego" class="subtit">Categoria</label>
						    	@if ($class_1 != null)
			  					<select name="selecatego"  class="custom-select " >
  			  						<option value="{{ $class_1->id }}"  >{{ $class_1->clase }}</option>
 			  					</select>
 			  					@else
									<h4 class="inva-categor">Sin Categoria</h4>
			  					@endif
			  					@if($errors->any('selecatego'))
									<span class="text-danger">{{$errors->first('selecatego')}} </span>
								@endif
						  </div>
			     	   	</div> 
			     	   	<div class="col-12   col-sm-12 col-md-6">
				     	  <div class="form-group">
						    <label for="selecparent" class="subtit">Parentesco</label>				
								@if ($parent_1 != null)
			  					<select name="selecparent"  class="custom-select " >
   			  						@foreach ($parent_1 as $element)
			  						<option value="{{ $element->id }}"  >{{ $element->tipo_parentesco }}</option>
			  						@endforeach
 			  					</select>
			  					@else
									<h4 class="inva-categor">Sin Datos de parentesco</h4>
			  					@endif
			  					@if($errors->any('selecparent'))
									<span class="text-danger">{{$errors->first('selecparent')}} </span>
								@endif
						  </div>
			     	   	</div>
     	   			</div>
		     	   

		     	  	<div class="row"><!-- Socios email --->
			     	  	<div class="col-md-6">
						  <div class="form-group ">
						    <label for="email" class="subtit">Email address</label>
							{!!Form::email('email',$soci->email,['class'=>'form-control' ,'placeholder'=>'Email','id'=>'email'])!!}		    
							@if($errors->any('email'))
								<span class="text-danger">{{$errors->first('email')}}</span>
							@endif
						  </div>     	  		
			     	  	</div>
			     	  	<div class="col-md-6">
						  <div class="form-group">
						    <label for="placa_socio" class="subtit">Placa Auto</label>
							{!!Form::text('placa_socio',$soci->placa,['class'=>'form-control' ,'placeholder'=>'Placa','id'=>'placa_socio'])!!}
						    @if($errors->any('placa_socio'))
								<span class="text-danger">{{$errors->first('placa_socio')}}</span>
							@endif
						  </div>    	  		
			     	  	</div>
		     	  	</div>

		     	  	<div class="row"> <!-- Input file imagen BTN SUBMIT -->
			     	  	<div class="col-md-6  "> 
							<label for="name">Foto de Socio:</label>
								<div class="custom-file">
									{!!Form::file('avatar',['class'=>'custom-file-input','id'=>'customFile','accept'=>'image/*'])!!}
									<label class="custom-file-label lbl-imgbus" for="customFile">Buscar foto</label>
								</div>
								@if($errors->any('avatar'))
									<span class="text-danger eror" >{{$errors->first('avatar')}} </span>
								@endif
						</div>
						<div class="col-md-6 mt-4">

			     	  		<input type="submit" class="form-control btn btn-success btn-home px-3 mt-2" value="ACtualizar"></input>
			     	  	</div>		
		     	  	</div>

 		  			{!!Form::close()!!}

 			 	</div>		
			</div> 

			<div class="col-md-3" ><!------ Form Category ----->
		   	 	<div class="panel shadow" style="border-top: 1px solid hsla(0, 0%, 71%, .3)">
			  		<div class="header">
			  			<h2 class="title">
						<a href="{{ url('socios') }} " class="btn btn-success btn-home"   ><i class="fas fa-users"></i>   TABLA SOCIOS</a>
			  			</h2>  			
			  		</div>	
			  		<div class="inside" >
			  			<div class="panel shadow panel-add d-flex flex-column justify-content-start align-items-center pt-4"  >

			  				@if(is_null($soci->avatar))
			  					<img src="{{ asset('img/iconos/user-avatar.png') }}" alt=""  id="img-maci" class="img-fluid rounded-circle" width="200" height ="200" style="width: 200px !important;height: 200px !important">
			  				@else 
			  					<img src="{{url('uploads_socios/soc_'.$soci->id.'/av_'.$soci->avatar)}}"alt=""  id="img-maci" class="img-fluid rounded-circle" width="200" height ="200" style="width: 200px !important;height: 200px !important">
			  				@endif
		 	  			</div>
			  		</div>
			 	</div>		
			</div>
			@endif

   		  </div> 
		</div>
	  </nav>
	</div>
</div>


		 
   
	<!---- ALERTAS -------->		 
	@if(Session::has('errores'))	
		<div class="container">
			<div class="alert" style="display:none;" >			 
				@if($errors->any())
				<ul class="ulerror">
					@foreach($errors->all() as $error)
					<li>{{$error}}</li>
					@endforeach
				</ul>
				@else
				<ul>
					<li class="ulerror">{{ session()->get("errores") }}</li>
				</ul>					 
				@endif
			</div>
		</div>
 	@elseif(Session::has('success'))
		<style>
			.ajs-button{ color: #fff!important;background-color: #5CB811!important}
			.ajs-header{ color: #fff!important;background-color: #5CB811 !important; }
			.ajs-content{color: #5CB811!important;font-size: 1.1rem  !important}
		</style>					 
		<div class="suceess" style="display:none;position: absolute;" >			 
			<ul class="ul_success"  >
				<li>{{ session()->get("success") }}</li>
			</ul>					 			 
		</div>
		<div class="titlesuceess" style="display:none;" >
			<h3>{{ session()->get("success") }}</h3>					
		</div>
		<h3 id="subitisucess"style="display:none;text-shadow: 2px 2px 2px #460b09 ">{{ session()->get("title") }}</h3>	 
	@endif

@endsection