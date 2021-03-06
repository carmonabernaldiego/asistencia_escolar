<?php
require_once($_SESSION['raiz'].'/modules/sections/role-access-admin.php');

$_SESSION['user_id'] = array();
$_SESSION['email'] = array();
$_SESSION['user_type'] = array();
$_SESSION['user_image'] = array();

$sql = "SELECT * FROM users WHERE user = '".$_POST['id']."'";

if ($result = $conexion -> query($sql))
{
	if ($row = mysqli_fetch_array($result))
	{
		$_SESSION['user_id'][0] = $row['user'];
		$_SESSION['email'][0] = $row['email'];
		$_SESSION['user_type'][0] = $row['permissions'];
		$_SESSION['user_image'][0] = $row['image'];
	}
}
echo'
<div class="form-data">
	<div class="head">
		<h1 class="titulo">Actualizar</h1>
    </div>
   <div class="body">
		<form name="form-update-users" action="update.php" enctype="multipart/form-data" method="POST">
			<div class="wrap">
				<div class="first">
					<label class="label">Usuario</label>
					<input style="display: none;" type="text" name="txtuseridUpdate" value="'.$_SESSION['user_id'][0].'"/>
					<input class="text" type="text" name="txt" value="'.$_SESSION['user_id'][0].'" disabled/>
					<label class="label">Email</label>
					<input class="text" type="email" name="txtemailUpdate" value="'.$_SESSION['email'][0].'" autofocus/>
					<label class="label">Contraseña</label>
					<input class="text" type="password" name="txtuserpassUpdate" value="Password1234//*" disabled/>
					<label class="label">Permisos</label>
					<select class="select" name="txtusertype">
					';
						if ($_SESSION['user_type'][0] == 'admin')
						{
							echo
							'
								<option value="admin">Administrador</option>
								<option value="student">Alumno</option>
								<option value="teacher">Docente</option>
								<option value="editor">Editor</option>	
							';
						}
						elseif ($_SESSION['user_type'][0] == 'alumno')
						{
							echo
							'
								<option value="student">Alumno</option>
								<option value="admin">Administrador</option>
								<option value="teacher">Docente</option>
								<option value="editor">Editor</option>	
							';
						}
						elseif ($_SESSION['user_type'][0] == 'docente')
						{
							echo
							'
								<option value="teacher">Docente</option>
								<option value="admin">Administrador</option>
								<option value="student">Alumno</option>
								<option value="editor">Editor</option>	
							';
						}
						elseif ($_SESSION['user_type'][0] == 'editor')
						{
							echo
							'
								<option value="editor">Editor</option>
								<option value="admin">Administrador</option>
								<option value="student">Alumno</option>
								<option value="teacher">Docente</option>
							';
						}
					echo
					'
					</select>
				</div>
				<div class="last imageuser">
					<label class="label" style="text-align:center;">Imagen</label>
					<img id="userimage" class="user-image" src="'.'/images/users/'.$_SESSION['user_image'][0].'" />
					<label class="file" for="fileimage">Abrir Imagen</label>
					<input id="fileimage" style="display: none;" type="file" name="fileimage" accept=".jpg, .jpeg, .png" />
				</div>
			</div>
			<button class="btn icon" type="submit">save</button>
</div>
        </form>
    </div>
</div>
';
echo '<div class="content-aside">';
	include_once "../sections/options-disabled.php";
echo '</div>';
?>
<script>
document.getElementById("fileimage").onchange = function(e) {
    // Creamos el objeto de la clase FileReader
    let reader = new FileReader();

    // Leemos el archivo subido y se lo pasamos a nuestro fileReader
    reader.readAsDataURL(e.target.files[0]);

    // Le decimos que cuando este listo ejecute el código interno
    reader.onload = function() {
        image = document.getElementById('userimage');

        image.src = reader.result;
    };
}
</script>