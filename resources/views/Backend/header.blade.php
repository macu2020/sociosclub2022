<div class="fixed-top">
  <!---- HEDER 01 -sticky-top----->
  	<div class="stikyheder">
	    <div class=" stikyheder_cont "  >
 	      <i class="far fa-clock hedini" ></i> <h2 id="fecha" style=""></h2> 
 	    </div> 
  	</div>

    
  

  <!---- HEDER 02 ------> 
  	<div class="header-content  ">

	    <div class="row"  >
	      	<div class="col-sm-2 col-md-1 col-lg-2  header-content_col" style="border-right: 1px solid #04c4cb " >
	          <strong class="logo"  >
	              <a href="{{ url('/') }}"><img src="{{asset('img/login/logos.jpeg')}}" alt="logo " width="10%"   class="img-rounded rounded"></a> 
	          </strong>
	      	</div>
	          
	      	<div class="hamburger"><div class="bar"></div></div> <p class="text-black itimovil pt-3" >MENU</p>
	          
	      	<!---- NavBar Movil -------->
	      	<div class="nav-list"  >
	        	<ul >
		          	<li > <!--- LOGO IMAGEN --->
		              	<a href="#" class="logonavs">
		                	<img src="{{asset('img/login/logos.jpeg')}}" alt="logo Company By Shoes & Moda" width="20" class="img-rounded rounded">
		              	</a>
		          	</li>
	              	
	              	@if (Auth::user()->perfil == 3)
		              	<li class=" menu-item-has-children sub-menu_nav" >
		                  	<a  class="navanc arrow dropdown-item resaltado anclinicila"  href="{{ url('/home') }}#noso" id="anclinicila"  >
		                          Admisión
		                  	</a> 
		              	</li>
		              	<li class=" menu-item-has-children sub-menu_nav" >
		                  	<a  class="navanc arrow dropdown-item resaltado anclinicila"  href="{{ url('/ingreso-qr') }}" id="anclinicila">
		                         Ingreso QR
		                  	</a> 
		              	</li>
		              	<li class=" menu-item-has-children sub-menu_nav ">
		            		<a  class="navanc arrow dropdown-item afirst"   href="#"    >
		                        Acciones
		            		</a>
			               	<ol class='mb-3'>
			                    <a  class='navamovil'  href="{{ url('/consulta-ingreso') }}">
				                    •	Consultas de Ingresos Socios
			                    </a> 
			                    <a  class='navamovil'  href="{{ url('/consulta-ingreso-invitado') }}">
				                    •	Consultas de invitado por dia
			                    </a> 
			               	</ol> 
		          		</li>
		              	<li class=" menu-item-has-children sub-menu_nav" >
		                  	<a  class="navanc arrow dropdown-item resaltado anclinicila"  href="{{ url('/logout') }}" id="anclinicila">
		                         salir
		                  	</a> 
		              	</li>
					@elseif (Auth::user()->perfil == 1)
					<li class=" menu-item-has-children sub-menu_nav" >
	                  	<a  class="navanc arrow dropdown-item resaltado anclinicila"  href="{{ url('/') }}#metod" id="anclinicila"  >
	                          Inicio
	                  	</a> 
	              	</li>
	          		<li class=" menu-item-has-children sub-menu_nav ">
	            		<a  class="navanc arrow dropdown-item afirst"   href="#"    >
	                        Registrar
	            		</a>
		               	<ol class='mb-3'>
		                    <a  class='navamovil'  href="{{ url('/usuarios') }}">
		                          usuarios
		                    </a> 
		                    <a  class='navamovil'  href="{{ url('/socios') }}">
		                          socios
		                    </a> 
		                    <a  class='navamovil'  href="{{ url('/invitados') }}">
		                          invitados
		                    </a> 
		               	</ol> 
	          		</li>
	          		<li class=" menu-item-has-children sub-menu_nav ">
	            		<a  class="navanc arrow dropdown-item afirst"   href="#"    >
	                        Reportes
	            		</a>
		               	<ol class='mb-3'>
		                    <a  class='navamovil'  href="{{ url('/reporte-socio') }}">
		                          Rpt. Socios
		                    </a> 
		                    <a  class='navamovil'  href="{{ url('/reporte-invit') }}">
		                          Rpt. Invitados
		                    </a> 
		                     
		               	</ol> 
	          		</li>
	          		<li class=" menu-item-has-children sub-menu_nav" >
	                  	<a  class="navanc arrow dropdown-item resaltado anclinicila"  href="{{ url('/logout') }}" id="anclinicila">
	                         salir
	                  	</a> 
	              	</li>
					
					@elseif (Auth::user()->perfil == 2)
					<li class=" menu-item-has-children sub-menu_nav" >
	                  	<a  class="navanc arrow dropdown-item resaltado anclinicila"  href="{{ url('home') }}#metod" id="anclinicila"  >
	                          Inicio
	                  	</a> 
	              	</li>
	          		<li class=" menu-item-has-children sub-menu_nav ">
	            		<a  class="navanc arrow dropdown-item afirst"  href="#"      >
	                        Ingreso hoy  
	            		</a>
		               	<ol class='mb-3' >
		                    <a  class='navamovil '  href="{{ url('/consulta-ingreso') }}" >
		                         Socios
		                    </a> 
		                    <a  class='navamovil '  href="{{ url('/consulta-ingreso-invitado') }}" >
		                         Invitados
		                    </a>
		               	</ol> 
	          		</li>

	              	<li class=" menu-item-has-children sub-menu_nav" >
	                  	<a  class="navanc arrow dropdown-item resaltado anclinicila"  href="{{ url('/logout') }}" id="anclinicila">
	                         salir
	                  	</a> 
	              	</li>
	              	@endif
	               
	          		 
	        	</ul>
	      	</div>


	      	<!---- NavBar DEscktop ----->
	      	<div class="col-sm-10 col-md-11  col-lg-10 nav-right"    >
		        <ul class=" header-nav menu_heders" >
		           
		            
		        	@if (Auth::user()->perfil == 2)
		        		<li class=" menu-item-has-children sub-menu">
			              	<a  class=" arrow dropdown-item"  href="{{ url('home') }}" id="anclinicila">
			                      Inicio
			              	</a> 
			            </li>
			          	<li class="menu-item-has-children sub-menu" >
			            	<a  class=" arrow dropdown-item" href="#" id="anclinicila"  >
			                        Ingreso hoy &nbsp;  <i class="fas fa-caret-down"></i>
			            	</a>
			             	<ul class='mega-menu menufil_1 ' >
			             	    
			                   <li class= 'sub-menu'  >
			                        <a  class= 'arrow dropdown-item ' href='{{ url('/consulta-ingreso') }}' >
			                           •	Socios
			                        </a>
			                   </li>
			                   <li class= 'sub-menu'  >
			                        <a  class= 'arrow dropdown-item ' href='{{ url('consulta-ingreso-invitado') }}' >
			                           •	Invitados
			                        </a>
			                   </li>     
			             	</ul>
			          	</li>
			          	<li class="menu-item-has-children sub-menu" >
			            	<a  class=" arrow dropdown-item" href="#" id="anclinicila"  >
			                        Reportes General&nbsp;  <i class="fas fa-caret-down"></i>
			            	</a>
			             	<ul class='mega-menu menufil_1 ' >
			             	    
			                   <li class= 'sub-menu'  >
			                        <a  class= 'arrow dropdown-item ' href='{{ url('/reporte-socio') }}' >
			                           •	Socios
			                        </a>
			                   </li>
			                   <li class= 'sub-menu'  >
			                        <a  class= 'arrow dropdown-item ' href='{{ url('reporte-invit') }}' >
			                           •	Invitados
			                        </a>
			                   </li>     
			             	</ul>
			          	</li>
		        	@endif
		            @if (Auth::user()->perfil == 3)
			            <li class=" menu-item-has-children sub-menu">
			              	<a class="arrow dropdown-item" href="{{ url('home') }}" id="anclinicila">
			                      Admisión
			              	</a> 
			            </li>
			            
			            <li class="menu-item-has-children sub-menu" >
			            	<a class="arrow dropdown-item" href="#"  id="anclinicila" >
			                       Acciones &nbsp;  <i class="fas fa-caret-down"></i></a> 
			            	<ul class='mega-menu menufil_1'>
			                   <li class= 'sub-menu'  >
			                        <a class='arrow dropdown-item' href='{{ url('/consulta-ingreso') }}' >
			                           •	Consultas de Ingresos de Socios
			                        </a>
			                   </li>
			                   <li class= 'sub-menu'  >
			                        <a  class='arrow dropdown-item' href='{{ url('/consulta-ingreso-invitado') }}' >
			                           •	Consultas de invitado por dia
			                        </a>
			                   </li>	                    
			            	</ul>
		          		</li>
		          		<li class=" menu-item-has-children sub-menu">
			              	<a class="arrow dropdown-item" href="{{url('ingreso-qr') }}" id="anclinicila">
			                      Ingreso QR
			              	</a> 
			            </li>
		          		 
		            @endif
		           
		             
		          	@if (Auth::user()->perfil == 1)
			          	<li class=" menu-item-has-children sub-menu">
			              	<a  class=" arrow dropdown-item" href="{{ url('home') }}" id="anclinicila">
			                      Inicio
			              	</a> 
			            </li>
			          	<li class="menu-item-has-children sub-menu" >
			            	<a  class="arrow dropdown-item" href="#" id="anclinicila" >
			                        Registrar &nbsp; <i class="fas fa-caret-down"></i>
			            	</a>
			             	<ul class='mega-menu menufil_1' >
			             	   <li class= 'sub-menu'  >
			                        <a class= 'arrow dropdown-item' href='{{ url('/usuarios') }}' >
			                           •	usuarios
			                        </a>
			                   </li>
			                   <li class= 'sub-menu'>
			                        <a class= 'arrow dropdown-item' href='{{ url('/socios') }}'>
			                           •	Socios
			                        </a>
			                   </li>
			                   <li class='sub-menu'>
			                        <a class= 'arrow dropdown-item' href='{{ url('invitados') }}'>
			                           •	Invitados
			                        </a>
			                   </li>     
			             	</ul>
			          	</li>
			          	<li class="menu-item-has-children sub-menu" >
			            	<a  class=" arrow dropdown-item" href="#" id="anclinicila">
			                        Reportes General&nbsp;  <i class="fas fa-caret-down"></i>
			            	</a>
			             	<ul class='mega-menu menufil_1 ' >
			             	   <li class= 'sub-menu'  >
			                        <a  class= 'arrow dropdown-item ' href='{{ url('/reporte-socio') }}' >
			                           •	Reporte Socios Ingresados
			                        </a>
			                   </li>
			                   <li class= 'sub-menu' >
			                        <a  class= 'arrow dropdown-item ' href='{{ url('/reporte-invit') }}' >
			                           •	Reporte Invitados Invitados
			                        </a>
			                   </li>
			             	</ul>
			          	</li>
		          	@endif

		            <li class="menu-item-has-children sub-menu" >
		              	<a  class=" arrow dropdown-item"  href="{{ url('logout') }}" id="anclinicila"     >
		                     Salir
		              	</a> 
		            </li>
		            <li class="menu-item-has-children sub-menu" >
		              	 
		            </li>

		             
		          	<li id="macuri" style="">
 
		          		<p class="pheaderus"> {{ getheaderperfil(Auth::user()->perfil) }} </p>
		          		<a href="#"   id="iconwhat" style="left: 0" >
		          			<div class="circle-wrapper">
						    <div class="success circle"></div>
						    <div class=" position-relative"  >

						    	@if(is_null(Auth::user()->avatar))
									<img src="{{url('img/iconos/user-avatar.png')}}" class=" rounded-circle imguserheader" width="100%"   >
								@else
									 
              					<img src="{{url('uploads_users/usu_'.Auth::user()->id.'/av_'.Auth::user()->avatar)}}" class="rounded-circle imguserheader"   >

 
								@endif
 						    </div>
						  </div>
						</a>
 		          	</li>
		        </ul>		       
	    	</div>
	          
	           

	    </div>
 	   
	</div>
</div>  
 


             