<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<title>Usuarios</title>
</head>
<body>

	<?php 

		include "funciones.php"; //funciones sirve de apoyo a la vista.
		// Pregunto, si no existe la cookie credenciales o si existe la cookie pero entra alguien que no es superadmin, decimos que no tiene permiso.

		if (!isset($_COOKIE['credenciales']) or ($_COOKIE['credenciales'] != "superadmin")) {
			echo "No tienes permiso para estar aquí.";
		} else {
			if (isset($_GET['Cambiar'])) { // Se han entrado con los permisos admin, si no no se podria hacer
				cambiarPermisos(); //Se cambian los permisos en la tabla user de la base de datos, columna enabled
			}
	?>
			<p>Los permisos actuales están a <span><?php echo getPermisos(); ?> </span></p>
			<form action="usuarios.php" action="GET">
				<p><input type="submit" name="Cambiar" value="Cambiar permisos"></p>
			</form>

			<?php

			pintaTablaUsuarios();

		}


	?>
	<a href="index.php">Volver al inicio</a> 

</body>
</html>