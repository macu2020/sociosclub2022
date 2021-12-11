@extends('Template.home')

 @section('title','Tabla-Reporte Socios')

@section('content')

<div class="page" >
	<div class="container-fluid">
	  <nav arial-label="breadcrumb shadow" >
		<div class="container-fluid" style="margin-top: 110px;margin-bottom: 40px">
   		  <div class="row">
			<div class="col-md-12"><!------ Table Category ---->
		   	 	<div class="panel shadow" style="border-top: 1px solid hsla(0, 0%, 71%, .3)">
				  	<div class="header">
				  		<h2 class="title"><i class="fas fa-users"></i>Reporte general de Socios</h2>
				  	</div>	

			  		<div class="inside table-responsive"> 	 
			    		<table class="table table-bordered table-hover table-sm align-middle  table-striped mt-3"  id="tbl_socio_repor" >
				    		<thead style="background-color: #0a91ab;">
					    		<tr class="text-center">
					    			<th>Clave</th>
					    			<th>Socio</th>
					    			<th>Imagen</th>
					    			<th>Perfil</th>
					    			<th>Dni</th>
					    			<th>Tipo</th>
					    			<th>Correo</th>
					    			<th>Asist.</th>
					    			<th>Dia</th>
					    			<th>Hora</th>
 					    		</tr>
				    		</thead>
			    			<tbody>
			    				@if ($user)
				    			@foreach($user as $element)
					    			<tr class=" text-center {{($element->estado =='1')?'asisit':''}}">
						    			<td width="5%">{{ $element->clave}}</td>
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
										<td>{{adultoni($element->clase_id)}}</td>

						    			<td>{{ $element->email}}</td>
						    			<td>{{asistencia($element->estado)}}</td>
						    			<td>	
						    				@if ($element->dia == null)
						    						-
						    				@else
						    				 	{{ $element->dia}}
						    				@endif

						    			</td>
						    			<td>
						    				@if ($element->horas == null)
						    						-
						    				@else
						    				 	{{ $element->horas }}
						    				@endif
 										</td>
						    			 
					    			</tr>
				    			@endforeach
				    			@endif
			    			</tbody>	  	
			    		</table>
			  		</div>
			 	</div>		
			</div> 

			  
   		  </div> 
		</div>
	  </nav>
	</div>
</div>

		       
 

 		 
@endsection