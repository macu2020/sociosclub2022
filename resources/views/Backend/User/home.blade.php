@extends('Template.home')

@section('title','Tabla-Usuario')
@section('content')

<div class="page" >
	<div class="container-fluid">
	  <nav arial-label="breadcrumb shadow" >
		<div class="container-fluid" style="margin-top: 110px;margin-bottom: 40px">
   		  <div class="row">
			<div class="col-md-9"><!------ Table Category ---->
		   	 	<div class="panel shadow" style="border-top: 1px solid hsla(0, 0%, 71%, .3)">
				  	<div class="header">
				  		<h2 class="title"><i class="fas fa-users"></i> Usuarios</h2>
				  	</div>	

			  		<div class="inside table-responsive"> 	 
			    		<table class="table table-bordered table-hover table-sm align-middle  table-striped mt-3"  id="tbl_users" >
				    		<thead style="background-color: #0a91ab;">
					    		<tr class="text-center">
					    			<th>Id</th>
					    			<th>Nombre</th>
					    			<th>Imagen</th>
					    			<th>Perfil</th>
					    			<th>Correo</th>
					    			<th> Act.</th>
					    		</tr>
				    		</thead>
			    			<tbody>
				    			@foreach($user as $element)
					    			<tr class=" text-center {{($element->role =='0')?'sinpriv':''}}">
						    			<td width="5%">{{ $element->id}}</td>
						    			<td>{{ $element->name." ". $element->lastname}}</td>
						    			<td width="2%"  class="text-center"> 
											@if(is_null($element->avatar))
												<img src="{{url('img/iconos/user-avatar.png')}}" class="avatar_hom" >
											@else
												<img src="{{url('uploads_users/usu_'.$element->id.'/av_'.$element->avatar)}}" class="avatar_hom rounded-circle"  >
 
								  			@endif
										</td>
										<td>{{ getperfil($element->perfil) }}</td>

						    			<td>{{ $element->email}}</td>
						    			<td class="text-center">								
											<div class="opciones" >
												<a href="{{url('/edit/'.$element->id.'/user')}}   "  data-id=" "  data-toggle="tooltip" data-placement="top" title="editar"><img src="{{asset('img/iconos/icoedit.png')}}" style="width: 30px"></a>
												<a href="#"id="eli-pro" name="{{ $element->id }}" data-id="elicli" data-nom="{{ $element->name }}"   data-toggle="tooltip" data-placement="top" title="eliminar" ><img src="{{asset('img/iconos/icoelim.png')}}" style="width: 30px">
											</a>
											</div>
										</td>
					    			</tr>
				    			@endforeach
			    			</tbody>	  	
			    		</table>
			  		</div>
			 	</div>		
			</div> 

			<div class="col-md-3" ><!------ Form Category ----->
		   	 	<div class="panel shadow" style="border-top: 1px solid hsla(0, 0%, 71%, .3)">
			  		<div class="header">
			  			<h2 class="title">
						<a href="{{ url('/add-user') }} " class="btn btn-success   btn-home "   ><i class="fas fa-user-plus"></i>   Agregar Usuario</a>
			  			</h2>  			
			  		</div>	
			  		<div class="inside" >
			  			<div class="panel shadow panel-add d-flex flex-column justify-content-start align-items-center pt-4" style="background-image: url({{asset('img/login/macuri21.jpg')}} ); ">
		 	  			</div>
			  		</div>
			 	</div>		
			</div> 
   		  </div> 
		</div>
	  </nav>
	</div>
</div>

		<!---- ALERTA ERROR -------------->
        @if(Session::has('errores'))     
	        <div class="alert" style="display:none;" >       
	            @if($errors->any())
	                <ul class="ulerror">
	                  @foreach($errors->all() as $error)
	                  <li>{{$error}}</li>
	                  @endforeach
	                </ul>
	            @endif
	        </div>
        @endif       
 

 		<!---- ALERTA SUCCESS ------------> 
	    @if(Session::has('success'))     
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