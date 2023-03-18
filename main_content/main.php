<?php
require_once '../vendor/connect.php';

session_start();

if ($_SESSION['loggedin'] == false || !isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}

if(isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > 4800) {
        header('Location: ../logout.php');
    }
}

if (!isset($_SESSION['disciplina'])) {
    header('Location: ../select_disciplina/select_disciplina.php');
}

$groupName = $_POST['group_number'];

if ($groupName == 'Группа') {
    header('Location: select.php');
}

if (!isset($groupName)) {
    header('Location: ../select_disciplina/select_disciplina.php');
}



unset($_SESSION['pasport_created']);
unset($_SESSION['none_disc']);
unset($_SESSION['group_added']);
unset($_SESSION['updateIsOK']);

$_SESSION['last_activity'] = time();


$discTeacher = $_SESSION['disciplina'];


$query = "SELECT total FROM lessons_hours WHERE discName = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "s", $discTeacher);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$result = mysqli_fetch_all($result);
if (empty($result)) {
    $_SESSION['none_disc'] = 'Такого предмета нет в базе! Обратитесь к администратору, либо подождите пока сайт оконачательно допилят :)';
    header('Location: ../select_disciplina/select_disciplina.php');
    exit();
}

unset($_SESSION['zero_in_table']);

$nameTeacher = $_SESSION['name_teacher'];
$idTeacher = $_SESSION['id'];
$number_table = $_SESSION['number_table'];

$query = "SELECT completed_state FROM `lessons_hours` WHERE discName = ? AND id_teacher = ?;";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "ss", $discTeacher, $idTeacher);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$result = mysqli_fetch_all($result);
$json = $result[0][0];
$json_data = json_decode($json, true); //получили ассоциативный массив со всеми завершёнными и не зав-нными темами


$listGroup = mysqli_query($connect, "SELECT students.group_number FROM students JOIN disciplina_$number_table ON disciplina_$number_table.id = students.id;");
$listGroup = mysqli_fetch_all($listGroup);
$listGroupUnique = array();

foreach ($listGroup as $itemListGroup) {
    foreach ($itemListGroup as $item) {
        $listGroupUnique[] = $item;
    }
}

$listGroupUnique = array_unique($listGroupUnique);

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
//function count_H_in_str($name,$connect,$sql_disciplina) { //функция - помошник для следующей функции, отвечающая за заброс данных из БД
    //    $str = '';
    //    $sqll = "SELECT
    //        tema_1,tema_2,tema_3,tema_4,tema_5,tema_6,tema_7,tema_8,tema_9,tema_10,tema_11,tema_12,
    //        tema_13,tema_14,tema_15,tema_16,tema_17,tema_18,tema_19,tema_20,tema_21,tema_22,tema_23,
    //        tema_24,tema_25,tema_26,tema_27,tema_28,tema_29,tema_30,tema_31,tema_32,tema_33,tema_34,
    //        tema_35,tema_36,tema_37,tema_38,tema_39,tema_40,tema_41,tema_42,tema_43,tema_44,tema_45,
    //        tema_46,tema_47,tema_48, tema_49, tema_50 FROM $sql_disciplina
    //        JOIN students ON students.id = $sql_disciplina.id
    //        WHERE students.name = '$name'";
    //        // echo $sqll;
    //    $info = mysqli_query($connect, $sqll);
    //    $info = mysqli_fetch_all($info);
    //    foreach ($info as $items) {
    //        if ($items[0] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[1] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[2] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[3] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[4] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[5] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[6] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[7] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[8] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[9] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[10] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[11] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[12] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[13] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[14] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[15] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[16] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[17] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[18] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[19] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[20] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[21] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[22] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[23] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[24] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[25] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[26] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[27] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[28] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[29] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[30] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[31] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[32] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[33] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[34] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[35] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[36] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[37] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[38] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[39] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[40] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[41] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[42] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[43] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[44] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[45] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[46] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[47] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[48] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[49] == 'Н') {
    //            $str = $str.'Н';
    //        }if ($items[50] == 'Н') {
    //            $str = $str.'Н';}}
    //        if ($str == '') {
    //            $str == '0';}
    //            return strlen($str)/2;}
    //function createStudentPersonalStats($name,$connect) { //функция, формирующая данные для "таблицы со статистикой по всем предметам"
    //    global $group_array;
    //    $group_array[$name] = array(
    //        'Математика' => count_H_in_str($name, $connect,'disciplina_1'),
    //        'Русский язык' => count_H_in_str($name, $connect,'disciplina_2'),
    //        'Физика' => count_H_in_str($name, $connect,'disciplina_3'),
    //        'Литература' => count_H_in_str($name, $connect,'disciplina_4'),
    //        'Черчение' => count_H_in_str($name, $connect,'disciplina_5'),
    //        'Физкультура' => count_H_in_str($name, $connect,'disciplina_6'),
    //        'Биология' => count_H_in_str($name, $connect,'disciplina_7'),
    //        'Химия' => count_H_in_str($name, $connect,'disciplina_8'),
    //        'История' => count_H_in_str($name, $connect,'disciplina_9'),
    //        'Технология' => count_H_in_str($name, $connect,'disciplina_10'));}

$disciplinaCookie = $_COOKIE['sql_disciplina'];
$banTems = array();
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
                    <a href="../logout.php" onclick="logout()" class="link-nav logoutBtn">
                        Выйти
                    </a>
                    <a href="../select_disciplina/select_disciplina.php"class="link-nav">
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
                        <li></li>
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
            <div class="left-content">
                <?php
                $sql = "SELECT completed_state FROM `lessons_hours` WHERE discName = '$discTeacher'";
                $json = mysqli_query($connect, $sql);
                $json = mysqli_fetch_all($json);
                ?>
                <textarea type="text" id="json_completed" class="invisibleTextarea" style="display: none" ><?=$json[0][0]?></textarea>
                <table id="main_table">
                        <tr>
                            <th style="background: rgb(150,220,253); "><?=$groupName?></th>
                            <?php
                                $query = "SELECT * FROM `lessons_hours` WHERE lessons_hours.discName = ? AND lessons_hours.group_number = ?;";
                                $stmt = mysqli_prepare($connect, $query);
                                mysqli_stmt_bind_param($stmt, "ss", $discTeacher,$groupName);
                                mysqli_stmt_execute($stmt);
                                $list = mysqli_stmt_get_result($stmt);
                                $list = mysqli_fetch_all($list);
                                $t=1;
//                                while ($t <= $list[0][8] / 2) {
//                                    if ($json_data["tema_$t"]['complete'] == 0) {
//                                        echo "<th id='tema$t'class=\"thMainTable\">$t</th>";
//                                        echo "<div class=\"modal\" id='modal$t'>";
//                                        echo "<div class=\"header-modal\">";
//                                        echo "<span>Тема №$t</span>";
//                                        echo "<span class=\"closeBtn\" id=\"btn$t\">&times;</span>";
//                                        echo "</div>";
//                                        echo "<input class=\"inputComplete\" value=\"1111-11-11\" type=\"date\" id=\"input$t\" placeholder=\"Дата урока\">";
//                                        echo "<button id=\"completeBtn$t\" class=\"completeBtn\">Завершить урок</button>";
//                                        echo "</div>";
//                                    } else {
//                                        $date = $json_data["tema_$t"]['date'];
//                                        array_push($banTems, $t);
//                                        echo "<th id='tema$t' class='thMainTable' style='background-color: rgb(182,215,255);cursor: pointer;'>$t</th>";
//                                        echo "<div class=\"modal\" id='modal$t'>";
//                                        echo "<div class=\"header-modal\">";
//                                        echo "<span style='font-weight: 600'>Тема №$t</span>";
//                                        echo "<span class=\"closeBtn\" id=\"btn$t\">&times;</span>";
//                                        echo "</div>";
//                                        echo "<span>Тема завершена $date</span>";
//                                        echo "</div>";
//                                    }
//                                    $t++;
//                                }
//                                while ($t <= $list[0][9] / 2 + $list[0][8] / 2) {
                                  while ($t <= $list[0][6] / 2) {
                                    if ($json_data["tema_$t"]['complete'] == 0) {
                                        echo "<th id='tema$t'class=\"thMainTable\" >$t</th>";
                                        echo "<div class=\"modal\" id='modal$t'>";
                                        echo "<div class=\"header-modal\">";
                                        echo "<span>Тема №$t</span>";
                                        echo "<span class=\"closeBtn\" id=\"btn$t\">&times;</span>";
                                        echo "</div>";
                                        echo "<input class=\"inputComplete\" value=\"1111-11-11\" type=\"date\" id=\"input$t\" placeholder=\"Дата урока\">";
                                        echo "<button id=\"completeBtn$t\" class=\"completeBtn\">Завершить урок</button>";
                                        echo "</div>";
                                    } else {
                                        $date = $json_data["tema_$t"]['date'];
                                        array_push($banTems, $t);
                                        echo "<th id='tema$t' class='thMainTable' style='background-color: rgb(182,215,255);cursor: pointer;' >$t</th>";
                                        echo "<div class=\"modal\" id='modal$t'>";
                                        echo "<div class=\"header-modal\">";
                                        echo "<span style='font-weight: 600'>Тема №$t</span>";
                                        echo "<span class=\"closeBtn\" id=\"btn$t\">&times;</span>";
                                        echo "</div>";
                                        echo "<span>Тема завершена $date</span>";
                                        echo "</div>";
                                    }

                                    $t++;
                                }
                            ?>

                        </tr>
                    <?php
                        $sql = "SELECT * FROM `students` JOIN disciplina_$number_table ON students.id = disciplina_$number_table.id
                        WHERE students.group_number = '$groupName' ORDER BY students.name";
                        $info = mysqli_query($connect, $sql);
                        $info = mysqli_fetch_all($info);

                        mysqli_close($connect);


                    foreach ($info as $item) {
                            ?>
                            <tr class="trMainTable">
                                <td class="name_for_js" id="<?=$item[0]?>" onclick="showPersonStats(<?=$item[0]?>)"><?=$item[1]?></td>
                                <?php
                                $td = 4;
                                $numberCletki = 1;
//                                while ($td <= ($list[0][8] / 2 + $list[0][9] / 2) + 3) {
                                while ($td <= ($list[0][6] / 2) + 3) {
                                    if (!in_array($numberCletki,$banTems)) {
                                        echo "<td><textarea onclick='putH(this)' class='Н_$item[0]_$numberCletki' spellcheck='false' maxlength='1'value=''>$item[$td]</textarea></td>";
                                    } else {
                                        echo "<td><textarea class='Н_$item[0]_$numberCletki' spellcheck='false' maxlength='1' readonly style='background: rgb(234, 234, 234); cursor: default'>$item[$td]</textarea></td>";
                                    }
                                    $td++;
                                    $numberCletki++;
                                }
                                ?>
                            </tr>
                            <?php
                        }
                    ?>
                </table>
            </div>
            <div class="right-content">
                <div class="right-content-top"></div>
                <div class="right-content-bottom">
                    <form action='update.php' method='post'>
                        <h3>Обновить данные:</h3>
                        <select id="selectUpdateGroup" onchange="SaveValueDiscLS(this)">
                        <?php foreach($listGroupUnique as $groupForSelect2) { // заполняем select группами
                            echo "<option value='$groupForSelect2'>$groupForSelect2</option>";
                        }?>
                        </select>
                        <textarea type="text" id="disciplinaName" name="disciplinaName" class="invisible"></textarea>
                        <textarea name='SfQL' type="text"  id='toSQLinput' class="invisible"></textarea>
                        <textarea name='cmplt' type="text"  id='completionInput' class="invisible"></textarea>
                        <button type="submit" id="updateBtn" class="form-button" onclick="toSQL() putJsonInCompleteInput()">Обновить</button>
                    </form>
<!--                </div>-->
            </div>
        </div>
    </div>
<script src="js.js"></script>
<script src="main.js"></script>
</body>
</html>