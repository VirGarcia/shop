<?php 

	include "consultas.php";


	function pintaCategorias($defecto) { //PANTALON
		$categorias = getCategorias();
		
		while($fila = mysqli_fetch_assoc($categorias)) {
			if ($fila['CategoryID'] == $defecto) {
				echo "<option value='" . $fila['CategoryID'] . "'selected>" . $fila['Name'] . "</option>";
			} else {
				echo "<option value='" .$fila['CategoryID'] . "'>" . $fila['Name'] . "</option>";
			}
		}
		
	
	}
	

	function pintaTablaUsuarios(){ //Sirve para imprimir la tabla de los usuarios indicando si son autorizados o no, es lo que se ve cuando accede Jack Blue
		
		$listaUsuarios = getListaUsuarios();
	
		echo "<table>\n 
				<tr>\n 
					<th>Nombre</th>\n 
					<th>Email</th>\n 
					<th>Autorizado</th>\n 
				</tr>\n";
		while ($fila = mysqli_fetch_assoc($listaUsuarios)) {
			echo "<tr>\n 
					<td>" . $fila['FullName'] . "</td>\n 
					<td>" . $fila['Email'] . "</td>\n";
					
			if ($fila['Enabled'] == 1) { //los usuarios autorizados salen coloreados de rojo.
				echo "<td class='rojo'>" . $fila['Enabled'] . "</td>
				\n";
			} else {
				echo "<td>" . $fila['Enabled'] . "</td>\n";
			}
		}
			
	}

		
	function pintaProductos($orden) { //Hace que se imprima el listado de los productos y que los podamos ordenar al pinchar en los enlaces de la cabecera.
		$productos = getProductos($orden);
		
		echo "<table>\n 
			<tr>\n 
				<th><a href='articulos.php?orden=ProductID'>ID</a></th>\n 
				<th><a href='articulos.php?orden=Name'>Nombre</a></th>\n 
				<th><a href='articulos.php?orden=Cost'>Coste</a></th>\n 
				<th><a href='articulos.php?orden=Price'>Precio</a></th>\n 
				<th><a href='articulos.php?orden=Categoria'>Categoría</a></th>\n 
				<th>Acciones</th>\n 
			</tr>\n";
		
		while ($fila = mysqli_fetch_assoc($productos)) {
			echo "<tr>\n 
				<td>" . $fila['ProductID'] . "</td>\n 
				<td>" . $fila['Name'] . "</td>\n
				<td>" . $fila['Cost'] . "</td>\n
				<td>" . $fila['Price'] . "</td>\n
				<td>" . $fila['Categoria'] . "</td>\n";
		
			if (getPermisos()==1) { //sucede mientras se hayan habilitado los permisos tabla user (se hace con cuenta de Admin)
				echo "<td><a href='formArticulos.php?Editar=" . $fila['ProductID'] . "'>Editar</a>-<a href='formArticulos.php?Borrar=" . $fila['ProductID'] . "'>Borrar</a></td>\n </tr>\n ";
			} 
			else {
				echo "<td>Sin Acciones</td>\n </tr>\n "; 
				//Esto pasa si entra un usuario registrado y autorizado, pero sin haber cambiado el admin los permisos de 0 a 1 en la base de datos
			}
		}
		echo "</table>";
		
				
				
	}

?>