<?php
$title = 'Редактирование подразделения';

require 'check_logined.php';
require_once 'header.html';
require 'db_connect.php';
$db = connect();
echo'<script type="text/javascript" src="js/editDepartment.js"></script>';

	function get_department($con)
	{
		 $result=mysqli_query($con,'SELECT * FROM department') or die(mysqli_error());
		 return $result;
	}

	function add_department($department,$con)
	{
		if ($department == '')
			return;
		$department=mysqli_real_escape_string($con,$department);
		$sql="INSERT INTO department (department_name) VALUES ('$department')";
		mysqli_query($con,$sql);
	}

	function alter_department($ID,$department,$con)
	{
		$sql="UPDATE `department` SET `department_name` = '$department' WHERE `department_id` = '$ID';";
		mysqli_query($con,$sql) or die(mysqli_error());	
	}

	if(isset($_POST['add_department']))
	{
		$department=trim($_POST['department_name']);
		add_department($department,$db);
		
		header('Location: edit_department.php');
		exit();
	}
	else if (isset($_POST['alter_department']))
	{
		$ID=trim($_POST['department_id']);
		$department=trim($_POST['department_name']);
                alter_department($ID,$department,$db);
	}

 	$dep=get_department($db);


	echo '<form class = "edit_form_g edit_form_30" method="post">';
	echo '<div class ="edit_block"><input type="text" name="department_name"  placeholder="Подразделение" autofocus />';

	echo '<input type="hidden" value="add" name="add_department" />';
	echo '<button type="submit" value="Добавить">Добавить</button>';
	echo '</div></form>';
       

    echo '<div class="outer outer_30"><div>';
if (mysqli_num_rows($dep) > 0) {
    $i=1;
    echo '<table id="department">';
    foreach($dep as $department)
    {

 echo '<tr><td><input type="text" name="department_name"  placeholder="Подразделение" value="'. $department['department_name'] .'" /></td></tr>';

    echo '<input type="hidden" value="'. $department['department_id'] .'" name="department_id" />';
    echo '<input type="hidden" value="alter" name="alter_department" />';

    $i++;
    }
    echo '</table>';
}

echo '</body></html>';
