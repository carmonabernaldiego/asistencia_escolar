<?php
	include_once '../security.php';
	include_once '../conexion.php';
	

	require_once($_SESSION['raiz'].'/modules/sections/role-access-admin.php');
	
	if (empty($_POST['txtuseridAdd']))
	{
		header('Location: /');
		exit();
	}
	
	if ($_POST['txtuseridAdd'] == ' ')
	{
		$_SESSION['msgbox_info'] = 0;
		$_SESSION['msgbox_error'] = 1;
		$_SESSION['text_msgbox_error'] = 'PROPORCIONAR UN USUARIO CORRECTO';
		header('Location: /modules/users');
		exit();
	}

	$directorioSubida = "../../images/users/";
	$max_file_size = "20480000";
	$extensionesValidas = array("jpg", "png", "jpeg");

	if(isset($_FILES['fileimage']))
	{
		$errores = array();
		$nombreArchivo = $_FILES['fileimage']['name'];
		$filesize = $_FILES['fileimage']['size'];
		$directorioTemp = $_FILES['fileimage']['tmp_name'];
		$tipoArchivo = $_FILES['fileimage']['type'];
		$arrayArchivo = pathinfo($nombreArchivo);
		$extension = $arrayArchivo['extension'];

		// Comprobamos la extensión del archivo
		if(!in_array($extension, $extensionesValidas)){
			$errores[] = "La extensión del archivo no es válida o no se ha subido ningún archivo";
		}

		// Comprobamos el tamaño del archivo
		if($filesize > $max_file_size){
			$errores[] = "La imagen debe de tener un tamaño inferior a 20 mb";
		}

		// Comprobamos y renombramos el nombre del archivo
		$nombreArchivo = $arrayArchivo['filename'];
		$nombreArchivo = preg_replace("/[^A-Z0-9._-]/i", "_", $nombreArchivo);
		$nombreArchivo = $_POST['txtuseridAdd'] . rand(1, 1000);

		// Desplazamos el archivo si no hay errores
		if(empty($errores))
		{
			$nombreCompleto = $directorioSubida.$nombreArchivo.".".$extension;
			$nombre_img = $nombreArchivo.".".$extension;
        	move_uploaded_file($directorioTemp, $nombreCompleto);
		}
		else
		{
			$nombre_img = 'user.png';
		}
	}
	else
	{
		$nombre_img = 'user.png';
	}

	$sql_insert = "INSERT INTO users(user, email, pass, permissions, image) VALUES('".$_POST['txtuseridAdd']."', '".$_POST['txtemailAdd']."', '".$_POST['txtuserpassAdd']."', '".$_POST['txtusertype']."', '".$nombre_img."')";

	if(mysqli_query($conexion, $sql_insert))
	{
		$_SESSION['msgbox_error'] = 0;
		$_SESSION['msgbox_info'] = 1;
		$_SESSION['text_msgbox_info'] = 'Registro cargado correctamente.';
	}
	else
	{
		$_SESSION['msgbox_info'] = 0;
		$_SESSION['msgbox_error'] = 1;
		$_SESSION['text_msgbox_error'] = 'Error al guardar datos en tabla.';
	}

	header ('Location: /modules/users');
?>