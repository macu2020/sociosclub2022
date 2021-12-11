@extends('Template.home')
@section('content')

<div class="page" >
	<div class="container-fluid">
	  <nav arial-label="breadcrumb shadow" >
		<div class="container-fluid" style="margin-top: 110px;margin-bottom: 40px">
   		  <div class="row">
			<div class="col-md-9"><!------ Table Category ---->
		   	 	<div class="panel shadow" style="border-top: 1px solid hsla(0, 0%, 71%, .3)">
				  	<div class="header">
				  		<h2 class="title"><i class="fas fa-user-plus"></i> Editar Invitado</h2>
				  	</div>	
 			    		
					{!! Form::open(['url'=>'/edit/'.$invit->idinvit.'/invi','method'=>'POST','class'=>'col-md-9 col-xs-12 regis-form','id'=>'edit_invit','files'=>true,])!!}	
      	  
     	  			<div class="row">
			     	   	<div class="col-12  col-sm-12 col-md-6"  >
				     	  <div class="form-group">
						    <label for="first_name" class="subtit">Nombre</label>
						    {!!Form::text('first_name',$invit->name,['class'=>'form-control' ,'placeholder'=>'Nombre','id'=>'first_name'])!!}
							@if($errors->any('first_name'))
								<span class="text-danger">{{$errors->first('first_name')}} </span>
							@endif
						  </div>
			     	   	</div>  
			     	   	<div class="col-12   col-sm-12 col-md-6">
				     	  <div class="form-group">
						    <label for="last_name" class="subtit">Apellido</label>				
							{!!Form::text('last_name',$invit->lastname,['class'=>'form-control' ,'placeholder'=>'Apellido','id'=>'last_name'])!!}
						    @if($errors->any('last_name'))
								<span class="text-danger">{{$errors->first('last_name')}}</span>
							@endif
						  </div>
			     	   	</div>
     	   			</div>

		     	  	<div class="row">
			     	  	<div class="col-md-6">
						  <div class="form-group passregi">
						    <label for="dni" class="subtit">Dni</label>
							{!!Form::text('dni',$invit->dniinvit,['class'=>'form-control' ,'placeholder'=>'Dni aquí','id'=>'dni'])!!}
							@if($errors->any('dni'))
								<span class="text-danger">{{$errors->first('dni')}}</span>
							@endif
						  </div>     	  		
			     	  	</div>


			     	  	<div class="col-md-6">
						  <div class="form-group passregi">
						    <label for="selecclave" class="subtit">Clave de Socio </label>
						    @if ($socys != null)
					  			{!!Form::select('selecclave', $socys,$invit->socio_id,['class'=>'custom-select text-center select-soci','id'=>"js-example-basic-single"])!!}
					  		@else
								<h4 class="inva-categor">Sin Perfil</h4>
					  		@endif
							@if($errors->any('selecclave'))
								<span class="text-danger">{{$errors->first('selecclave')}}</span>
							@endif
						  </div>     	  		
			     	  	</div>
		     	  	</div>
 
		     	  	<div class="row">
			     	  	 
			     	  	<div class="col-md-6 col-sm-12 ">
			    		    <div class="form-group  ">
						    <label for="selecperfil" class="subtit">Perfil </label>
									 
			 			  			@if ($marc != null)
					  				{!!Form::select('selecperfil', $marc,$invit->perfil,['class'=>'custom-select text-center select-soci','id'=>"selecperfil"])!!}
					  				@else
										<h4 class="inva-categor">Sin Perfil</h4>
					  				@endif


									@if($errors->any('selecperfil'))
									<span class="text-danger">{{$errors->first('selecperfil')}}</span>
									@endif
						  		</div>	  		
			     	  	</div>
		     	  	</div>

		     	  	<div class="row " style="display: flex;justify-content: center;align-items: center;">
			     	  	 
						<div class="col-md-6 ">

			     	  		<input type="submit" class="form-control btn btn-success btn-home px-3 mt-2" value="Guardar"></input>
			     	  	</div>		
		     	  	</div>

 		  			{!!Form::close()!!}

 			 	</div>		
			</div> 

			<div class="col-md-3" ><!------ Form Category ----->
		   	 	<div class="panel shadow" style="border-top: 1px solid hsla(0, 0%, 71%, .3)">
			  		<div class="header">
			  			<h2 class="title">
						<a href="{{ url('consulta-ingreso-invitado') }} " class="btn btn-success btn-home"   ><i class="fas fa-users"></i>Tabla Invitados</a>
			  			</h2>  			
			  		</div>	
			  		<div class="inside" >
			  			<div class="panel shadow panel-add d-flex flex-column justify-content-start align-items-center pt-4"  >
			  				@if(is_null($invit->avatar))
			  					<img src="{{ asset('img/iconos/user-avatar.png') }}" alt=""  id="img-maci" class="img-fluid rounded-circle" width="200" height ="200" style="width: 200px !important;height: 200px !important">
			  				@else 
			  					<img src="{{url('uploads_users/usu_'.$usu->id.'/av_'.$invit->avatar)}}"alt=""  id="img-maci" class="img-fluid rounded-circle" width="200" height ="200" style="width: 200px !important;height: 200px !important">
			  				@endif
		 	  			</div>
		 	  			
			  		</div>
			 	</div>		
			</div> 
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