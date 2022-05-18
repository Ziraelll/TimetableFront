<?php
require 'db_connect.php';
$db = connect();
$role = 999;
// АВТОРИЗАЦИЯ.
// Параметр $username — имя пользователя.
// Параметр $password — пароль пользователя. 
// Параметр $remember — булева переменная, указывающая на то,
// желает ли пользователь быть автоматически авторизованным
// при следующих заходах на сайт
function Login($con, $username, $password, $remember)
{
    // Имя не должно быть пустой строкой.
    if ($username == '' or $password == '')
        return false;
    // Делаем запрос в базу
    $md5 = md5($password);
    $sql = "SELECT * FROM logins WHERE login='" . $username . "' AND pass_md5='" . $md5 . "' AND banned='0' LIMIT 1";
    $result = mysqli_query($con, $sql);
    echo $sql;
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $GLOBALS["role"] = $row['role'];
        // Запоминаем имя в сессии...
        $_SESSION['username'] = $username;
        // и в cookies, если пользователь пожелал запомнить его (на неделю).
        if ($remember)
            setcookie('username', $username, time() + 3600 * 24 * 7);
        // Успешная авторизация.
        return true;
    } else return false;
}
// СБРОС АВТОРИЗАЦИИ.
//
function Logout()
{ // Делаем cookies устаревшими (единственный способ их удаления).
    setcookie('username', '', time() - 1);
    // Сброс сессии.
    unset($_SESSION['username']);
}
// ТОЧКА ВХОДА.
//
session_start();
$enter_site = false;
// Попадая на страницу login.php, авторизация сбрасывается.
Logout();
// Если массив POST не пуст, значит, обрабатываем отправку формы.
if (count($_POST) > 0)
    $enter_site = Login($db, trim($_POST['username']), trim($_POST['password']), trim($_POST['remember']) == 'on');
// Если авторизация пройдена, переадресуем пользователя
// на одну из страниц сайта.
if ($enter_site) {
    //echo "Hello, ".$_POST['username'];
    if ($role == 1) header("Location: admin.php");
    else header("Location: main.php");
    exit();
}
?>

<html>

<head>
    <title>Вход на сайт</title>
    <link rel="stylesheet" type="text/css" href="index.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <div class="screen_block centerh">
        <h1 class="header">Вход на сайт</h1>
        <form action="" method="post">
            <span class="color_white">Введите имя:</span>
            <input type="text" placeholder="Имя пользователя" required name="username" />
            <br />
            <input type="password" required name="password" />
            <br />
            <input type="checkbox" name="remember" />
            <span class="color_white">Запомнить меня</span>
            <br />
            <input type="submit" value="Войти" />
        </form>
    </div>
</body>

</html>