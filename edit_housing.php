<?php
require 'check_logined.php';
$title = 'Редактирование корпусов';
require_once 'header.html';
echo'<script type="text/javascript" src="js/editHousing.js"></script>';
require 'db_connect.php';
$db = connect();


	function get_housings($con)
	{
		 $result=mysqli_query($con,'SELECT * FROM housings') or die(mysqli_error());
		 return $result;
	}

	function add_housing($short_housing,$long_housing,$address,$con)
	{
		if ($short_housing == '')
			return;
		$short_housing=mysqli_real_escape_string($con,$short_housing);
                $long_housing=mysqli_real_escape_string($con,$long_housing);
                $address=mysqli_real_escape_string($con,$address);
		$sql="INSERT INTO housings (short_housing,long_housing,address) VALUES ('$short_housing','$long_housing','$address')";
		mysqli_query($con,$sql);
	}

	function alter_housing($ID,$short_housing,$long_housing,$address,$con)
	{
		$sql="UPDATE `housings` SET `short_housing` = '$short_housing', `long_housing` = '$long_housing', `address` = '$address'  WHERE `id_housing` = '$ID';";
		mysqli_query($con,$sql) or die(mysqli_error($con));	
	}

if(isset($_POST['add_housing']))
{
    $short_housing=trim($_POST['short_housing']);
            $long_housing=trim($_POST['long_housing']);
            $address=trim($_POST['address']);
    add_housing($short_housing,$long_housing,$address,$db);

    header('Location: edit_housing.php');
    exit();
}
else if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) {
	$data = json_decode(file_get_contents('php://input'), true);
	add_housings($db, $data);
	exit();
}

 	$hos=get_housings($db);

	
	echo '<form class = "edit_form_g edit_form_50" method="post">';
	echo '<div class = "edit_block"	><input type="text" name="short_housing" placeholder="Корпус" autofocus />';
        echo '<input type="text" name="long_housing" placeholder="Название" autofocus />';
        echo '<input type="text" name="address" placeholder="Адрес" autofocus />';
	echo '</select>';

echo '<input type="hidden" value="add" name="add_housing" />';
echo '<button type="submit" value="Добавить">Добавить</button>';
echo '</div></form>';


    echo '<div class="outer outer_50"><div class="inner">';
    echo '<button type="submit" onClick = "postTable()" value="Изменить">Изменить</button>';
if (mysqli_num_rows($hos) > 0) {
    $i=1;
    echo '<table id="housing">';
    foreach($hos as $housing)
    {
    echo '<tr><td><input type="text" name="short_housing" placeholder="Корпус" value="'. $housing['short_housing'] .'" /></td>';
    echo '<td><input type="text" name="long_housing" placeholder="Полное название" value="'. $housing['long_housing'] .'" /></td>';
    echo '<td><input type="text" name="address" placeholder="Адрес" value="'. $housing['address'] .'" /></td>';


echo '</tr>';
    echo '<input type="hidden" value="'. $housing['id_housing'] .'" name="id_housing" />';
    echo '<input type="hidden" value="alter" name="alter_housing" />';
    $i++;
    }
}
    echo '</div></div>';
echo '</body></html>';
