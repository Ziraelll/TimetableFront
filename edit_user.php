<?php
require 'check_logined.php';
$title = 'Редактирование преподавателей';
require_once 'header.html';
require 'db_connect.php';
$db = connect();
echo'<script type="text/javascript" src="js/editUser.js"></script>';

function get_positions($con)
{
     $result=mysqli_query($con,'SELECT * FROM positions') or die(mysqli_error());
     return $result;
}

function users_get_info($con)
{	
    $result=mysqli_query($con,'SELECT * FROM users LEFT JOIN positions ON users.id_position = positions.id_position ORDER BY users.id_user') or die(mysqli_error());

    return $result;
}

function add_name($firstname,$middlename,$lastname,$position,$con)
{
    if ($firstname == '')
        return;
    $firstname=mysqli_real_escape_string($con,$firstname);
    $middlename=mysqli_real_escape_string($con,$middlename);
    $lastname=mysqli_real_escape_string($con,$lastname);
    $sql="INSERT INTO users (fname,surname,lname,id_position) VALUES ('$firstname','$middlename','$lastname','$position')";
    mysqli_query($con,$sql);
}

function alter_name($ID,$firstname,$middlename,$lastname,$position,$dismissed,$con)
{
    $sql="UPDATE `users` SET `lname` = '$lastname', `fname` = '$firstname', `surname` = '$middlename', `id_position`='$position', `banned`='$dismissed' WHERE `users`.`id_user` = '$ID';";
    mysqli_query($con,$sql);	
}

if(isset($_POST['add_name']))
{
    $firstname=trim($_POST['fname']);
    $middlename=trim($_POST['surname']);
    $lastname=trim($_POST['lname']);
    $position=trim($_POST['id_position']);
    add_name($firstname,$middlename,$lastname,$position,$db);
    
    header('Location: edit_user.php');
    exit();
}
else if (isset($_POST['alter_name']))
{
    $ID=trim($_POST['id_user']);
    $firstname=trim($_POST['fname']);
    $middlename=trim($_POST['surname']);
    $lastname=trim($_POST['lname']);
    $position=trim($_POST['id_position']);
    if ($_POST['banned']=='on') {
        $dismissed=1;
    } else $dismissed=0;
    alter_name($ID,$firstname,$middlename,$lastname,$position,$dismissed,$db);
}

 $result=users_get_info($db);
 $positions=get_positions($db);


echo '<form class = "edit_form_g edit_form_60 " method="post">';
echo '<div class = "edit_block"><input type="text" name="lname" placeholder="Фамилия" autofocus />';
echo '<input type="text" name="fname" placeholder="Имя" />';
echo '<input type="text" name="surname" placeholder="Отчество" />';

echo '<select class = "edit_select" name="id_position" id="id_position">';
echo '<option value="none" hidden="">Выберите должность</option>';

if (mysqli_num_rows($positions) > 0){
    $pos_arr["pos"] = array();
    foreach($positions as $pos)
    {	
                    

        echo '<option value="'.$pos['id_position'] .'">'.$pos['position'] .'</option>';
    }	
}

echo '</select>';
echo '<input type="hidden" value="add" name="add_name" />';
echo '<button type="submit" value="Добавить">Добавить</button>';
echo '</div></form>';
   echo '<button class = "fix_but" type="submit" onClick = "postTable()" value="Изменить">Сохранить</button>';
    echo '<div class="outer outer_60"><div class="inner">';

if (mysqli_num_rows($result) > 0) {
    $i=1;
    foreach($result as $name)
    {
    echo '<tr><td><input type="text" name="lname" placeholder="Фамилия" value="'. $name['lname'] .'" /></td>';
    echo '<td><input type="text" name="fname" placeholder="Имя" value="'.  $name['fname'] .'" /></td>';
    echo '<td><input type="text" name="surname" placeholder="Отчество" value="'. $name['surname'] .'" /></td>';
    echo '<td>';
    echo '<select name="id_position" id="id_position">';
    if($name['id_position']=='') echo '<option value="none" hidden="">Выберите должность</option>';
    if (mysqli_num_rows($positions) > 0)
        foreach($positions as $pos)
        {	
            echo '<option value="'.$pos['id_position'] .'"';
            if ($name['id_position']==$pos['id_position']) {
                echo ' selected >';
            } else {
                echo '>';
            }
            
            echo $pos['position'] .'</option>';
        }	

    echo '</select>';
    echo '</td>';
    echo '<td>';
    if ($name['banned']==1) {
        echo '<input type="checkbox" checked="checked" name="banned" />Забанен&nbsp;&nbsp;&nbsp;&nbsp;';
    } else echo '<input type="checkbox" name="banned" />Не забанен&nbsp;&nbsp;&nbsp;&nbsp;';

    echo '</td>';
    echo '</tr>';
    echo '<input type="hidden" value="'. $name['id_user'] .'" name="id_user" />';
    echo '<input type="hidden" value="alter" name="alter_name" />';
    echo '</form></p>';
    $i++;
    }

    echo '</table>';
}
echo '</body></html>';
