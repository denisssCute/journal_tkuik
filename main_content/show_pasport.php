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

unset($_SESSION['updateIsOK']);

$_SESSION['last_activity'] = time();

$idTeacher = intval($_SESSION['id']);

$nameTeacher = $_SESSION['name_teacher'];

$discTeacher = $_SESSION['disciplina'];

$query = "SELECT lessons_hours.total,lessons_hours.group_number FROM `lessons_hours` WHERE discName = ? AND id_teacher = ?;";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "si", $discTeacher, $idTeacher);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$result = mysqli_fetch_all($result);
$hours = $result[0][0];

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
<a href="../main_content/select.php" class="back-to-login link-nav logoutBtn">
    Назад
</a>
<div class="container-add-group-main">
    <div class="modal-win" style="width: 580px;font-family: sans-serif">
        <form action="pasport.php" method="post" class="pasport_form">
            <h2 align="left" style="text-decoration: underline">Паспорт предмета</h2>
            <p align='left' style="margin: 15px 0 15px 0;max-width: 580px">
                Продолжительность предмета в часах: <b><?=$hours?></b>
            </p>
            <div style="display: flex; justify-content: left; margin-bottom: 7px">
                <span align="left" style="text-decoration: none; font-family: Calibri; font-weight: 600; font-size: 21px;margin-left: 0">Добавленные группы:</span>
            </div>
            <ol class="disciplins-ul" id="ulGroup" style="margin-left: 30px; margin-bottom: 20px" id="ulDisc">
                <?php
                foreach ($result as $group_str) {
                    echo "<li>$group_str[1]</li>";
                }

                ?>
            </ol>
            <!-- <button name="do_create_pasport" name="do_pasport" id="create_pasport" class="form-button">Создать паспорт</button> -->
        </form>
    </div>
</div>

<script src="registration.js"></script>
</body>
</html>