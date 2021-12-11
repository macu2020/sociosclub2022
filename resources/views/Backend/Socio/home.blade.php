@extends('Template.home')

@section('title','Tabla-Socios')

@section('content')

<div class="page" >
	<div class="container-fluid">
	  <nav arial-label="breadcrumb shadow" >
		<div class="container-fluid" style="margin-top: 110px;margin-bottom: 40px">
   		  <div class="row">
			<div class="col-md-10"><!------ Table Category ---->
		   	 	<div class="panel shadow" style="border-top: 1px solid hsla(0, 0%, 71%, .3)">
				  	<div class="header">
				  		<h2 class="title"><i class="fas fa-users"></i> Socios</h2>
				  	</div>	

			  		<div class="inside table-responsive"> 	 
			    		<table class="table table-bordered table-hover table-sm align-middle  table-striped mt-3"  id="tbl_socio" >
				    		<thead style="background-color: #0a91ab;">
					    		<tr class="text-center">
					    			<th>Id</th>
					    			<th>Socio</th>
					    			<th>Imagen</th>
					    			<th>Perfil</th>
					    			<th>Dni</th>
					    			<th>Cod</th>
					    			<th>Correo</th>
					    			<th>Asist.</th>
					    			<th>Dia</th>
					    			<th>Hora</th>
					    			<th> Act. </th>
					    		</tr>
				    		</thead>
			    			<tbody>
				    			@foreach($user as $element)
					    			<tr class=" text-center {{($element->estado =='1')?'asisit':''}}">
						    			<td width="5%">{{ $element->id}}</td>
						    			<td>{{ $element->name." ". $element->lastname}}</td>
						    			<td width="2%"  class="text-center"> 
											@if(is_null($element->avatar))
												<img src="{{url('img/iconos/user-avatar.png')}}" class="avatar_hom" >
											@else
												<img src="{{url('uploads_socios/soc_'.$element->id.'/av_'.$element->avatar)}}" class="avatar_hom"  >
 
								  			@endif
										</td>
										<td>{{ getperfilsocio($element->perfil_id) }}</td>
										<td>{{ $element->dni }}</td>
										<td>{{ $element->clave }}</td>

						    			<td>{{ $element->email}}</td>
						    			<td>{{asistencia($element->estado)}}</td>
						    			<td>	
						    				@if ($element->created_at == null || $element->estado == null)
						    						-
						    				@else
						    				 	{{ $element->created_at->format('d-m-Y')}}
						    				@endif

						    			</td>
						    			<td>
						    				@if ($element->created_at == null || $element->estado == null)
						    						-
						    				@else
						    				 	{{ $element->created_at->format('H:i:s')}}
						    				@endif
 										</td>
						    			<td class="text-center">								
											<div class="opciones" >
												<a href="{{url('/edit/'.$element->id.'/socio')}}   "  data-id=" "  data-toggle="tooltip" data-placement="top" title="editar" class="m-1"><img src="{{asset('img/iconos/icoedit.png')}}" style="width: 30px"></a>
												<a href="#"id="eli-pro" name="{{ $element->id }}" data-id="elicli" data-nom="{{ $element->name }}"   data-toggle="tooltip" data-placement="top" title="eliminar" class="m-1"><img src="{{asset('img/iconos/icoelim.png')}}" style="width: 30px">
												<a href="#"id="eli-pro" name="{{ $element->id }}" data-id="upqr" data-nom="{{ $element->name }}"   data-toggle="tooltip" data-placement="top" title="eliminar" class="m-1"><img src="{{asset('img/iconos/codigo-qr.png')}}" style="width: 30px">
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

			<div class="col-md-2" ><!------ Form Category ----->
		   	 	<div class="panel shadow" style="border-top: 1px solid hsla(0, 0%, 71%, .3)">
			  		<div class="header">
			  			<h2 class="title">
						<a href="{{ url('/add-soc') }} " class="btn btn-success   btn-home "   ><i class="fas fa-user-plus"></i>   Agregar Socio</a>
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