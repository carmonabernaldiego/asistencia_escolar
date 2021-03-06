<?php
	require_once($_SESSION['raiz'].'/modules/sections/role-access-admin-editor.php');

	if(isset($_POST['txtgroup']))
	{
		$sql = "SELECT * FROM groups WHERE id_group = '".$_POST['txtgroup']."' AND school_period = '".$_POST['txtgroupschoolperiod']."'";

		if($result = $conexion -> query($sql))
		{
			while ($row = mysqli_fetch_array($result))
			{
				$_SESSION['id_group'] = $row['id_group'];
				$_SESSION['school_period_group'] = $row['school_period'];
				$_SESSION['name_group'] = $row['name'];
				$_SESSION['semester_group'] = $row['semester'];
				$_SESSION['get_subjects'] = $row['subjects'];
			}
		}
	}

	//Cargamos las asignaturas
	if(isset($_SESSION['school_period_group']) != '')
	{
		$array_subjects = array();
		$_SESSION['get_subjects'] = trim($_SESSION['get_subjects'], ',');

		$array_subjects = explode( ',', $_SESSION['get_subjects']);

		$_SESSION['subjects_group'] = array();
		$_SESSION['subject_name_group'] = array();

		$i = 0;

		foreach($array_subjects as $row)
		{
			if($array_subjects[$i] != '')
			{
				$sql = "SELECT * FROM subjects WHERE subject = '".$array_subjects[$i]."' AND school_period = '".$_SESSION['school_period_group']."'";
			
				if($result = $conexion -> query($sql))
				{
					while ($row = mysqli_fetch_array($result))
					{
						$_SESSION['subjects_group'][$i] = $row['subject'];
						$_SESSION['subject_name_group'][$i] = $row['name'];
						$_SESSION['checked_subject'][$i] = 'checked';
					}
				}
			}
			$i += 1;
		}
	}

	//Cargamos datos de estudiantes
	if(isset($_SESSION['school_period_group']) != '')
	{

		$_SESSION['get_students'] = '';

		$_SESSION['users_student_group'] = array();
		$_SESSION['name_student_group'] = array();

		$i = 0;

		$sql = "SELECT * FROM groups_students WHERE id_group = '".$_SESSION['id_group']."' AND school_period = '".$_SESSION['school_period']."'";

		if ($result = $conexion -> query($sql))
		{
			while ($row = mysqli_fetch_array($result))
			{
				$_SESSION['get_students'] .= $row['user_student'].',';

				$_SESSION['users_student_group'][$i] = $row['user_student'];
				$_SESSION['checked_student'][$i] = 'checked';

				$sql = "SELECT * FROM students WHERE user = '".$_SESSION['users_student_group'][$i]."' AND school_period = '".$_SESSION['school_period']."'";

				if($result2 = $conexion -> query($sql))
				{
					while($row2 = mysqli_fetch_array($result2))
					{
						$_SESSION['name_student_group'][$i] = $row2['name'].' '.$row2['surnames'];
					}
				}

				$i += 1;
			}
		}
	}
?>
<div class="form-data">
    <div class="head">
        <h1 class="titulo">Consultar</h1>
    </div>
    <div class="body">
        <form name="form-add-groups" action="#" method="POST">
            <div class="wrap">
                <div class="first">
                    <label class="label">Grupo</label>
                    <input class="text" type="text" name="txtgroup"
                        value="<?php if(!empty($_SESSION['id_group'])){ echo $_SESSION['id_group']; } ?>" maxlength="20"
                        autofocus required disabled />
                    <label class="label">Nombre</label>
                    <input class="text" type="text" name="txtgroupname"
                        value="<?php if(!empty($_SESSION['name_group'])){ echo $_SESSION['name_group']; } ?>"
                        maxlength="100" required disabled />
                </div>
                <div class="last">
                    <label class="label">Semestre</label>
                    <input class="text" type="number" name="txtgroupsemester"
                        value="<?php if(!empty($_SESSION['semester_group'])){ echo $_SESSION['semester_group']; } ?>"
                        maxlength="2" min="1" max="12" list="defaultsemestres" required disabled />
                    <datalist id="defaultsemestres">
                        <?php
						for($i = 1; $i <= 12; $i ++)
						{
							echo
							'
								<option value="'.$i.'">
							';
						}
					?>
                    </datalist>
                    <label class="label">Periodo Escolar</label>
                    <select class="select" name="selectgroupschoolperiod" disabled>
                        <option value="<?php echo $_SESSION['school_period']; ?>">
                            <?php echo $_SESSION['school_period']; ?></option>
                    </select>
                </div>
            </div>
            <?php
				echo
				'
					</br>
					<table class="consult">
						<tr>
							<th class="center" colspan="2">Asignaturas</th>
						</tr>
						';
							$i = 0;
						
								foreach($_SESSION['subjects_group'] as $row)
								{ 
									echo'
										<tr>
											<td style="width: 40px;"><input class="cbox-subject" id="cbox-subject'.$i.'" type="checkbox" name="check-subject-group'.$i.'" value="'.$_SESSION['subjects_group'][$i].'"'.' '.$_SESSION['checked_subject'][$i].' disabled></td>
											<td><label for="cbox-subject'.$i.'">'.$_SESSION['subject_name_group'][$i].'</label></td>
										</tr>
									';
					
									$i += 1;
								}
						echo '
					</table>
					<table class="consult">
						<tr>
							<th class="center" colspan="2">Alumnos</th>
						</tr>
				';
							$i = 0;

							foreach($_SESSION['users_student_group'] as $row)
							{ 
								echo'
									<tr>
										<td style="width: 40px;"><input id="cbox-student'.$i.'" class="cbox-student" type="checkbox" name="check-student-group'.$i.'" value="'.$_SESSION["users_student_group"][$i].'"'.' '.$_SESSION['checked_student'][$i].' disabled></td>
										<td><label for="cbox-student'.$i.'">'.$_SESSION['name_student_group'][$i].'</label></td>
									</tr>
									';
									
								$i += 1;
							}
					echo'
					</table>
				';
			?>
            <button class="btn icon" name="btn" value="form_default" type="submit">save</button>
        </form>
    </div>
</div>
<div class="content-aside">
<?php
	include_once "../sections/options-disabled.php";
?>
</div>