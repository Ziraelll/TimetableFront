<?php
require 'check_logined.php';
$title = 'Редактирование дожностей';
require_once 'header.html';

require 'db_connect.php';
$db = connect();


function get_positions($con)
{
	$result = mysqli_query($con, 'SELECT * FROM positions') or die(mysqli_error());
	return $result;
}

function add_position($position, $con)
{
	if ($position == '')
		return;
	$position = mysqli_real_escape_string($con, $position);
	$sql = "INSERT INTO positions (position) VALUES ('$position')";
	mysqli_query($con, $sql);
}

function alter_position($ID, $position, $con)
{
	$sql = "UPDATE `positions` SET `position` = '$position' WHERE `id_position` = '$ID';";
	mysqli_query($con, $sql) or die(mysqli_error());
}

if (isset($_POST['add_position'])) {
	$position = trim($_POST['position']);
	add_position($position, $db);

	header('Location: edit_position.php');
	exit();
} else if (isset($_POST['alter_position'])) {
	$ID = trim($_POST['id_position']);
	$position = trim($_POST['position']);
	alter_position($ID, $position, $db);
}

$pos = get_positions($db);


echo '<form class = "edit_form_g edit_form_30" method="post">';
echo '<div class = "edit_block"><input  type="text" name="position" placeholder="Должность" autofocus />';
echo '<input type="hidden" value="add" name="add_position" />';
echo '<button type="submit" value="Добавить">Добавить</button>';
echo '</div></form>';

echo '<div class="outer outer_30 "><div class="inner">';
if (mysqli_num_rows($pos) > 0) {
	$i = 1;
	foreach ($pos as $position) {
		echo '<p><form class=" show_edit" method="post">';
		echo '<input type="text" name="position" placeholder="Должность" value="' . $position['position'] . '" />';

		echo '</select>';

		echo '<button type="submit" value="Изменить">Изменить</button>';
		echo '<input type="hidden" value="' . $position['id_position'] . '" name="id_position" />';
		echo '<input type="hidden" value="alter" name="alter_position" />';
		echo '</form></p>';
		$i++;
	}
}
echo '</div></div>';
echo '</body></html>';
