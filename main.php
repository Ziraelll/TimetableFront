<?php
require 'check_logined.php';
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <script src="https://kit.fontawesome.com/51858e06f0.js" crossorigin="anonymous"></script>
    <title>Панель управления</title>
</head>

<body>
    <header>
        <div class="main-wrapper">
            <h1>Панель управления</h1>
            <div class="AdminExit">
                <a href="loginN.html">
                    <span>Выход</span><i class="fa-solid fa-arrow-right-from-bracket"></i>
                </a>
            </div>
        </div>
    </header>
    <main>
        <section class="maim-menu">
            <div class="bord-button bord-button_t">
                <a class="bord-button-link" href="show_raspisanie.php"><i class="fa-solid fa-eye"></i>
                    <div>Просмотр <span>расписания</span></div>
                </a>
                <a class="bord-button-link" href="show_raspisanie_by_classrooms.php"><i class="fa-solid fa-eye"></i>
                    <div>Просмотр <span>расписания по кабинетам</span></div>
                </a>
            </div>
            <div class="bord-button">
                <a class="bord-button-link" href="edit_raspisanie.php">
                    <i class="fa-solid fa-calendar"></i>
                    <div>Редактирование <span>расписания</span></div>
                </a>
                <a class="bord-button-link" href="edit_groups.php">
                    <i class="fa-solid fa-user-group"></i>
                    <div>Редактирование <span>списка групп</span></div>
                </a>
                <a class="bord-button-link" href="edit_classrooms.php">
                    <i class="fa-solid fa-house-laptop"></i>
                    <div>Редактирование <span>списка кабинетов</span></div>
                </a>
                <a class="bord-button-link" href="edit_housings.php">
                    <i class="fa-solid fa-building"></i>
                    <div>Редактирование <span>списка корпусов</span></div>
                </a>
                <a class="bord-button-link" href="edit_users.php"><i class="fa-solid fa-chalkboard-user"></i>
                    <div>Редактирование <span>списка преподавателей</span></div>
                </a>
                <a class="bord-button-link" href="edit_positions.php"><i class="fa-solid fa-address-card"></i>
                    <div>Редактирование <span>списка должностей</span></div>
                </a>
                <a class="bord-button-link" href="edit_lessons.php"><i class="fa-solid fa-subscript"></i>
                    <div>Редактирование <span>списка предметов</span></div>
                </a>
                <a class="bord-button-link" href="edit_department.php"><i class="fa-solid fa-house"></i>
                    <div>Редактирование <span>списка подразделений</span></div>
                </a>
            </div>
        </section>
    </main>
</body>

</html>