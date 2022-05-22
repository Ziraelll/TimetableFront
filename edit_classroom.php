<?php
require 'check_logined.php';
$title = 'Редактирование кабинетов';
require_once 'header.html';

	require 'db_connect.php';
	$db = connect();

	function get_housings($con)
	{
		 $result=mysqli_query($con,'SELECT * FROM housings');
		 return $result;
	}

	function classrooms_get_info($con)
	{	
		$result=mysqli_query($con,'SELECT * FROM classrooms LEFT JOIN housings ON classrooms.id_housing = housings.id_housing ORDER BY classrooms.id_classroom');

		return $result;
	}

	 function add_classroom($classroom,$id_housing,$con)
	{
		if ($classroom == '')
			return;
		$classroom=mysqli_real_escape_string($con,$classroom);
		$id_housing=mysqli_real_escape_string($con,$id_housing);
		$sql="INSERT INTO classrooms (classroom,id_housing) VALUES ('$classroom','$id_housing')";
		//8echo $sql;
		mysqli_query($con,$sql);
	}

	function alter_classroom($ID,$classroom,$id_housing,$con)
	{
		$sql="UPDATE `classrooms` SET `classroom` = '$classroom', `id_housing` = '$id_housing' WHERE `classrooms`.`id_classroom` = '$ID';";
		mysqli_query($con,$sql);	
	}

	if(isset($_POST['add_classroom']))
	{
		$classroom=trim($_POST['classroom']);
		$id_housing=trim($_POST['id_housing']);
		add_classroom($classroom,$id_housing,$db);
		
		header('Location: edit_classroom.php');
		exit();
	}
	else if (isset($_POST['alter_classroom']))
	{
		$ID=trim($_POST['id_classroom']);
		$classroom=trim($_POST['classroom']);
		$id_housing=trim($_POST['id_housing']);
		alter_classroom($ID,$classroom,$id_housing,$db);
	}

 	$result=classrooms_get_info($db);
 	$housings=get_housings($db);

	
	echo '<form class = "edit_form_g" method="post">';
	echo '<div class = "edit_block"><input  type="text" name="classroom" placeholder="Кабинет" autofocus />';

	echo '<select class = "edit_select" name="id_housing" id="id_housing">';
	echo '<option value="none" hidden>Выберите корпус</option>';
        
        if (mysqli_num_rows($id_housing) > 0){
		$hoz_arr["hoz"] = array();
		foreach($id_housing as $hoz)
		{	
			$record = array();
			$record['id_housing'] = $hoz['id_housing'];
			$record['housing'] = $hoz['housing'];
			array_push($hoz_arr['hoz'], $record);
			echo '<option value="'.$hoz['id_housing'] .'">'.$hoz['housing'] .'</option>';
		}	
	}

	if (mysqli_num_rows($housings) > 0)
		foreach($housings as $pos)
		{	
			echo '<option value="'.$pos['id_housing'] .'">'.$pos['short_housing'] .'</option>';
		}	

	echo '</select>';

	echo '<input type="hidden" value="add" name="add_classroom" />';
	echo '<button type="submit" value="Добавить">Добавить</button>';
	echo '</div></form>';
		
        
        
        echo '<div class="outer outer_30"><div class="inner">';

	if (mysqli_num_rows($result) > 0) {
		$i=1;
		foreach($result as $name)
		{		
					echo '<p><form class= "show_edit" method="post">';
		echo '<input type="text" name="classroom" placeholder="Кабинет" value="'. $name['classroom'] .'" />';
		// echo '<input type="text" name="id_housing" placeholder="Корпус" value="'. $name['id_housing'] .'" />';
                
                
                echo '<select name="id_housing" id="id_housing">';
        if($name['id_housing']=='') echo '<option value="none" hidden="">Выберите корпус </option>';
		if (mysqli_num_rows($housings) > 0)
			foreach($housings as $hoz)
			{	
				echo '<option value="'.$hoz['id_housing'] .'"';
				if ($name['id_housing']==$hoz['id_housing']) {
					echo ' selected >';
				} else {
					echo '>';
				}
				
				echo $hoz['short_housing'] .'</option>';
                                
              	                
			}
                echo '</select>';  
                
                // echo '&nbsp;&nbsp;'.$name['short_housing']." ".$name['long_housing']." ".$name['address'].'&nbsp;';
		echo '<button type="submit" value="Изменить">Изменить</button>';
		echo '<input type="hidden" value="'. $name['id_classroom'] .'" name="id_classroom" />';
		echo '<input type="hidden" value="alter" name="alter_classroom" />';
		echo '</form></p>';
		$i++;
		}
	}
        echo '</div></div>';
	echo '</body></html>';
	?>