<?php
$title = 'Редактирование групп';
require_once 'header.html';
require 'check_logined.php';
require 'db_connect.php';
echo'<script type="text/javascript" src="js/editGroup.js"></script>';

$db = connect();

function get_department($con)
{
	$result = mysqli_query($con, 'SELECT * FROM department') or die(mysqli_error($con));
	return $result;
}

function get_groups($con)
{
	$result = mysqli_query($con, 'SELECT * FROM groups');
	return $result;
}

function add_group($group, $department, $con)
{
	if ($group == '')
		return;
	$group = mysqli_real_escape_string($con, $group);
	$department = mysqli_real_escape_string($con, $department);
	$sql = "INSERT INTO groups (group_name, department) VALUES ('$group','$department')";
	mysqli_query($con, $sql);
}

function alter_group($ID, $group, $department, $con)
{
	$sql = "UPDATE `groups` SET `group_name` = '$group' , `department` = '$department'
                WHERE `groups`.`id_group` = '$ID';";
	mysqli_query($con, $sql);
}

if (isset($_POST['add_group'])) {
	$group = trim($_POST['group_name']);
	$department = trim($_POST['department_id']);
	add_group($group, $department, $db);

	header('Location: edit_group.php');
	exit();
} else if (isset($_POST['alter_group'])) {
	$ID = trim($_POST['id_group']);
	$group = trim($_POST['group_name']);
	$department = trim($_POST['department_id']);
	alter_group($ID, $group, $department, $db);
}

$group = get_groups($db);
$department = get_department($db);




echo '<form class = "edit_form_g"  method="post">';
echo '<div class = "edit_block"><input  type="text" name="group_name" placeholder="Группа" autofocus /><select class = "edit_select" name="department_id" id="department_id">';

echo '<option value="none" hidden="">Выберите подразделение</option>';
if (mysqli_num_rows($department) > 0)
	foreach ($department as $dep) {
		echo '<option value="' . $dep['department_id'] . '"';
		echo '>';

		echo $dep['department_name'] . '</option>';
	}
echo '</select>';

echo '<input type="hidden" value="add" name="add_group" />';
echo '<button class = "edit_button" type="submit" value="Добавить" style="">Добавить </button>';
echo '</div></form>';




echo '<div class="outer outer_40"><div class="inner">';
echo '<button type="submit" onClick = "postTable()"  value="Изменить">Сохранить</button>';

if (mysqli_num_rows($group) > 0) {
	$i = 1;
	foreach ($group as $name) {
        echo '<tr><td><input  type="text" name="group_name" placeholder="Группа" value="' . $name['group_name'] . '" /></td>';
        echo '<td>';
        echo '<select name="department_id">';
        if ($name['department'] == '0') echo '<option value="none" hidden="">Выберите подразделение</option>';
        if (mysqli_num_rows($department) > 0)
            foreach ($department as $dep) {
                echo '<option value="' . $dep['department_id'] . '"';
                if ($name['department'] == $dep['department_id']) {
                    echo ' selected >';
                } else {
                    echo '>';
                }

                echo $dep['department_name'] . '</option>';
            }
        echo '</select>';
        echo '</td></tr>';

        echo '<input type="hidden" value="' . $name['id_group'] . '" name="id_group" />';
        echo '<input type="hidden" value="alter" name="alter_group"/>';
		$i++;
	}
}
echo '</body></html>';
