<?php
	require_once($_SESSION['raiz'].'/modules/sections/role-access-admin-editor.php');

	$sql = "SELECT COUNT(user) AS total FROM teachers";

	if ($result = $conexion -> query($sql))
	{
		if ($row = mysqli_fetch_array($result))
		{
			$tpages = ceil($row['total'] / $max);
		}
	}
	
	if (!empty($_POST['search']))
	{
		$_SESSION['user_id'] = array();
		$_SESSION['teacher_name'] = array();
		$_SESSION['teacher_curp'] = array();

		$i = 0;

		$sql = "SELECT * FROM teachers WHERE user LIKE '%".$_POST['search']."%' OR name LIKE '%".$_POST['search']."%' OR curp LIKE '%".$_POST['search']."%' ORDER BY name";

		if ($result = $conexion -> query($sql))
		{
			while ($row = mysqli_fetch_array($result))
			{
				$_SESSION['user_id'][$i] = $row['user'];
				$_SESSION['teacher_curp'][$i] = $row['curp'];
				$_SESSION['teacher_name'][$i] = $row['name'].' '.$row['surnames'];

				$i += 1;
			}
		}
		$_SESSION['total_users'] = count($_SESSION['user_id']);
	}
	else
	{
		$_SESSION['user_id'] = array();
		$_SESSION['teacher_name'] = array();
		$_SESSION['teacher_curp'] = array();

		$i = 0;

		$sql = "SELECT * FROM teachers ORDER BY name LIMIT $inicio, $max";

		if ($result = $conexion -> query($sql))
		{
			while ($row = mysqli_fetch_array($result))
			{
				$_SESSION['user_id'][$i] = $row['user'];
				$_SESSION['teacher_curp'][$i] = $row['curp'];
				$_SESSION['teacher_name'][$i] = $row['name'].' '.$row['surnames'];

				$i += 1;
			}
		}
		$_SESSION['total_users'] = count($_SESSION['user_id']);
	}
?>