<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fullname = trim($_POST['fullname']);
    $passport_data = trim($_POST['passport_data']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    include('bd.php');

    if($fullname == '') die('ФИО не может быть пустым');
    if($passport_data == '') die('Паспортные данные не могут быть пустыми');
    if($phone == '') die('Телефон не может быть пуст');
    if($email == '') die('Email не может быть пуст');
    if($login == '') die('Логин не может быть пуст');
    if($password == '') die('Пароль не может быть пуст');

    // Проверка формата паспорта
    if(!preg_match("/^\d{4}\s\d{6}\s\d{2}\.\d{2}\.\d{4}$/", $passport_data)) {
        die('Введите паспорт в формате: 0000 000000 01.01.2026');
    }

    // Проверка телефона
    if(!preg_match("/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/", $phone)) {
        die('Телефон должен быть в формате +7(XXX)-XXX-XX-XX');
    }

    // Проверка пароля
    if(strlen($password) < 6) {
        die('Пароль должен содержать минимум 6 символов');
    }

    $query = $con->query("
        INSERT INTO users 
        (fullname, passport_data, phone, email, login, password)
        VALUES 
        ('$fullname', '$passport_data', '$phone', '$email', '$login', '$password')
    ");

    if(!$query) die('query error: ' . $con->error);

    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="auth-section">
    <div class="container auth-container">

        <div class="auth-form">
            <h2>Регистрация</h2>

            <form method="POST" class="form-grid">

<div class="form-row">
    <label>ФИО</label>
    <input required type="text" name="fullname">
</div>

<div class="form-row">
    <label>Паспорт (серия номер дата выдачи)</label>
    <input required 
           type="text" 
           name="passport_data"
          
           pattern="\d{4}\s\d{6}\s\d{2}\.\d{2}\.\d{4}"
           title="Формат: 0000 000000 01.01.2026">
</div>

<div class="form-row">
    <label>E-mail</label>
    <input required type="email" name="email">
</div>

<div class="form-row">
    <label>Телефон</label>
    <input required 
           type="tel" 
           name="phone"
           placeholder="+7(XXX)-XXX-XX-XX"
           pattern="\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}"
           title="Введите телефон в формате +7(XXX)-XXX-XX-XX">
</div>

<div class="form-row">
    <label>Логин</label>
    <input required type="text" name="login">
</div>

<div class="form-row">
    <label>Пароль</label>
    <input required 
           type="password" 
           name="password"
           placeholder="минимум 6 символов"
           title="Минимум 6 символов">
</div>

<div class="form-row button-row">
    <label></label>
    <button type="submit">Зарегистрироваться</button>
</div>

</form>
        </div>

        <div class="auth-image">
            <img src="img/регистрация.jpg" alt="Регистрация">
        </div>

    </div>
</section>

</body>
</html>