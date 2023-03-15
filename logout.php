<?php

session_start();
$_SESSION['loggedin'] = false;

$id = $_SESSION['id'];

if (isset($id)) { //РАЗЛОГИНИВАНИЕ ПОЛЬЗОВАТЕЛЯ
    unset($_SESSION['id']);
    unset($_SESSION['disciplina']);
    unset($_SESSION['number_table']);
    unset($_SESSION['none_disc']);
    unset($_SESSION['pasport_created']);
}
header('Location: index.php');
