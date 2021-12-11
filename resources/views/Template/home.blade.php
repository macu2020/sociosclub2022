<!DOCTYPE html>
<html lang="es-PE">
<head>
<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>✅COUNTRY-CLUB✅ @yield('title') </title>
 
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta name="description" content="✅ Somos MI PIEL Consultorios especialistas en Dermatalogía  con capacitación suficiente y tecnología de punta ➤ para brindar tratamiento en dermatología ✔ clínica, ✔ estética láser,✔ cirugía dermatológica,✔ podología, ✔ cosmiatría y tratamientos láser como rejuvenecimiento facial, cicatrices, manchas, secuelas de acné depilación permanente y otros.">
 
	<meta name="author" content="jorge macuri ayra | miweeb.com">
  	<meta name="geo.position" content="-12.004031483308708, -77.06636181187898">	
  	<meta name="geo.region" content="PE-LIM">
  	<meta name="geo.placename" content="Lima, Peru">

	<meta property="fb:app_id" content="670595706916508" />
	<meta property="og:locale" content="es_ES" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="MI PIEL consultorios - Perú lima los olivos - Dermatología Clínica, Estética y Láser" />
	<meta property="og:title" content="Diseños WebM@c" />
 	<meta property="og:url" content="miweb.com" />
	<meta property="og:image" content="Assets/img/portadmacuri.jpg" />
	<meta property="og:description" content="✅ Somos MI PIEL Consultorios especialistas en Dermatalogía  con capacitación suficiente y tecnología de punta ➤ para brindar tratamiento en dermatología ✔ clínica, ✔ estética láser,✔ cirugía dermatológica,✔ podología, ✔ cosmiatría y tratamientos láser como rejuvenecimiento facial, cicatrices, manchas, secuelas de acné depilación permanente y otros.">
	<meta property="og:site_name" content="MI PIEL Consultorios" />
	<meta property="article:publisher" content="https://www.facebook.com/flordelizdermatologa/" />
	<meta property="article:modified_time" content="2021-11-23T20:10:08+00:00" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

 	<meta name="twitter:card" content="summary_large_image" >
	<meta name="twitter:site" content="@jorge55614891" >
	<meta name="twitter:creator" content="@jorge55614891" >
	<meta name="twitter:title" content="Diseño paginas web - Tiendas Virtuales WebMac">
	<meta name="twitter:description" content="✅ Agencia de Diseño Web y Desarrollo Web en Lima ➤ Servicios: ✔ Diseño web  ✔ Programación Web ✔ Creación de tiendas Online ✔ Posicionamiento SEO ✔ CMS ">
	<meta name="twitter:image" content="Assets/img/portadmacuri.jpg">
	<link rel="icon" sizes="192x192" href="{{asset('img/login/logos.jpeg')}}">

	<link rel="canonical" href="miweb.com">


	<!--- Estyl Frontend ---->
	<link rel="stylesheet" href="{{asset('css/app.css')}}">
	<link rel="stylesheet" href="{{asset('css/csshome.css')}}">

	<!--- Escript Libreria--->
	<script src="{{ asset('js/app.js') }}"  ></script> 
     <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

</head>
	 
<body>

   
		 

	 



	<style>
		#scrollUp{bottom: 20px;right :20px;width: 50px;height: 50px;
        border-radius: 100%;border:1px solid #E0C2A5; background : url('{{asset('img/iconos/flecha.jpg')}}') ;}
	</style>

 



		<div> 
			@include('Backend.header')
		</div>
	
			@section('content')
			@show

		<div>
			@include('Backend.footer')

 		</div>
 		<!---- MODAL INGRESO DE SOCIO ------>
	    <div class="pop-up fixed-top"  >
	        <div class="pop-up-wrap">
	             
	            <div class="subcription  " style="position: relative !important;">
	                <div class="line"></div>
	                <i class="far fa-times-circle" id="close"></i>
	                <div class="sub-content">

	                    <h2>INGRESOS DE SOCIOS</h2>
	                    <p style="display: inline;">Clave de socio titular <h2 id="h2invimodls" > </h2> . </p>
	                   <div class="inside table-responsive"> 	 
				    		<table class="table table-bordered table-hover table-sm align-middle  table-striped mt-3"  id="tbl_sociomodal"  >
					    		<thead style="background-color: #0a91ab;">
						    		<tr class="text-center">
						    			<th>Socio</th>
						    			<th>Foto</th>
						    			<th>Perfil</th>
						    			<th>Dni</th>
	 					    			<th>Fecha - hora</th>
 	     					    	</tr>
					    		</thead>
				    			<tbody  style="overflow: scroll !important" >
					    			 
				    			</tbody>	  	
				    		</table>
				  		</div>
	                </div>
	                
	                <div class="line"></div>
	            </div>
	        </div>
    	</div>
    	<!---- MODAL INGRESO INVITADO ------>
	    <div class="pop-up2 fixed-top">
	        <div class="pop-up-wrap2">
	             
	            <div class="subcription">
	                <div class="line"></div>
	                <i class="far fa-times-circle" id="close2"></i>
	                <div class="sub-content">

	                    <h2>INGRESOS DE INVITADOS</h2>
	                    <p style="display: inline;">Clave de socio titular <h2 id="h2invimodls" >?</h2> . </p>
	                   <div class="inside table-responsive"> 	 
				    		<table class="table table-bordered table-hover table-sm align-middle  table-striped mt-3"  id="tbl_sociomodalinvi" >
					    		<thead style="background-color: #0a91ab;">
						    		<tr class="text-center">
						    			<th>Invitado</th>
						    			<th>Dni</th>
	 					    			<th>Fecha - hora</th>
						    			<th>Perfil</th>
 	     					    	</tr>
					    		</thead>
				    			<tbody>
					    			 
				    			</tbody>	  	
				    		</table>
				  		</div>
	                </div>
	                
	                <div class="line"></div>
	            </div>
	        </div>
    	</div>

 	<!------ Script Fronted ----->
    <script src="{{  asset('js/jshome.js') }} "  ></script>	
</body>
</html>