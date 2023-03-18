<?php

session_start();
$_SESSION['loggedin'] = false;

$id = $_SESSION['id'];

if (isset($id)) { //РАЗЛОГИНИВАНИЕ ПОЛЬЗОВАТЕЛЯ
    session_unset();
    // unset($_SESSION['id']);
    // unset($_SESSION['disciplina']);
    // unset($_SESSION['number_table']);
    // unset($_SESSION['none_disc']);
    // unset($_SESSION['pasport_created']);
    // unset($_SESSION['name_teacher']);
    // unset($_SESSION['zero_in_table']);
    
}
header('Location: index.php');

?>
