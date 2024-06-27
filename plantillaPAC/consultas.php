<?php 

	include "conexion.php";

	function tipoUsuario($nombre, $correo){ //recogemos la info que ha introducido el usuario para consultar en la base de datos que permisos tiene
		$DB = crearConexion();

		if (esSuperadmin($nombre, $correo)) {
			return "superadmin";
		} else {
			$sql = "SELECT FullName, Email, Enabled FROM user WHERE FullName = '$nombre' and Email = '$correo'";
			$result = mysqli_query($DB, $sql); //en result aparece el contenido de la consulta

			cerrarConexion($DB); //siempre que se abre conexión se cierra para no saturar la base de datos por cada consulta se establece la conexión

			if ($datos = mysqli_fetch_assoc($result)) {
				if ($datos['Enabled'] == 0){ //usuario registrado pero no está habilitado para hacer acciones en los articulos
					return "registrado";

				} else if ($datos['Enabled'] == 1){ //usuario autorizado y tiene permisos a 1 por lo que puede editar borrar, etc
					return "autorizado";
				}
			} else {
				return "no registrado"; //esto aparece al introducir un usuario no registrado o ponerle mal las credenciales.
			}
		}
	}


	function esSuperadmin($nombre, $correo) {
		$DB = crearConexion();

		$sql ="SELECT user.UserID FROM user INNER JOIN setup ON user.UserID = setup.SuperAdmin WHERE user.FullName = '$nombre' and user.Email = '$correo'";
		$result = mysqli_query($DB, $sql); //se ha hecho un inner join para saber que el superadmin en estos momentos corresponde con el número 3

		if($datos = mysqli_fetch_array($result)) {
			return true;
		} else {
			return false;
		
		}
	}


	function getPermisos() {
		$DB = crearConexion();

		$sql = "SELECT Autenticación FROM setup"; //muestra la autenticación de la tabla setup
		
		$result = mysqli_fetch_assoc(mysqli_query($DB, $sql));
		
		cerrarConexion($DB);
		
		return $result['Autenticación'];

	}


	function cambiarPermisos() { //el admin cambia los permisos de 0 a 1 para que los vendedores (autorizados) hagan modificaciones de las prendas de ropa.
		$permisos = getPermisos();
		
		$DB = crearConexion();
		
		if (($permisos == 1)) {
			$sql = "UPDATE setup SET Autenticación = 0";
		} else if (($permisos == 0)) {
			$sql = "UPDATE setup SET Autenticación = 1";
		}
		$result = mysqli_query($DB, $sql);
		cerrarConexion($DB);
		
	}


	function getCategorias() { 
		$DB = crearConexion();
		$sql = "SELECT CategoryID, Name FROM category"; //se relaciona que el CategoryID pertenece a un tipo de ropa, ejemplo el 1 es PANTALÓN.
		$result = mysqli_query($DB, $sql);
		return $result;
	}


	function getListaUsuarios() {
		$DB = crearConexion();
		$sql = "SELECT FullName, Email, Enabled FROM user"; //De la tabla usuario obtiene los datos.
		$result = mysqli_query($DB, $sql);
		cerrarConexion($DB);
		return $result;
		
	}


	function getProducto($ID) {
		$DB = crearConexion();
		$sql = "SELECT * FROM product WHERE ProductID = $ID"; //obtiene los productos por ID
		$result = mysqli_query($DB, $sql);
		cerrarConexion($DB);
		return $result;
	}


	function getProductos($orden) {
		$DB = crearConexion();
		
		$sql = "SELECT product.ProductID, product.Name, product.Cost, product.Price, category.Name as Categoria FROM product INNER JOIN category WHERE product.CategoryID = category.CategoryID ORDER BY $orden"; //según el orden establecido, se ordenan los productos
		$result= mysqli_query($DB, $sql);
		cerrarConexion($DB);
		return $result;
	
		
	}
	
	



	function anadirProducto($nombre, $coste, $precio, $categoria) { //añadimos el producto cuando accede un usuario autorizado y con permisos a 1
		$DB = crearConexion();
		$sql = "INSERT INTO product (Name, Cost, Price, CategoryID) VALUES ('$nombre', $coste, $precio, $categoria)";
		$result = mysqli_query($DB, $sql);
		cerrarConexion($DB);
		return $result; //devuelve producto añadido.
	}


	function borrarProducto($id) { //elimina producto por id
		$DB = crearConexion();
		
		$sql = "DELETE FROM product WHERE ProductID = $id";
		$result= mysqli_query($DB, $sql);
		
		cerrarConexion($DB);
		return $result;
	}


	function editarProducto($id, $nombre, $coste, $precio, $categoria) { //edita productos por id
	$DB = crearConexion();
	
	$sql = "UPDATE product SET Name = '$nombre', Cost = $coste, Price = $precio, CategoryID = $categoria WHERE ProductID = $id";
	$result = mysqli_query($DB, $sql);
	
	cerrarConexion($DB);
	
	return $result;
	}
	

?>