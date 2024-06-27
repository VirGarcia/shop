<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Formulario de artículos</title>
</head>
<body>

	<?php 

		include "funciones.php"; //se pasa por este formulario siempre para editar borrar o añadir. El envio de la info es oculto (post)
	
	?>
	
	<?php                  
		if (!isset($_COOKIE['credenciales']) or ($_COOKIE['credenciales'] != "autorizado")) {
		echo "No tienes permiso para estar aquí."; //esto sale cuando se intenta entrar sin estar autorizado 
		} else {
			if (isset($_GET['Editar'])) {
				$datosProducto = mysqli_fetch_array(getProducto($_GET['Editar']));
			} else if (isset($_GET['Borrar'])) {
				$datosProducto = mysqli_fetch_array(getProducto($_GET['Borrar']));
			} else {
				$datosProducto = ["ProductID" => "", //tabla vacia por defecto que se imprime 
									"Name" => "",
									"Cost" => 0,
									"Price" => 0,
									"categoria" => "PANTALÓN"];
			}
		}
	?> 
	<form action="formArticulos.php" action="POST"> 
		<p><label>ID: </label><input type="text" value="<?php echo $datosProducto['ProductID']; ?>" disabled></p>
		<input type="hidden" name="id" value="<?php echo $datosProducto['ProductID']; ?>"></p>
		<p><label>Nombre: </label><input type="text" name="nombre" value="<?php echo $datosProducto['Name']; ?>"></p>
		<p><label>Coste: </label><input type="number" name="coste" value="<?php echo $datosProducto['Cost']; ?>"></p>
		<p><label>Precio: </label><input type="number" name="precio" value="<?php echo $datosProducto['Price']; ?>"></p>
		<p><label>Categoría: </label><select name="categoria">
	
			<?php pintaCategorias($datosProducto['CategoryID']); ?>
		</select></p>

	
	<?php
		if (isset($_GET['Editar'])) { //si existe editar aparece el botón
		echo "<input type='submit' name='Accion' value='Editar'>";
		} else if (isset($_GET['Borrar'])) {
		echo "<input type='submit' name='Accion' value='Borrar'>";
		} else {
			echo "<input type='submit' name='Accion' value='Añadir'>";
		}
	?>
	
	<?php
		if(isset($_GET['Accion'])) { //una vez que existe la acción mandada por el usuario hay que verificar que caso es y usamos un switch
			switch ($_GET['Accion']) {
				case 'Editar':
					if (editarProducto($_GET['id'], $_GET['nombre'], $_GET['coste'], $_GET['precio'], $_GET['categoria'])) {
						echo "Se ha editado el producto";
					} else {
						echo "No se ha editado el producto";
					}
					break;
				case 'Borrar':
					if (borrarProducto($_GET['id'])) {
					echo "Se ha borrado el producto";
				} else {
					echo "No se ha borrado el producto";
				}
				break;
				case 'Añadir':
					if(anadirProducto($_GET['nombre'], $_GET['coste'], $_GET['precio'], $_GET['categoria'])) {
					echo "Se ha añadido el producto";
				} else {
					echo "No se ha añadido el producto";
				}
				break;
			}
		}
					
	?> 
	<a href="articulos.php">Volver</a> 
	</form>
</body>
</html>