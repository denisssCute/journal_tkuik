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
$countStudInTable = mysqli_query($connect, "SELECT COUNT(*) FROM disciplina_$number_table ;");
$countStudInTable = mysqli_fetch_all($countStudInTable);
$c = intval($countStudInTable[0][0]);
if ($c === 0 ) {
    $_SESSION['zero_in_table'] = true;
    header('Location: ../main_content/select.php');
    exit();
}

unset($_SESSION['zero_in_table']);

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
foreach($listGroupWhoAlreadyExists as $itemWhoAlreadyExists) {
    foreach ($itemWhoAlreadyExists as $itemWAE) {
        $listGroupWhoAlreadyExistsUnique[] = $itemWAE;
    }
}

$listGroupWhoAlreadyExistsUnique = array_unique($listGroupWhoAlreadyExistsUnique);


foreach ($listGroupWhoAlreadyExistsUnique as $i) {
    if (in_array($i,$listGroupUnique)) {
        unset($listGroupUnique[array_search($i,$listGroupUnique)]);
    }
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
    <div class="container-add-group-main">
        <div class="add-group-container">
            <div class="add-group-header">
                <div class="header">
                <div class="left-content-header add_container">
                    <div class="back_container">
                        <a href="../main_content/select.php" class="form-button backBtn">
                            Назад
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
                <form action="add_script.php" class="show_group" method="post">
                    <select name="showGroupNumber" id="search_group" onchange="showGroupAdd(this)">
                        <option >Выбрать группу</option>
                        <?php
                        $students = array();

                        foreach($listGroupUnique as $group) {

                            $query = "SELECT students.group FROM `students` WHERE students.group_number = ?;";
                            $stmt = mysqli_prepare($connect, $query);
                            mysqli_stmt_bind_param($stmt, "s", $group);
                            mysqli_stmt_execute($stmt);
                            $result1 = mysqli_stmt_get_result($stmt);
                            $result1= mysqli_fetch_all($result1);
                            if (empty($result1)) {
                                $_SESSION['zero_in_table'] = true;
                                header('Location: ../main_content/select.php');
                                exit();
                            }

                            $query = "SELECT students.name, students.group_number FROM `students` WHERE students.group_number = ?;";
                            $stmt = mysqli_prepare($connect, $query);
                            mysqli_stmt_bind_param($stmt, "s", $group);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $result = mysqli_fetch_all($result);

                            $students = array_merge($students,$result);


                            echo "<option>$group</option>";
                        }?>
                    </select>
                    <button class="search_btn form-button" type="submit">Добавить</button>
                </form>
        </div>
            </div>
            <div class="add-group-content">
                <?php
//                $studentsSQL = "SELECT students.name, students.group_number FROM `students` WHERE students.group_number = '$group';";
//                $students = mysqli_query($connect, $studentsSQL);
//                $students = mysqli_fetch_all($students);
//echo "SELECT students.name, students.group_number FROM `students` WHERE students.group_number = $group;";echo "SELECT students.name, students.group_number FROM `students` WHERE students.group_number = $group;";
                foreach ($students as $student) {
                    $name = $student[0];
                    $group = $student[1];
                    echo "<p class='stud-item invisible G$group'>$name</p>";
                }
                ?>
            </div>
        </div>
    </div> 


<script src="../main_content/js.js"></script>
</body>
</html>