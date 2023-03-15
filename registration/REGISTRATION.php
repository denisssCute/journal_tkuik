<?php
require_once '../vendor/connect.php';
require '../vendor/db_for_rb.php';

$data = $_POST;
$errors = array();
if (isset($data['do_login'])) {
    if ($data['name'] == '') {
        $errors[] = 'Введите имя!';
    }
    if ($data['jsondisc'] == '') {
        $errors[] = 'Введите дисциплину 1!';
    }
    if ($data['login'] == '') {
        $errors[] = 'Введите логин!';
    }
    if ($data['password'] == '') {
        $errors[] = 'Введите пароль!';
    }
    
    if(empty($errors)) {

        $stmt = $connect->prepare("INSERT INTO teachers (id, name, disciplins, login, password) VALUES (NULL, ?, ?, ?, ?)");
        $stmt->bind_param("ssss", $data['name'], $data['jsondisc'], $data['login'],password_hash($data['password'], PASSWORD_DEFAULT));
        $stmt->execute();
        $stmt->close();
        header('Location: ../index.php');
//        $user = R::dispense('teachers');
//        $user->name = $data['name'];
//        $user->disciplina = $data['jsondisc'];
//        $user->login = $data['login'];
//        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
//        R::store($user);
    } else {
        echo array_shift($errors);
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../index.css">
    <title>Журнал</title>
</head>
<body>
    <div class="container">
        <div class="reg-win">
            <form class="form-main" action="REGISTRATION.php" method="post">
                <h1 class="form-title">Регистрация</h1>
                <div class="form-group">
                    <input type="text" class="form-input" name="name" id="nameInput" placeholder=" ">
                    <label class="form-label">Фамилия Имя Отчество</label>
                </div>
                <div class="form-group">

                    <div class="add_disc_header">
                        <input class="form-input discInput" id="inputDisc" type="text" name="disciplins_input" placeholder=" ">
                        <label class="form-label">Название предмета</label>
                        <span class="form-button addDiscBtn" onclick="addDisc()">Добавить</span>
                    </div>
                    <div style="display: flex; justify-content: left; margin-bottom: 7px">
                        <span align="left" style="text-decoration: underline; font-family: Calibri; font-weight: 600">Предметы</span>
                    </div>
                    <ol class="disciplins-ul" id="ulDisc"></ol>
                </div>
                <div class="form-group">
                    <input type="text" class="form-input" id="login" name="login" placeholder=" ">
                    <label class="form-label">Логин</label>
                </div>
                <div class="form-group">
                    <input type="text" class="form-input" id="password" name="password" placeholder=" ">
                    <label class="form-label">Пароль</label>
                </div>
                <input type="text" class="invisible" name="jsondisc" id="jsoninput" value="">
                <button class="form-button" id="to_main" name="do_login" type="submit">Зарегистрировать</button>
            </form>
        </div>
        <p class="go-to-reg-text">Уже есть аккаунт? <a href="../index.php">Войдите</a></p>
    </div>
<script src="registration.js"></script>
</body>
</html>