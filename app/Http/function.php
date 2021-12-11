<?php 

	 
	function getperfil($data){

		if ($data == 0) {
			echo "<h2>Sin acceso </h2>	 ";
		}else if ($data == 1) {
			echo "<h4 class='btn btn-success btn-sm'>Administrador</h4>";
		}else if ($data == 2) {
			echo "<h4 class='btn btn-primary btn-sm'>Inspector</h4>";
		}else if ($data == 3) {
			echo "<h4 class='btn btn-secondary  btn-sm'>Recepcionista</h4>";
		}
		 
	}


	function getheaderperfil($data){
		if ($data == 1) {
			echo "Administrador";
		}else if ($data == 2) {
			echo "Inspector";
		}else if ($data == 3) {
			echo "Recepcionista";
		}
	}
	function getperfilsocio($data){

		if ($data == 0) {
			echo "<h2>Sin acceso </h2>	 ";
		}else if ($data == 1) {
			echo "<h4 class='btn btn-success btn-sm'>&nbsp;&nbsp; Titular&nbsp;&nbsp;</h4>";
		}else if ($data == 2) {
			echo "<h4 class='btn btn-primary btn-sm'>Conyuge</h4>";
		}else if ($data == 3) {
			echo "<h4 class='btn btn-secondary  btn-sm'>&nbsp;Familiar&nbsp;</h4>";
		}
		 
	}

	//--->adulto y niño Categoria -clase 
	function getcategoria($data){

		if ($data == 1) {
			echo "<h4 class='btn btn-success btn-sm'>Titular</h4>";
		}else if ($data == 2) {
			echo "<h4 class='btn btn-primary btn-sm'>Conyuge</h4>";
		}else if ($data == 3) {
			echo "<h4 class='btn btn-secondary  btn-sm'>Familiar</h4>";
		}
		 
	}

	// funcion de asistencia de socio
	function asistencia($data){
		if ($data == 1) {
			echo "<h4 class='btn btn-success btn-sm'>Si</h4>";
		}else{
			echo "<h4 class='btn btn-danger btn-sm'>No</h4>";
		}
	}
	 
	// funcion de especificar Adulto o niñostext-warning
	function adultoni($data){
		if ($data == 1) {
			echo "<h4 class='btn btn-secondary  btn-sm'>Adulto</h4>";
		}else{
			echo "<h4 class='btn btn-warning  btn-sm'>Niño</h4>";
		}
	}

 ?>
	
