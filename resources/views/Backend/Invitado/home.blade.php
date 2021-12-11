@extends('Template.home')

  @section('title','Tabla-Invitados')

@section('content')

<div class="page" >
	<div class="container-fluid">
	  <nav arial-label="breadcrumb shadow" >
		<div class="container-fluid" style="margin-top: 110px;margin-bottom: 40px">
   		  <div class="row">
			<div class="col-md-12"><!------ Table Category ---->
		   	 	<div class="panel shadow" style="border-top: 1px solid hsla(0, 0%, 71%, .3)">
				  	<div class="header">
				  		<h2 class="title"><i class="fas fa-users"></i> Invitados</h2>
				  	</div>	

			  		<div class="inside table-responsive"> 	 
			    		<table class="table table-bordered table-hover table-sm align-middle  table-striped mt-3"  id="tbl_invit" >
				    		<thead style="background-color: #0a91ab;">
					    		<tr class="text-center">
					    			<th>Id</th>
					    			<th>Invitado</th>
 					    			<th>Titular</th>
					    			<th>Dni</th>
					    			<th>Clase</th>
					    			<th>Dia</th>
					    			<th>Hora</th>
					    			<th> Act.</th>
					    		</tr>
				    		</thead>
			    			<tbody>
				    			@foreach($datos as $element)
					    			<tr class=" text-center {{($element->role =='0')?'sinpriv':''}}">
						    			<td width="5%">{{ $element->idinvit}}</td>
						    			<td>{{ $element->name." ". $element->lastname}}</td>
						    			<td>{{ $element->clave }}</td>

 										<td>{{ $element->dniinvit }}</td>
										<td>{{ $element->clase }}</td>

						    			<td>{{ $element->created_at->format('d-m-Y')}}</td>
						    			<td>{{ $element->created_at->format('H:i:s')}}</td>
						    			<td class="text-center">								
											<div class="opciones" >
												<a href="{{url('/edit/'.$element->idinvit.'/invi')}}   "  data-id=" "  data-toggle="tooltip" data-placement="top" title="editar"><img src="{{asset('img/iconos/icoedit.png')}}" style="width: 30px"></a>
												<a href="#"id="eli-pro" name="{{ $element->idinvit }}" data-id="elicli" data-nom="{{ $element->name }}"   data-toggle="tooltip" data-placement="top" title="eliminar" ><img src="{{asset('img/iconos/icoelim.png')}}" style="width: 30px">
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