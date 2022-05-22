<?php
require 'check_logined.php';
$title = 'Редактирование Расписания';
require_once 'header.html';


require 'db_connect.php';
$db = connect();

function get_subject($con)
{
         $result=mysqli_query($con,'SELECT * FROM lessons') or die(mysqli_error($con));
         return $result;
}

function get_housing($con)
{
         $result=mysqli_query($con,'SELECT id_housing, short_housing FROM housings') or die(mysqli_error($con));
         return $result;
}

function get_classroom($con)
{
         $result=mysqli_query($con,'SELECT id_classroom, classroom FROM classrooms') or die(mysqli_error($con));
         return $result;
}

function get_group($con)
{
         $result=mysqli_query($con,'SELECT * FROM groups') or die(mysqli_error($con));
         return $result;
}

function get_user($con)
{
         $result=mysqli_query($con,'SELECT id_user, lname, fname, surname FROM users WHERE id_position="3"') or die(mysqli_error($con));
         return $result;
}

function get_day_week($con)
{
         $result=mysqli_query($con,'SELECT * FROM day_of_week') or die(mysqli_error($con));
         return $result;
}

function get_type_week($con)
{
         $result=mysqli_query($con,'SELECT * FROM top_or_bottom') or die(mysqli_error($con));
         return $result;
}
function DELETE_raspisanie($ID,$con)
{
        $sql="DELETE From `raspisanie` WHERE `raspisanie`.`id_raspisanie` = '$ID'";
        mysqli_query($con,$sql);
}

function raspisanie_get_info($con,$group)
{       
 
                if($group)
                {
                        $sql="SELECT * FROM raspisanie WHERE id_group='$group' ORDER BY raspisanie.id_raspisanie";
                }
                else
        $sql='SELECT * FROM raspisanie ORDER BY raspisanie.id_raspisanie';
        //echo $sql;
        $result=mysqli_query($con,$sql) or die(mysqli_error($con));
        return $result;
}

function add_raspisanie($number_pair,$subject,$housing,$classroom,$group,$user,$s_user,$date_start,$date_end,$type_week,$day_week,$con)
{
        if ($number_pair == '')
                return;
        $number_pair=mysqli_real_escape_string($con,$number_pair);
        $subject=mysqli_real_escape_string($con,$subject);
        $housing=mysqli_real_escape_string($con,$housing);
        $classroom=mysqli_real_escape_string($con,$classroom);
        $group=mysqli_real_escape_string($con,$group);
        $user=mysqli_real_escape_string($con,$user);
        $s_user=mysqli_real_escape_string($con,$s_user);
        $date_start=mysqli_real_escape_string($con,$date_start);
        $date_end=mysqli_real_escape_string($con,$date_end);
        $type_week=mysqli_real_escape_string($con,$type_week);
        $day_week=mysqli_real_escape_string($con,$day_week);
        $sql="INSERT INTO raspisanie (number_pair,id_subject,id_housing,id_classroom,id_group,id_user,second_teacher,date_start,date_end,id_type_week,id_day) 
        VALUES ('$number_pair','$subject','$housing','$classroom','$group','$user','$s_user','$date_start','$date_end','$type_week','$day_week')";
        mysqli_query($con,$sql);
}

function alter_raspisanie($ID,$number_pair,$subject,$housing,$classroom,$group,$user,$s_user,$date_start,$date_end,$type_week,$day_week,$con)
{
        $sql="UPDATE `raspisanie` SET `number_pair` = '$number_pair', `id_subject` = '$subject', `id_housing` = '$housing', `id_classroom`='$classroom',`id_group`='$group', `id_user`='$user',`second_teacher`='$s_user', `date_start`='$date_start',`date_end`='$date_end',`id_type_week`='$type_week',`id_day`='$day_week' WHERE `raspisanie`.`id_raspisanie` = '$ID';";
        mysqli_query($con,$sql);        
}

if(isset($_POST['add_raspisanie']))
{
        $number_pair=trim($_POST['number_pair']);
        $subject=trim($_POST['id_subject']);
        $housing=trim($_POST['id_housing']);
        $classroom=trim($_POST['id_classroom']);
        $group=trim($_POST['id_group']);
        $user=trim($_POST['id_user']);
        $s_user=trim($_POST['second_teacher']);
        $date_start=trim($_POST['date_start']);
        $date_end=trim($_POST['date_end']);
        $type_week=trim($_POST['id_type_week']);
        $day_week=trim($_POST['id_day']);
        add_raspisanie($number_pair,$subject,$housing,$classroom,$group,$user,$s_user,$date_start,$date_end,$type_week,$day_week,$db);
        
        header('Location: edit_raspisanie.php');
        exit();
}
else if (isset($_POST['alter_raspisanie']))
{
        $ID=trim($_POST['id_raspisanie']);
        $number_pair=trim($_POST['number_pair']);
        $subject=trim($_POST['id_subject']);
        $housing=trim($_POST['id_housing']);
        $classroom=trim($_POST['id_classroom']);
        $group=trim($_POST['id_group']);
        $user=trim($_POST['id_user']);
        $s_user=trim($_POST['second_teacher']);
        $date_start=trim($_POST['date_start']);
        $date_end=trim($_POST['date_end']);
        $type_week=trim($_POST['id_type_week']);
        $day_week=trim($_POST['id_day']);
        alter_raspisanie($ID,$number_pair,$subject,$housing,$classroom,$group,$user,$s_user,$date_start,$date_end,$type_week,$day_week,$db);
}
else if (isset($_POST['DELETE_raspisanie']))
{ 
        $ID=trim($_POST['id_raspisanie']);
        DELETE_raspisanie($ID,$db);
}
 
if (isset($_GET['name_group'])){$result=raspisanie_get_info($db,$_GET['name_group']);}
else
$result=raspisanie_get_info($db,0);
$subject=get_subject($db);
$housing=get_housing($db);
$classroom=get_classroom($db);
$group=get_group($db);
$user=get_user($db);
$week=get_day_week($db);
$type=get_type_week($db);


echo '<form class = "edit_form" method="post">';
echo '<input type="text" name="number_pair" placeholder="№ пары" autofocus />';
echo '<input type="date" name="date_start" placeholder="Дата начала" />';
echo '<input type="date" name="date_end" placeholder="Дата конца" />';

echo '<select class="select" name="id_subject" id="id_subject">';
echo '<option value="none" hidden="">Выберите предмет</option>';

if (mysqli_num_rows($subject) > 0){
        $sub_arr["sub"] = array();
        foreach($subject as $sub)
        {       
                echo '<option value="'.$sub['id_subject'] .'">'.$sub['subject'] .'</option>';
        }       
}
echo '</select>';

echo '<BR />';

echo '<select name="id_housing" id="id_housing">';
echo '<option value="none" hidden="">Выберите корпус</option>';
if (mysqli_num_rows($housing) > 0){
        $hoz_arr["hoz"] = array();
        foreach($housing as $hoz)
        {       
                echo '<option value="'.$hoz['id_housing'] .'">'.$hoz['short_housing'] .'</option>';
        }       
}
echo '</select>';

echo '<select name="id_classroom" id="id_classroom">';
echo '<option value="none" hidden="">Выберите кабинет</option>';
if (mysqli_num_rows($classroom) > 0){
        $cls_arr["cls"] = array();
        foreach($classroom as $cls)
        {       
                echo '<option value="'.$cls['id_classroom'] .'">'.$cls['classroom'] .'</option>';
        }       
}
echo '</select>';

echo '<select name="id_group" id="id_group">';
echo '<option value="none" hidden="">Выберите группу</option>';
if (mysqli_num_rows($group) > 0){
        $grp_arr["grp"] = array();
        foreach($group as $grp)
        {       
                echo '<option value="'.$grp['id_group'] .'">'.$grp['group_name'] .'</option>';
        }       
}
echo '</select>';

echo '<select name="id_user" id="id_user">';
echo '<option value="none" hidden="">Выберите основного преподавателя</option>';
if (mysqli_num_rows($user) > 0){
        $us_arr["us"] = array();
        foreach($user as $us)
        {       
                echo '<option value="'.$us['id_user'] .'">'.$us['lname'] ." ".$us['fname'] ." ".$us['surname'] .'</option>';
        }       
}
echo '</select>';

echo '<select name="second_teacher" id="second_teacher">';
echo '<option value="none" hidden="">Выберите второго преподавателя</option>';
if (mysqli_num_rows($user) > 0){
        $us_arr["us"] = array();
        foreach($user as $us)
        {       
                echo '<option value="'.$us['id_user'] .'">'.$us['lname'] ." ".$us['fname'] ." ".$us['surname'] .'</option>';
        }       
}
echo '</select>';

echo '<select name="id_type_week" id="id_type_week">';
echo '<option value="none" hidden="">Выберите верх/низ</option>';
if (mysqli_num_rows($type) > 0){
        $tp_arr["tp"] = array();
        foreach($type as $tp)
        {       
                echo '<option value="'.$tp['id_type_week'] .'">'.$tp['type_week'] .'</option>';
        }       
}
echo '</select>';

echo '<select name="id_day" id="id_day">';
echo '<option value="none" hidden="">Выберите день недели</option>';
if (mysqli_num_rows($week) > 0){
        $day_arr["day"] = array();
        foreach($week as $day)
        {       
                echo '<option value="'.$day['id_day'] .'">'.$day['name_day'] .'</option>';
        }       
}

echo '</select>';

echo '<input type="hidden" value="add" name="add_raspisanie" />';
echo '<input type="submit" value="Добавить" />';
echo '</form>';

echo '<div class="outer out_r"><div class="inner">';
if (isset($_GET['name_group'])) $name['id_group']=$_GET['name_group'];
echo '<select name="id_group" id="id_group" onchange="document.location=this.options[this.selectedIndex].value">';
        if($name['id_group']=='') echo '<option value="none" hidden="">Выберите группу</option>';
        if (mysqli_num_rows($group) > 0)
                foreach($group as $grp)
                {       
                        echo '<option value=edit_raspisanie.php?name_group='.$grp['id_group'] .'';
                        if ($name['id_group']==$grp['id_group']) {
                                echo ' selected >';
                        } else {
                                echo '>';
                        }
                        echo $grp['group_name'] .'</option>';
                }
                echo '</select>';

echo "<a href = 'edit_raspisanie.php' class='boxed'>[Сброc&nbsp;фильтра]</a>";
echo '</div></div>';

if (mysqli_num_rows($result) > 0) {
        $i=1;
        foreach($result as $name)
        {
        /*if ($i%2==0) echo '<div style="background-color:#DDD; padding:10px">';
        else echo '<div style="padding:10px">';*/
        echo '<div class="outer outer_70 outer_r"><div class="inner">';
        echo '<form class ="wrap_form" method="post">';
        echo '<input style="width: 69px;" type="text" name="number_pair" placeholder="№ пары" value="'. $name['number_pair'] .'" />';
        echo '<input type="date" name="date_start" placeholder="Дата начала" value="'. $name['date_start'] .'" />';
        echo '<input type="date" name="date_end" placeholder="Дата конца" value="'. $name['date_end'] .'" />';
        echo '<select name="id_subject" class="select" id="id_subject">';
        if($name['id_subject']=='') echo '<option value="none" hidden="">Выберите предмет</option>';
        if (mysqli_num_rows($subject) > 0)
                foreach($subject as $sub)
                {       
                        echo '<option value="'.$sub['id_subject'] .'"';
                        if ($name['id_subject']==$sub['id_subject']) {
                                echo ' selected >';
                        } else {
                                echo '>';
                        }
                        
                        echo $sub['subject'] .'</option>';
                }
                echo '</select>';
        
        echo '<BR />';
        
        echo '<select name="id_housing" id="id_housing">';
        if($name['id_position']=='') echo '<option value="none" hidden="">Выберите корпус</option>';
        if (mysqli_num_rows($housing) > 0)
                foreach($housing as $hoz)
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
                
        echo '<select name="id_classroom" id="id_classroom">';
        if($name['id_classroom']=='') echo '<option value="none" hidden="">Выберите кабинет</option>';
        if (mysqli_num_rows($classroom) > 0)
                foreach($classroom as $cls)
                {       
                        echo '<option value="'.$cls['id_classroom'] .'"';
                        if ($name['id_classroom']==$cls['id_classroom']) {
                                echo ' selected >';
                        } else {
                                echo '>';
                        }
                        
                        echo $cls['classroom'] .'</option>';
                }
                echo '</select>';
                
        echo '<select name="id_group" id="id_group">';
        if($name['id_group']=='') echo '<option value="none" hidden="">Выберите группу</option>';
        if (mysqli_num_rows($group) > 0)
                foreach($group as $grp)
                {       
                        echo '<option value="'.$grp['id_group'] .'"';
                        if ($name['id_group']==$grp['id_group']) {
                                echo ' selected >';
                        } else {
                                echo '>';
                        }
                        
                        echo $grp['group_name'] .'</option>';
                }
                echo '</select>';
                
        echo '<select name="id_user" id="id_user">';
        if($name['id_user']=='') echo '<option value="none" hidden="">Выберите основного преподавателя</option>';
        if (mysqli_num_rows($user) > 0)
                foreach($user as $us)
                {       
                        echo '<option value="'.$us['id_user'] .'"';
                        if ($name['id_user']==$us['id_user']) {
                                echo ' selected >';
                        } else {
                                echo '>';
                        }
                        
                        echo $us['lname']." ".$us['fname'] ." ".$us['surname'] .'</option>';
                }
                echo '</select>';
                
        echo '<select name="second_teacher" id="second_teacher">';
        if($name['second_teacher']=='') echo '<option value="none" hidden="">Выберите второго преподавателя</option>';
        if( $name['second_teacher']=='0') echo '<option value="0" selected >Нет преподавателя</option>';
        else echo '<option value="0">Нет преподавателя</option>';
        if (mysqli_num_rows($user) > 0)
                foreach($user as $us)
                {       
                        echo '<option value="'.$us['id_user'] .'"';
                        if ($name['second_teacher']==$us['id_user']) {
                                echo ' selected >';
                        } else {
                                echo '>';
                        }
                        
                        echo $us['lname']." ".$us['fname'] ." ".$us['surname'] .'</option>';
                }
                echo '</select>';
                
        echo '<select name="id_type_week" id="id_type_week">';
        if($name['id_type_week']=='') echo '<option value="none" hidden="">Выберите верх/низ</option>';
        if (mysqli_num_rows($type) > 0)
                foreach($type as $tp)
                {       
                        echo '<option value="'.$tp['id_type_week'] .'"';
                        if ($name['id_type_week']==$tp['id_type_week']) {
                                echo ' selected >';
                        } else {
                                echo '>';
                        }
                        
                        echo $tp['type_week'] .'</option>';
                }
                echo '</select>';
                
        echo '<select name="id_day" id="id_day">';
        if($name['id_position']=='') echo '<option value="none" hidden="">Выберите день недели</option>';
        if (mysqli_num_rows($week) > 0)
                foreach($week as $day)
                {       
                        echo '<option value="'.$day['id_day'] .'"';
                        if ($name['id_day']==$day['id_day']) {
                                echo ' selected >';
                        } else {
                                echo '>';
                        }
                        
                        echo $day['name_day'] .'</option>';
                }
        
        echo '</select>';
        
        echo '<input type="submit" value="Изменить" />';
        echo '<input type="hidden" value="'. $name['id_raspisanie'] .'" name="id_raspisanie" />';
        echo '<input type="hidden" value="alter" name="alter_raspisanie" />';
        echo '</form>';
        
        echo '<form method="post">';
        echo '<div class="float_right"><input type="submit" value="Удалить" /></div>';
        echo '<input type="hidden" value="'. $name['id_raspisanie'] .'" name="id_raspisanie" />';
        echo '<input type="hidden" value="DELETE" name="DELETE_raspisanie" />';
       
        echo '</form>';
       
        $i++;
        
        
       
        }
        
        
        
}

echo '</body></html>';
?>