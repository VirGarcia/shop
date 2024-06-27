<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Articulos</title>
</head>
<body>

	<?php 

		include "funciones.php";

	?>

	<h1>Lista de artículos</h1>
	
	<?php
		if (getPermisos() == 1) { //Para acceder a añadir, el admin tiene que haber habilitado estos permisos
			echo "<a href='formArticulos.php?Anadir'>Añadir producto </a>";
		}
	?>
	
	<?php
		if(!isset($_COOKIE['credenciales']) or ($_COOKIE['credenciales'] != "autorizado")) 
		//consultamos si no existe cookie credenciales 
		//o si existe pero es de una persona que no esté autorizada
		{
			echo "No tienes permiso para estar aquí.";
		}else{
			if (!isset($_GET['orden'])) {
					$orden = 'ProductID'; //si no existe el orden establecido se ordena por defecto por ID
			} else {
				$orden = $_GET['orden'];
			}
			pintaProductos($orden);
		}
	?>
	<br>
	
	<a href="index.php">Volver al inicio</a> 
		

</body>
</html>