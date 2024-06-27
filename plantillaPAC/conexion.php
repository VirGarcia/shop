<?php 

	function crearConexion() {
		// Cambiar en el caso en que se monte la base de datos en otro lugar
		$host = "localhost";
		$user = "***********";
		$pass = "***********";
		$baseDatos = "pac3_daw";

		// establecemos la conexión con la base de datos
		$DB = mysqli_connect($host, $user, $pass, $baseDatos);
		
		return $DB;
		
	}


	function cerrarConexion($DB) {
		mysqli_close($DB);
	}


?>
