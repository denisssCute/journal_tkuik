<?php
require_once '../vendor/connect.php';

session_start();

if ($_SESSION['loggedin'] == false || !isset($_SESSION['id'])) {
    header('Location: ../index.php');
}

if(isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > 4800) {
        header('Location: ../logout.php');
    }
}

$_SESSION['last_activity'] = time();

$number_table = $_SESSION['number_table'];
$idTeacher = $_SESSION['id'];
$discTeacher = $_SESSION['disciplina'];
$nameTeacher = $_SESSION['name_teacher'];

$listGroup = mysqli_query($connect, "SELECT lessons_hours.group_number FROM lessons_hours WHERE lessons_hours.discName = '$discTeacher';");
$listGroup = mysqli_fetch_all($listGroup);
$listGroupUnique = array();

$listGroupWhoAlreadyExists = mysqli_query($connect, "SELECT students.group_number FROM students JOIN disciplina_$number_table ON students.id = disciplina_$number_table.id;");
$listGroupWhoAlreadyExists = mysqli_fetch_all($listGroupWhoAlreadyExists);
$listGroupWhoAlreadyExistsUnique = array();

foreach($listGroup as $itemListGroup) {
    foreach ($itemListGroup as $item) {
        $listGroupUnique[] = $item;
    }
}
$listGroupUnique = array_unique($listGroupUnique);


/*
 * НИЖЕ ВСЕВОЗМОЖННЫЕ ОБРАБОТКИ МАССИВОВ. В ИТОГЕ МЫ ПОЛУЧАЕМ ЧИСТЫЕ МАССИВЫ
 */
//foreach($listGroupWhoAlreadyExists as $itemWhoAlreadyExists) {
//    foreach ($itemWhoAlreadyExists as $itemWAE) {
//        $listGroupWhoAlreadyExistsUnique[] = $itemWAE;
//    }
//}
//
//$listGroupWhoAlreadyExistsUnique = array_unique($listGroupWhoAlreadyExistsUnique);
//
//
//foreach ($listGroupWhoAlreadyExistsUnique as $i) {
//    if (in_array($i,$listGroupUnique)) {
//        unset($listGroupUnique[array_search($i,$listGroupUnique)]);
//    }
//}

$data = $_POST;



if (isset($data['do_create_pasport'])) {
    $name_student = $data['name_student'];
    $query2 = "INSERT INTO `students` (`id`, `name`, `group_number`) VALUES (NULL, ?, ?)";
    $stmt = mysqli_prepare($connect, $query2);
    mysqli_stmt_bind_param($stmt,"ss", $data['name_student'], $data['group_number']);
    mysqli_stmt_execute($stmt);

    $brNum = $data['group_number'];
    $listId = mysqli_query($connect, "SELECT students.id FROM students WHERE students.name = '$name_student' AND students.group_number = '$brNum';");
    $listId = mysqli_fetch_all($listId);
    $id = $listId[0][0];
    mysqli_query($connect, "INSERT INTO disciplina_$number_table (id) VALUES ($id);");
    unset($_SESSION['zero_in_table']);
    $_SESSION['group_added'] = true;

    header('Location: ../main_content/select.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../main_content/css.css">
    <title>Добавить группу</title>
</head>
<body>
<a href="../main_content/select.php" class="link-nav" style="position: absolute; padding: 10px 15px; top: 10px;left: 10px; font-size: 18px">Назад</a>
<div class="container-add-group-main">

    <div class="modal-win" style="width: 580px;font-family: sans-serif">
        <form action="add_student.php" method="post" class="pasport_form">
            <h2 align="left" style="margin-bottom: 25px">Добавить студента</h2>
            <div class="form-group add_disc_header">
                <input type="text" name="name_student" class="form-input" id="inputGroup" style="padding: 10px 0px;font-size: 18px" placeholder=" ">
                <label class="form-label" >ФИО студента</label>
                <select name="group_number" id="search_group" style="margin: 0;max-width: 120px;border-radius: 6px;outline: none;border: 1px solid black; padding: 10px;">
                    <option value="Группа">Группа</option>
                    <?php foreach($listGroupUnique as $group) { // заполняем select группами
                        echo "<option value='$group'>$group</option>";
                    }?>
                </select>
            </div>
            <input type="text" class="invisible" name="jsondisc" id="jsoninput" value="">
            <button name="do_create_pasport" name="do_pasport" id="create_pasport" class="form-button">Добавить студента</button>
        </form>
    </div>
</div>


<script src="../main_content/js.js"></script>
</body>
</html>