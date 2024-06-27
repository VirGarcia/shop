<!DOCTYPE html> 
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index.php</title>
</head>
<body>

	<?php
	
		include "consultas.php"; //son las consultas para localizar en la tabla setup 
		//El formulario se envia por POST, la información va oculta, no va en la URL.

	?>
	<form action="index.php" method="POST"> 
		<p><label for="usuario">Usuario: </label><input type="text" name="usuario"></p>
		<p><label for="correo">Correo: </label><input type="email" name="correo"></p>
		<p><input type="submit" name="Enviar"></p>
	</form>
	
	<?php
	
		if (isset($_POST['Enviar'])) { //Comprobamos si se ha hecho un envío de info y en tal caso de que sí, se coge el nomb y el correo
			$nombre = $_POST['usuario'];
			$correo = $_POST['correo'];
			$tipoUsuario = tipoUsuario($nombre, $correo);
			setcookie("credenciales", $tipoUsuario, time()+600); //Dependiendo del usuario que haya entrado, se irá a usuarios o articulos.
			switch ($tipoUsuario) {
				case 'superadmin':
					echo "Bienvenido $nombre. Pulsa <a href='usuarios.php'>AQUÍ</a> para entrar al panel de usuarios.";
					break;
				case 'autorizado':
					echo "Bienvenido $nombre. Pulsa <a href='articulos.php'>AQUÍ</a> para entrar al panel de artículos.";
					break;
				case 'registrado':
					echo "Bienvenido $nombre. No tienes permisos para continuar.";
					break;
				default:
					echo "El usuario no está registrado en el sistema.";
					break;
			}
		}
	
			
	
	?>
	
</body>
</html>