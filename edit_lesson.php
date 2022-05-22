<?php
require 'check_logined.php';
$title = 'Редактирование предметов  ';
require_once 'header.html';
require 'db_connect.php';

echo '<script type="text/javascript" src="js/editLesson.js"></script>';
$db = connect();
function get_lessons($con)
{
     $result=mysqli_query($con,'SELECT * FROM lessons');
     return $result;
}

	 function add_lesson($subject,$con)
	{
		if ($subject == '')
			return;
		$subject=mysqli_real_escape_string($con,$subject);
		$sql="INSERT INTO lessons (subject) VALUES ('$subject')";
		mysqli_query($con,$sql);
	}

	function alter_lesson($ID,$subject,$con)
	{
		$sql="UPDATE `lessons` SET `subject` = '$subject'
                WHERE `lessons`.`id_subject` = '$ID';";
		mysqli_query($con,$sql);	
	}

	if(isset($_POST['add_lesson']))
	{
		$subject=trim($_POST['subject']);
		add_lesson($subject,$db);
		
		header('Location: edit_lesson.php');
		exit();
	}
	else if (isset($_POST['alter_lesson']))
	{
		$ID=trim($_POST['id_subject']);
		$subject=trim($_POST['subject']);
		alter_lesson($ID,$subject,$db);
	}

 	$lesson=get_lessons($db);


echo '<form class = "edit_form_g edit_form_30" method="post">';
echo '<div class = "edit_block"><input type="text" name="subject"  placeholder="Предмет" autofocus />';



echo '<input type="hidden" value="add" name="add_lesson" />';
echo '<button type="submit" value="Добавить">Добавить</button>';

echo '</div></form>';




    echo '<div class="outer outer_30"><div class="inner">';
    echo '<button type="submit" onClick = "postTable()" value="Изменить">Изменить</button>';
if (mysqli_num_rows($lesson) > 0) {
    $i=1;
    echo '<table id="lessons">';
    foreach($lesson as $name)
    {
    echo '<tr><td><input type="text" name="subject"  placeholder="Предмет" value="'. $name['subject'] .'" /></td></tr>';
    echo '<input type="hidden" value="'. $name['id_subject'] .'" name="id_subject" />';
    echo '<input type="hidden" value="alter" name="alter_lesson" />';
    $i++;
    }
    echo '</table>';
}
echo '</body></html>';
?>