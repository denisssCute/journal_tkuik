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

$groupNumber = $_POST['showGroupNumber'];
$numberTable = $_SESSION['number_table'];

$listId = mysqli_query($connect, "SELECT students.id FROM students WHERE students.group_number = '$groupNumber';");
$listId = mysqli_fetch_all($listId);

foreach ($listId as $id) {
    mysqli_query($connect, "INSERT INTO disciplina_$numberTable (id) VALUES ($id[0]);");
//    echo "INSERT INTO disciplina_$numberTable (id) VALUES ($id[0]);";
}
header('Location: add.php');