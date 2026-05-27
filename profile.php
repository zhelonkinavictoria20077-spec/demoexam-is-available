<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$fullname = $_SESSION['fullname'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Личный кабинет — МФЦ</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="container header">

        <div class="logo">
            Система организации записи на посещение МФЦ
        </div>

        <nav class="nav">

            <a href="createappointment.php" class="nav-link">
                Записаться на посещение
            </a>

            <a href="history.php" class="nav-link">
              Мои посещения

            </a>

            <span class="user-name">
                <?php echo htmlspecialchars($fullname); ?>
            </span>

            <a href="index.php" class="login">
                Выйти
            </a>

        </nav>

    </div>
</header>

<main>
<section class="profile-section">
    <div class="container profile-container">

        <p class="welcome-text">
            Добро пожаловать, <strong><?php echo htmlspecialchars($fullname); ?></strong>.
        </p>

        <p class="welcome-subtext">
            Здесь вы можете записаться на посещение МФЦ, выбрать удобную дату и время,
            а также отслеживать статус вашей записи в личном кабинете.
        </p>

        <div class="profile-image">
            <img src="img/профиль.png" alt="Личный кабинет МФЦ" />
        </div>

    </div>
</section>
</main>

<footer>
    <div class="container footer">
        Контакты: р.п. Шемышейка, ул. Ленина, д.10 <br>
        Телефон: +7 (8412) 123-45-20 <br>
        Пн-Пт 8:00–18:00 <br>
        Сб 8:00-13:00
    </div>
</footer>

</body>
</html>