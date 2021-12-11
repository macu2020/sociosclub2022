@extends('Template.home')
@section('content')
 

	@if (Auth::user()->perfil == 3)	  <!---- ROL => RECEPCIONISTA --->
	<style type="text/css">
		.nav-list .menu-item-has-children:nth-child(3)>a {
        background-image: url( {{ asset('img/iconos/icon-qr-header.gif') }});
    }
    .header-nav .menu-item-has-children:nth-child(3)>a {
        background-image: url({{ asset('img/iconos/icon-qr-header.gif') }})
    }
	</style>
		<div class="contslide"  >
		 <div class="container pt-3"  id="inisant">
 		 	<div class="row"> <!--- IMAGEN DE SOCIOS ---->
		 	  <div class="col-md-8 mt-2">
		 	  	<button class="btn   btn-success" id="btnscan" ><i class="fas fa-video"></i> Ver camara <i class="fas fa-qrcode"></i></button>
		 		  <fieldset class="scheduler-border  mt-4	">
		    			<legend class="scheduler-border " style="width:250px;"> Escanear mi codigo QR </legend>
		         		<div class="row  d-flex flex-row justify-content-center align-items-center  "   style="position: relative;" >

		         			<!--- informacion de titular y conyuge de socio ----->		 		          <video id="preview"      style="position: relative;width: 100%"></video>
		         				<div class="loadvideo" style=" "></div>


					    </div>
		 		  </fieldset>

		 		   
		 	  </div>

		 	  <div class="col-md-4 cont-datos-g_ini" >
		 		<div class="datos-g text-center">
		 			<fieldset class="scheduler-border mt-4">
		 					<legend class="scheduler-border ">Datos Generales </legend>
 		 					
		 					<!--- FORMULARIO  SOCIO ------------->
		 					{!! Form::open(['url'=>'showsocio','method'=>'POST','class'=>'auth-form','id'=>'form-showsocios'])!!}	
			 					<div class="row  ">
			 						<div class="  col-md-12 secforsoci" >
  				 				      	<img src="{{ asset('img/iconos/user-avatar.png') }}" alt=""  id="img-qr" class="img-fluid rounded-circle" width="200" height ="200" style="width: 200px !important;height: 200px !important">
 								  	</div>

				 					<div class=" col-md-6 secforsoci " >
								    	<label for="clave_socio"  >Clave Tit.</label>
 				 				      	{!!Form::text('clave_socio',old('clave_socio'),['class'=>'form-control text-center' ,'id'=>'clave_socio'])!!}	
				 				      	<input type="hidden" id="nomsocioti">							
  								  	</div>
								  	<div class="  col-md-6 secforsoci" >
								    	<label for="placa_socio" class="" >Perfil</label>
 				 				      	<h2 id="perfil-qr">-</h2>
 								  	</div>
 								  	<div class="  col-md-12 secforsoci" >
  				 				      	<h4 id="nom-qr"></h4>
  				 				      	<h4 id="ape-qr"></h4>
 								  	</div>
								  	 
							  	</div>
						  	{!!Form::close()!!}
						  	<!--- FORMULARIO INVITADO POR DIA ---->
							<a href="#" class="btn btn-success btn-home btninvitado mt-1"><i class="fas fa-users"></i>   Invitado Por Dia</a>

							<div class="row " ><!--- Barra de progreso --->
								<div class="col-md-12 "  >
									<div id="myProgress" class="d-block">
									  <div id="myBar" >
									    <div id="label">0%</div>
									  </div>
									</div>
								</div>
							</div>

		 				  	<div class="row p-1 "  >
						  		<div class=" col-md-12 text-center">
							    	<label for="user" >
							    	Cupos libres  disponibles    &nbsp; &nbsp;      :</label>
							    		<p  class="d-inline" id="cuplib">00</p>
							  	</div>
						  		<div class=" col-md-12 text-center" >
							    	<label for="user"> Cupos libres usados &nbsp;   &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;:</label>
							    	<p class="d-inline" id="cupUsa">00</p>
							  	</div>
						  	</div>
						  	<hr >

						  	<div class="row p-1 cont-clase"  >
						  		<div class="  col-md-6  cont-clase_div"   >
						  		 	<label for="" > Adulto:&nbsp; </label>
							  		 <input type="number" class="form-control readonli" id="adulto" readonly >	
							  	</div>	
						  		 <div class="  col-md-6  cont-clase_div"  >
						  		 	<label for="">Niño:&nbsp;</label>
							  		<input type="number" class="form-control readonli" id="nino"   readonly>	
							  	</div>	
						  	</div>
 		 			</fieldset>
 		 			<fieldset class="scheduler-border">
		 				<legend class="scheduler-border " style="width:110px;"> Acciones </legend>
		 				<!--<button class=" form-control position-relative mt-1"  >CONSULTAR DEUDAS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{ asset('img/iconos/consul.png') }}" alt="" width="11%" class="img-fluid img-btns"></button>-->
		 				<button class="form-control position-relative mt-1 btn-abrir-invi"  >CONSULTAR INVITADOS &nbsp;&nbsp;&nbsp;&nbsp;<img src="{{ asset('img/iconos/invit.png') }}" alt="" width="11%" class="img-fluid img-btns"   ></button>
		 				<button class="form-control position-relative mt-1 btn-abrir"  >CONSULTAR INGRESOS &nbsp;&nbsp;&nbsp;&nbsp;<img src="{{ asset('img/iconos/ingre.png') }}" alt="" width="11%" class="img-fluid img-btns"  ></button>
		 				<!--<button class="form-control position-relative mt-1 ">OBSERVACIONES &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="{{ asset('img/iconos/oberv.png') }}" alt="" width="14%" class="img-fluid img-btns" ></button>-->
		 			</fieldset>	 
		 		</div>
		 	  </div>
		 	</div>
		 </div>
		</div>
		<!---- MODAL REGISTRO INVITADO ----->
	    <div class="contmod" id="modalPed">
	      <div class="body_m" style="background-image: url({{asset('img/login/usuario-invitado-yosemite.jpg')}});  ">
	         <div class="container-fluid modalfi"   >
	        	<div class="row "     >

	        	 <!---- IMAGEN LOGO ------>
	        	 <div class="col-sm-6 col-md-6 cont_m_"  >
	        		<div class="cont_m_img"  >
	         			<img src="{{ asset('img/login/logos.jpeg') }}" alt="" class="img-fluid"  width="60%" style="border-radius: 20%">	
	        		</div>
	        	 </div>

	        	 <!----- INFO SOCIO ------->
	        	 <div class="col-sm-6 col-md-6 cont_tex_  "  >
	        				<div class="cont_tex_modal " >
		 					    <div class="cont_tex_modal_header">
		 				            <h1 class="modal-title text-center">Registro de invitado</h1>
						        </div>


							    <div class="cont_tex_modal_body ">
									{!!Form::open(['url'=>'/invitado-socio','id'=>'form-invitado-save'])!!}
								    <div class="form-group">
								        <div class="row "  >
								        	<label   class="col-6 col-sm-6 col-md-6"></label>
								          	<label for="" class="col-6 col-sm-6 col-md-6 text-center">Clave Socio</label>	
	 							        </div>
								        <div class="row">
	 								       	{!!Form::text('clasoc',null,['class'=> 'form-control offset-7 col-md-4 col-sm-4 col-4 text-center readonli','id'=>'cod-soci','readonly'])!!}
								        </div>
								        	
								        <div class="row p-2 cont-clase"  >
										  	<div class="col-4 col-md-4 mt-3 mb-4 cont-modal-lbl">
										  		<label for="">Titular :</label>
										  	</div>
										    <div class="col-8 col-md-8 mt-3 mb-4 cont-modal-input"  >
										  		<input type="text" class="form-control readonli" id="titul"  readonly >	
										  	</div>
										</div>
								    </div>

									<div class="input-group"> <!---- Name ------->
										@if($errors->any('name'))
											<span class="text-danger vereror erorestyl">{{$errors->first('name')}} </span>
										@endif
									    <div class="input-group-prepend dylo">
									        <div class="input-group-text"><i class="fa fa-user"></i></div>
									    </div>
									    {!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre','id'=>'first_name'])!!}
									</div>
									      		

									<div class="input-group"><!---- LastName ---->
										@if($errors->any('lastname'))
											<span class="text-danger vereror erorestyl">{{$errors->first('lastname')}} </span>
										@endif								        
										<div class="input-group-prepend dylo">
									        <div class="input-group-text"><i class="fa fa-user"></i></div>
									    </div>
									    {!!Form::text('lastname',null,['class'=>'form-control','placeholder'=>'Apellido','id'=>'last_name'])!!}
									</div>

									<div class="input-group"><!---- Dni invitad-->
									    @if($errors->any('dni'))
											<span class="text-danger vereror erorestyl">{{$errors->first('dni')}} </span>
										@endif
									    <div class="input-group-prepend">
									        <div class="input-group-text" ><i class="far fa-id-card"></i></div>
									    </div>
									    {!!Form::number('dni',null,['class'=>'form-control','placeholder'=>'Dni' ,'id'=>'dni'])!!}				
	 								</div>
	 								<div class="input-group"><!---- Dni invitad-->
									    @if ($class != null)
					  					<select name="selecatego"  class="custom-select " >
					  						<option value="" class="text-center" >-- seleccione --</option>
					  						@foreach ($class as $element)
					  						<option value="{{ $element->id }}" class="text-center" >{{ $element->clase }}</option>
					  						@endforeach
					  					</select>
					  					@else
											<h4 class="inva-categor">Sin Categoria</h4>
					  					@endif
					  					@if($errors->any('selecatego'))
											<span class="text-danger vereror erorestyl">{{$errors->first('selecatego')}} </span>
										@endif			
	 								</div>


								        <div class="modal-footer text-center"  style="margin: 0px auto;display: block;">
						        			 
						        			<button type="submit" class="btn btn-primary modal-footerenviar" ><i class="fa fa-shopping-basket"></i> Enviar </button>
						        		</div>
									{!!Form::close()!!}

							    </div>       					
	        				</div>				    
				 </div>

				 <a href="#" class="btn-close-popup"  >X</a>
	        				
	        	</div>
	         </div>
	 	  </div>
	    </div>

	    
    	 
	 							  
	@endif

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