<?php
require_once '../vendor/connect.php';

session_start();

if ($_SESSION['loggedin'] == false || !isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}

if (!isset($_SESSION['disciplina'])) {
    header('Location: ../select_disciplina/select_disciplina.php');
}

if(isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > 4800) {
        header('Location: ../logout.php');
    }
}

$_SESSION['last_activity'] = time();
$idTeacher = intval($_SESSION['id']);

$discTeacher = $_SESSION['disciplina'];
$nameTeacher = $_SESSION['name_teacher'];

$query = "SELECT total FROM lessons_hours WHERE discName = ? AND id_teacher = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "si", $discTeacher,$idTeacher);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$result = mysqli_fetch_all($result);
if (empty($result)) {
    $_SESSION['none_disc'] = 'Такого предмета нет в базе! Обратитесь к администратору, либо подождите пока сайт оконачательно допилят :)';
    unset($_SESSION['pasport_created']);
    header('Location: ../select_disciplina/select_disciplina.php');
    exit;
}

unset($_SESSION['pasport_created']);
unset($_SESSION['none_disc']);

$nameDisc = $_SESSION['disciplina'];

//запрос(следующие несколько строчек), возвращающий номер таблицы с предметом, для последующего взаимодействия с этой таблицей
$query = "SELECT lessons_hours.table_number FROM lessons_hours WHERE lessons_hours.discName = ? AND id_teacher = ? ";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "ss", $nameDisc,$idTeacher);
mysqli_stmt_execute($stmt);
$number_table = mysqli_stmt_get_result($stmt);
$number_table = mysqli_fetch_all($number_table);
$number_table =  $number_table[0][0]; //номер таблицы с предметом

$_SESSION['number_table'] = $number_table;

$query = "SELECT discName, group_number  FROM lessons_hours WHERE id_teacher = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "s", $idTeacher);
mysqli_stmt_execute($stmt);
$array_disc_teacher = mysqli_stmt_get_result($stmt);
$array_disc_teacher = mysqli_fetch_all($array_disc_teacher);
print_r($array_disc_teacher);



$listGroup = mysqli_query($connect, "SELECT students.group_number FROM students JOIN disciplina_$number_table ON disciplina_$number_table.id = students.id;"); //создание списка всех сущ-их групп для тэга select
$listGroup = mysqli_fetch_all($listGroup);
$listGroupUnique = array();
foreach($listGroup as $itemListGroup) {
foreach ($itemListGroup as $item) {
        $listGroupUnique[] = $item;
    }
}

$listGroupUnique = array_unique($listGroupUnique); //после всех предыдущих манипуляций получаем список с группами преподавателя на конкретном предмете

mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Журнал</title>
</head>
<body>
    <div id="manage_account_win" class="mg_ac_win" style="font-family: sans-serif;">
        <div class="mg_ac_win_child">
            <div class="header_mg_ac_win">
                <h2>Управление аккаунтом</h2>
                <button onclick="closeMg_Ac_Win()">Закрыть</button>
            </div>
            <div class="content_mg_ac_win">
                <div class="predmet_column">
                    <h3>предметы</h3>
                    <?php
                    // $array_disc_teacher
                    foreach ($array_disc_teacher as $line) {
                        echo "<p style="background: gray;">$line[0]</p>";
                    }
                    
                    ?>
                </div>
                <div class="group_column">
                    <h3>группы</h3>
                </div>
                <div class="students_column">
                    <h3>студенты</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="container">       
        <div class="header">
            <div class="left-content-header">
                <div class="menu-button">
                    <a href="../logout.php"onclick="logout()" class="link-nav logoutBtn">
                        Выйти
                    </a>
                    <a href="../select_disciplina/select_disciplina.php" class="link-nav">
                        Выбрать предмет
                    </a>
                </div>
                <div class="info-teacher">
                    <div>
                        <span>Предмет: </span>
                        <span class='title-header'><?=$discTeacher?></span>
                    </div>
                    <div>
                        <span>Преподаватель: </span>
                        <span class='title-header'><?=$nameTeacher?></span>
                    </div>
                </div>
            </div>
            
            <form action="main.php" class="show_group" method="post" id='show_form'>
                <select name="group_number" id="search_group" onchange="SaveValueDiscLS(this)">
                    <option value="Группа">Группа</option>
                    <?php foreach($listGroupUnique as $group) { // заполняем select группами
                        echo "<option value='$group'>$group</option>";
                    }?>
                </select>
                <button class="form-button" type="submit" id="show">Показать</button>
            </form>
            
            <span class="nav-span">
                <nav>
                    <ul>
                        <li><a class="addGroupBtn" style="cursor: pointer">Добавить</a>
                            <ul class="addGroupBtnChild">
                                <li><a href="../add_group/add.php">Добавить группу</a></li>
                                <li><a href="../add_group/add_student.php">Добавить студента</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <span class="material-icons" id="btnSettings" onclick="showSettings()">
                    settings
                </span>
                    <span class="ul_settings" id="ul_settings" style="display: none;">
                    <ul style="list-style: none; font-weight: 400;text-align: right;">
                        <li class="li_settings" style=""><a href="show_pasport.php" style="color: #333;text-decoration: none;padding: 7px;">Паспорт предмета</a></li>
                        <li class="li_settings" style="color: #333;text-decoration: none;padding: 7px;" onclick="openMg_Ac_Win()">Личный кабинет</li>
                    </ul>
                </span>
            </span>
        </div>
        <div class="content">
            
            <div class="left-content" style="display: flex;justify-content: center;align-items: center;">
                <?php
                if (isset($_SESSION['zero_in_table'])) {
                    echo "<div style=\"background-color: rgba(255, 18, 0, 0.2);padding: 20px; border-radius: 7px; margin-bottom: 10px\">";
                    echo "<p align='center' style=\"font-family: sans-serif;font-size: 18px; margin: 5px 0 10px 0;\">Перед тем как добавить группу к предмету, <a style='color: #0071f0;' href='../add_group/add_student.php'>добавьте</a> в неё <b>хотябы одного студента.</b></p>";
                    echo "<p style=\"font-family: sans-serif; margin: 5px 0 10px 0;font-size: 18px;\">После добавления студента группа <b>автоматически</b> добавится к предмету.</p>";
                    echo "<p style=\"font-family: sans-serif; margin: 5px 0 10px 0;font-size: 18px;\">Если вы хотите <b>создать новую группу</b>, то вы можете сделать это <a style='color: #0071f0;' href='#'>здесь</a>.</p>";
                    echo "</div>";
                }

                if (empty($listGroupUnique) && !isset($_SESSION['zero_in_table'])) {
                    echo "<div style=\"background-color: rgba(246, 255, 0, 0.3);padding: 20px; border-radius: 7px; margin-bottom: 10px;max-width: 650px\">";
                    echo "<p style=\"font-family: sans-serif;font-size: 18px; margin: 5px 0 10px 0;\">Для начала работы с предметом добавьте к предмету группы, которые вы <b>указали в паспорте</b>. Это можно сделать в правом верхнем углу экрана.</p>";
                    echo "</div>";
                }

                if (isset($_SESSION['updateIsOK'])) {
                    echo "<div style=\"background-color: rgba(9, 255, 9, 0.2);padding: 20px; border-radius: 7px; margin-bottom: 10px\">";
                    echo "<p align='center' style=\"font-family: sans-serif;font-size: 18px; margin: 5px \"><b>Изменения сохранены!</b></p>";
                    echo "</div>";
                }

                if (isset($_SESSION['group_added'])) {
                    echo "<div style=\"background-color: rgba(9, 255, 9, 0.2);padding: 20px; border-radius: 7px; margin-bottom: 10px\">";
                    echo "<p align='center' style=\"font-family: sans-serif;font-size: 18px; margin: 5px \"><b>Студент добавлен к группе!</b></p>";
                    echo "</div>";
                }
                ?>
            </div>
            <div class="right-content">
                <div class="right-content-top">

                </div>
                <div class="right-content-bottom">
                </div>
            </div>
        </div>
    </div>
<script src="js.js"></script>
</body>
</html>