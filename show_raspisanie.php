<?php



    require 'db_connect.php';
   $title = 'Расписание   ';
   require_once 'header.html';
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

        function raspisanie_get_info($con,$group,$id_type_week,$dates_of_week)
        {
               /*
                $sql="SELECT * FROM raspisanie
                        LEFT JOIN (lessons,housings,classrooms,top_or_bottom,day_of_week) ON (raspisanie.id_subject = lessons.id_subject AND
                        raspisanie.id_housing = housings.id_housing AND
                        raspisanie.id_classroom= classrooms.id_classroom AND
                        raspisanie.id_type_week = top_or_bottom.id_type_week AND
                        raspisanie.id_day= day_of_week.id_day)
                        LEFT OUTER JOIN (SELECT `users`.`id_user` AS `id_user_first`, `users`.`fname` AS `fname_first`, `users`.`lname` AS `lname_first`, `users`.`surname` AS `surname_first`, `users`.`id_position` AS `id_position_first`
                        FROM `users`) AS first ON raspisanie.id_user = first.id_user_first
                        LEFT OUTER JOIN (SELECT `users`.`id_user` AS `id_user_second`, `users`.`fname` AS `fname_second`, `users`.`lname` AS `lname_second`, `users`.`surname` AS `surname_second`, `users`.`id_position` AS `id_position_second` FROM `users` ) AS second ON raspisanie.second_teacher = second.id_user_second
                        WHERE id_group='$group' AND (raspisanie.id_type_week='$id_type_week' OR raspisanie.id_type_week='2')

                        ORDER BY raspisanie.id_day, raspisanie.number_pair";
*/
         // Запрос, в котором надо заменить даты на элементы массива

                $sql="SELECT * FROM raspisanie LEFT JOIN (lessons,housings,classrooms,top_or_bottom,day_of_week) ON (raspisanie.id_subject = lessons.id_subject AND raspisanie.id_housing = housings.id_housing AND raspisanie.id_classroom= classrooms.id_classroom AND raspisanie.id_type_week = top_or_bottom.id_type_week AND raspisanie.id_day= day_of_week.id_day) LEFT OUTER JOIN (SELECT `users`.`id_user` AS `id_user_first`, `users`.`fname` AS `fname_first`, `users`.`lname` AS `lname_first`, `users`.`surname` AS `surname_first`, `users`.`id_position` AS `id_position_first` FROM `users`) AS first ON raspisanie.id_user = first.id_user_first LEFT OUTER JOIN (SELECT `users`.`id_user` AS `id_user_second`, `users`.`fname` AS `fname_second`, `users`.`lname` AS `lname_second`, `users`.`surname` AS `surname_second`, `users`.`id_position` AS `id_position_second` FROM `users` ) AS second ON raspisanie.second_teacher = second.id_user_second
WHERE id_group='$group'
AND (raspisanie.id_type_week='$id_type_week' OR raspisanie.id_type_week='2')
AND ((('$dates_of_week[0]' BETWEEN date_start AND date_end) AND raspisanie.id_day='1')
     OR (('$dates_of_week[1]' BETWEEN date_start AND date_end) AND raspisanie.id_day='2')
     OR (('$dates_of_week[2]' BETWEEN date_start AND date_end) AND raspisanie.id_day='3')
     OR (('$dates_of_week[3]' BETWEEN date_start AND date_end) AND raspisanie.id_day='4')
     OR (('$dates_of_week[4]' BETWEEN date_start AND date_end) AND raspisanie.id_day='5')
     OR (('$dates_of_week[5]' BETWEEN date_start AND date_end) AND raspisanie.id_day='6')
)
ORDER BY raspisanie.id_day, raspisanie.number_pair";




/*
SELECT * FROM raspisanie LEFT JOIN (lessons,housings,classrooms,top_or_bottom,day_of_week) ON (raspisanie.id_subject = lessons.id_subject AND raspisanie.id_housing = housings.id_housing AND raspisanie.id_classroom= classrooms.id_classroom AND raspisanie.id_type_week = top_or_bottom.id_type_week AND raspisanie.id_day= day_of_week.id_day) LEFT OUTER JOIN (SELECT `users`.`id_user` AS `id_user_first`, `users`.`fname` AS `fname_first`, `users`.`lname` AS `lname_first`, `users`.`surname` AS `surname_first`, `users`.`id_position` AS `id_position_first` FROM `users`) AS first ON raspisanie.id_user = first.id_user_first LEFT OUTER JOIN (SELECT `users`.`id_user` AS `id_user_second`, `users`.`fname` AS `fname_second`, `users`.`lname` AS `lname_second`, `users`.`surname` AS `surname_second`, `users`.`id_position` AS `id_position_second` FROM `users` ) AS second ON raspisanie.second_teacher = second.id_user_second
WHERE id_group='$group'
AND (raspisanie.id_type_week='$id_type_week' OR raspisanie.id_type_week='2')

AND (date_start<='$weekStart' AND date_end >= '$weekEnd')

ORDER BY raspisanie.id_day, raspisanie.number_pair

*/


/*

                        {
                                $sql="SELECT * FROM raspisanie WHERE id_group='$group' ORDER BY raspisanie.id_raspisanie";
                        }
                        else
                $sql='SELECT * FROM raspisanie ORDER BY raspisanie.id_raspisanie';
               */

                $result=mysqli_query($con,$sql) or die(mysqli_error($con));
                return $result;
                }
                session_start();






// Меняем переход домой в зависимости от того, залогинен ли пользователь]
//

// Если в контексте сессии не установлено имя пользователя,
// пытаемся взять его из cookies.
if (!isset($_SESSION['username']) && isset($_COOKIE['username']))
        $_SESSION['username'] = $_COOKIE['username'];
// Еще раз ищем имя пользователя в контексте сессии.
$username = $_SESSION['username'];
// Неавторизованных пользователей отправляем на страницу регистрации.
if ($username == null)
        {
           echo '<a href="index.php">';
        }
        //else echo '<a href="main.php">';



        //echo '<p> Выберите группу </p>';



/*      $subject=get_subject($db);
        $housing=get_housing($db);
        $classroom=get_classroom($db);

        $user=get_user($db);
        $week=get_day_week($db);
        $type=get_type_week($db);
*/
        $group=get_group($db);
        //$week=day_week($db);



// echo "<script src="https://kit.fontawesome.com/51858e06f0.js" crossorigin="anonymous" ></script>";



if (isset($_GET['name_group'])) $name['id_group']=$_GET['name_group'];
echo '<div class ="edit_form_g" style="flex-direction: column;top: 8%;" >';
echo '<div class ="show_r">';
echo "<select   name='id_group' id='id_group' onchange='document.location=this.options[this.selectedIndex].value'>";
                if($name['id_group']=='')
                echo '<option value="none" hidden=""> Группа</option>';
                if (mysqli_num_rows($group) > 0)
                        foreach($group as $grp)
                        {
                                echo '<option value=show_raspisanie.php?name_group='.$grp['id_group'] .'';
                                if ($name['id_group']==$grp['id_group']) {
                                        echo ' selected >';
                                } else {
                                        echo '>';
                                }
                                echo $grp['group_name'] .'</option>';
                        }
                        echo '</select>';
echo "<div><a id = 'reset' href = 'show_raspisanie.php' '>Сброc&nbsp;фильтра</a></div>";
echo "</div>";
echo "<div>";
echo "<a href = 'show_raspisanie.php?date=".$lastweek;
if (isset($_GET['name_group']))
    echo   "&name_group=".$_GET['name_group'];
echo "' class='button_r'>Следующая неделя</a>";

echo "<a  href = 'show_raspisanie.php?date=".$nextweek;
if (isset($_GET['name_group']))
    echo   "&name_group=".$_GET['name_group'];
echo "' class='button_r'>Предыдущая неделя</a>";
echo "</div>";
echo '</div>';
$week_days = ['Понедельник','Вторник','Среда','Четверг','Пятница','Суббота','Воскресенье'];

// <img class='' src='image/calendar_prev.png'>
// <img class='' src='image/calendar_prev.png'>



// Получаем расписание группы для нужного типа недели
if (isset($_GET['name_group']))
{
        if (isset($_GET['date'])){
                $mondayNow=date('Y-m-d', strtotime('last Monday',strtotime($_GET['date'])));
                //echo 'mondayNow '.$mondayNow; Вывод даты понелельника
        }else {
                $mondayNow=date('Y-m-d', strtotime('last Monday',strtotime('now')));
                //echo 'mondayNow '.$mondayNow;
        }
      //  echo "<br/>";

      $dataCur = $mondayNow;
      //echo 'dataCur '.$dataCur;
      $sql="SELECT * FROM chetnost_week WHERE (('$dataCur') BETWEEN chetnost_week.dataN AND chetnost_week.dataF)";
     // echo $sql;
      $odd_or_even=mysqli_query($db,$sql) or die(mysqli_error($db));
      if (mysqli_num_rows($odd_or_even) > 0) {
        $row = mysqli_fetch_array($odd_or_even, MYSQLI_ASSOC);
        $type_week = $row['type_week'];
        $dataN = strtotime($row['dataN']); // Дата начала семестра
      }

      $dataNw = date("W",$dataN); // Номер первой недели семестра от начала года
     // echo 'dataNw'.$dataNw;
      $dataCw = date("W",strtotime($dataCur)); // Номер текущей недели
     // echo 'dataCw'.$dataCw;
      // Если статус type_week = 0 то это верхняя неделя, если 1, то нижняя
      // id_type_week = 1 верхняя неделя, 2 - каждая неделя, 3 нижняя неделя
        $type_week_cur = ($dataCw-$dataNw+$type_week)%2;
        if ($type_week_cur)  $id_type_week=3;
                else $id_type_week=1;  // Переменная со значением недели
       // echo 'id_type_week='.$id_type_week;




// Заполнение массива дат циклом сюда
$dates_of_week[0]=$mondayNow;
for($g=1;$g<6;$g++)
{
        $dates_of_week[$g]=date('Y-m-d', strtotime($dates_of_week[$g-1] . ' +1 day'));
}
//print_r($dates_of_week); тест массива дат



$nextweek=date('Y-m-d', strtotime($mondayNow . ' +8 days'));
$lastweek=date('Y-m-d', strtotime($mondayNow . ' -6 days'));

//echo "<div>"


//echo "' class='button'><span>Следующая неделя</span></a>";
//echo "";
echo "<hr/>";
//[Следующая неделя]





        $result=raspisanie_get_info($db,$_GET['name_group'],$id_type_week,$dates_of_week);
        // в функцию передать массив с датами

        if (mysqli_num_rows($result) > 0) {
                $i=1;
                echo '<div class="outer" style="width: 50%;"><div class="inner" style="width: 80%;">';
                echo "<TABLE  cellpadding='5'  border='1px' style='text-align: center;font-size: 20px;width: 100%;padding: 3px;'>";

                for($g=1;$g<7;$g++)
                {

                echo '<TR align = center><TD colspan=6 align = center><H2>'.$week_days[$g-1].'&nbsp;'.$dates_of_week[$g-1].'</H2></TD></TR>';
                echo "<TR><TD>№ пары</TD><TD >Дисциплина</TD></TD></TR>";
                        $flag = False;
                        foreach($result as $name)
                        {
                                if($name['id_day']==$g)
                                {
                                        echo "<TR><TD class='bold centerh' rowspan=2>".$name['number_pair']."</TD><TD class='bold'>".$name['subject']."</TD></TR>
                                        <TR><TD>".$name['lname_first'].' '.mb_substr($name['fname_first'],0,1,"UTF-8").'. '.mb_substr($name['surname_first'],0,1,"UTF-8")
                                        .". <span class='italic'>".$name['classroom']." ".$name['short_housing']."</span></TD></TR>";
                                        $i++;
                                        $flag=True;
                                }
                        }
                        if(! $flag){
                        echo '<TR><TD class=GreyVoid align = center colspan=6>Нет занятий</TD></TR>';
                        }
                }
                echo '</div></div>';
        }
}

?>