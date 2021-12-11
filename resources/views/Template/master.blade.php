<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Socios-Club</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta name="description" content="✅ Portafolio Jorge Macuri Ayra en Lima ➤ Servicios: ✔ Diseño web  ✔ Programación Web ✔ Creación de tiendas Online ✔ Posicionamiento SEO ✔ CMS ,tiendas virtuales en peru, tiendas virtuales peruanas,tiendas virtuales online, paginas web en peru, paginas web economicas">
	<meta name="author" content="jorge macuri ayra | macuriportafolio.ml">
   	<meta name="geo.position" content="-12.0213971; -76.0682887">	
  	<meta name="geo.region"   content="PE-LIM">
  	<meta name="geo.placename"content="Lima, Peru">

	<meta property="fb:app_id" content="670595706916508" />
	<meta property="og:title" content="Diseños WebM@c" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="miweb.com" />
	<meta property="og:image" content="Assets/img/portadmacuri.jpg" />
	<meta property="og:description" content="Estamos listos para lograr juntos que tu marca concrete sus objetivos en el mundo digital. Te ofrecemos diseño de página web 100% funcional y creativo.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<meta content="✅ Jorge Macuri Ayra ,Agencia de Diseño Web y Desarrollo Web en Lima ➤ Servicios: ✔ Diseño web  ✔ Programación Web ✔ Creación de tiendas Online ✔ Posicionamiento SEO ✔ CMS "/>
	<meta name="twitter:card" content="summary_large_image" >
	<meta name="twitter:site" content="@jorge55614891" >
	<meta name="twitter:creator" content="@jorge55614891" >
	<meta name="twitter:title" content="Diseño paginas web - Tiendas Virtuales WebMac">
	<meta name="twitter:description" content="✅ Agencia de Diseño Web y Desarrollo Web en Lima ➤ Servicios: ✔ Diseño web  ✔ Programación Web ✔ Creación de tiendas Online ✔ Posicionamiento SEO ✔ CMS ">
	<meta name="twitter:image" content="Assets/img/portadmacuri.jpg">
	<link rel="icon" sizes="192x192" href="{{asset('img/iconos/logo.png')}}">

	<link rel="canonical" href="macuriportafolio.ml">

 
	<!--- Estyl Frontend ---->
	<link rel="stylesheet" href="{{asset('css/app.css')}}">
	<link rel="stylesheet" href="{{asset('css/csslogin.css')}}">
    <!-- Scripts de public js---->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>           
    <script src="{{ asset('js/app.js') }}"></script> 
 
</head>
	<script>
		//------>Loader
		  window.addEventListener("load", function(){
  		//document.getElementById('loader').classList.toggle("loader2")
  		$('#oneload').fadeOut();
	    $('body').removeClass('hidden')
		})
	</script>
<body >
	 	
	  
	 
	<!-- Cabezera principal ---->
	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3  ">
	    <h5 class="my-0 mr-md-auto logo-icon mt-2">
	    	<img src="{{ asset('img/login/logos.jpeg') }}" alt="" width="100" class="rounded-circle"  >
	    </h5>
	    <nav class="my-2 my-md-0 mr-md-3 top-nav" >

	        @if(auth()->check())
	            <a class="p-2 nav-homelogin   {{(request()->route()->getName()=='getperfil')?'active btn':''}}" href="{{route('getperfil')}}">Perfil</a>
	            <a class="p-2  nav-homelogin  " href="{{url('/logout')}} ">SAlir</a>
	          
	        @endif
	    </nav>
	         
	</div>


	 

	 <!-- Inicio contenido  ---->
	<div class="container-fluid " style="/*min-height: 74vh;*/">
	    @section('contenido')    
	    @show
	</div>
	<!-- Fin contenido  ---->



	<!-- footerr principal ---->
	<footer lass="border-top footerlogin">
	</footer>
	<script>
	 	//----> Validacion de recaptcha en el registro 
	    function recaptchaDataCallbackRegister(response){
	      $('#hiddenRecaptchaRegister').val(response);
	      $('#hiddenRecaptchaRegisterError').html('');
	    }

	    function recaptchaExpireCallbackRegister(){
	     $('#hiddenRecaptchaRegister').val('');
	    }

		//----> Validacion de recaptcha en el Login 
	    function recaptchaDataCallbackLogin(response){
	      $('#hiddenRecaptchaLogin').val(response);
	      $('#hiddenRecaptchaLoginError').html('');
	    }

	    function recaptchaExpireCallbackLogin(){
	     $('#hiddenRecaptchaLogin').val('');
	    }
	</script>
		 

 	<!------ Script Fronted ----->
    <script src="{{  asset('js/jslogin.js') }} "  ></script>	
</body>
</html>