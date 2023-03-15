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
$idTeacher = $_SESSION['id'];

$discTeacher = $_SESSION['disciplina'];
$nameTeacher = $_SESSION['name_teacher'];

$query = "SELECT total FROM lessons_hours WHERE discName = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "s", $discTeacher);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$result = mysqli_fetch_all($result);
if (empty($result)) {
    $_SESSION['none_disc'] = 'Такого предмета нет в базе! Обратитесь к администратору, либо подождите пока сайт оконачательно допилят :)';
    header('Location: ../select_disciplina/select_disciplina.php');
    exit;
}

unset($_SESSION['pasport_created']);
unset($_SESSION['none_disc']);

$nameDisc = $_SESSION['disciplina']; //запрос(следующие несколько строчек), возвращающий номер таблицы с предметом, для последующего взаимодействия с этой таблицей
$number_table = mysqli_query($connect, "SELECT lessons_hours.table_number FROM lessons_hours WHERE lessons_hours.discName = '$nameDisc'");
$number_table = mysqli_fetch_all($number_table);
$number_table =  $number_table[0][0]; //номер таблицы с предметом

$_SESSION['number_table'] = $number_table;

$listGroup = mysqli_query($connect, "SELECT students.group_number FROM students JOIN disciplina_$number_table ON disciplina_$number_table.id = students.id;"); //создание списка всех сущ-их групп для тэга select
$listGroup = mysqli_fetch_all($listGroup);
$listGroupUnique = array();
foreach($listGroup as $itemListGroup) {
foreach ($itemListGroup as $item) {
        $listGroupUnique[] = $item;
    }
}

$listGroupUnique = array_unique($listGroupUnique); //после всех предыдущих манипуляций получаем список с группами преподавателя на конкретном предмете

//if (empty($listGroupUnique)) {
//    $query = "SELECT group_number FROM `lessons_hours` WHERE discName = ?;";
//    $stmt = mysqli_prepare($connect, $query);
//    mysqli_stmt_bind_param($stmt, "s", $discTeacher);
//    mysqli_stmt_execute($stmt);
//    $result = mysqli_stmt_get_result($stmt);
//    $result = mysqli_fetch_all($result);
//    foreach ($result as $i) {
//        $listGroupUnique[] = $i[0];
//    }
//}
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
            
            <form action="main.php" class="show_group" method="post">
                <select name="group_number" id="search_group" onchange="SaveValueDiscLS(this)">
                    <option value="Группа">Группа</option>
                    <?php foreach($listGroupUnique as $group) { // заполняем select группами
                        echo "<option value='$group'>$group</option>";
                    }?>
                </select>
                <button class="form-button" type="submit">Показать</button>
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
                        <li class="li_settings" style=""><a href="" style="color: #333;text-decoration: none;padding: 7px;">Личный кабинет</a></li>
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
                    echo "<p align='center' style=\"font-family: sans-serif; margin: 5px 0 10px 0;max-width: 580px\">После добавления студента к группе, она <b>автоматически</b> добавится к предмету.</p>";
                    echo "</div>";
                }

                if (isset($_SESSION['group_added'])) {
                    echo "<div style=\"background-color: rgba(9, 255, 9, 0.2);padding: 20px; border-radius: 7px; margin-bottom: 10px\">";
                    echo "<p align='center' style=\"font-family: sans-serif;font-size: 18px; margin: 5px \"><b>Группа добавлена к предмету!</b></p>";
//                    echo "<p align='center' style=\"font-family: sans-serif; margin: 5px 0 10px 0;max-width: 580px\"><b</b></p>";
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