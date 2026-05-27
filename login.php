<?php
session_start();
include('bd.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    if (empty($login)) {
        $error = 'Логин не может быть пуст';
    } elseif (empty($password)) {
        $error = 'Пароль не может быть пуст';
    } else {

        // Безопасный запрос
        $stmt = $con->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            $password_valid = false;

            // Проверка хешированного пароля
            if (password_verify($password, $user['password'])) {
                $password_valid = true;
            }
            // Если пароль старый (без хеша)
            elseif ($password === $user['password']) {
                $password_valid = true;

                // Автоматически хешируем
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $update = $con->prepare("UPDATE users SET password = ? WHERE id = ?");
                $update->bind_param("si", $hashed, $user['id']);
                $update->execute();
                $update->close();
            }

            if ($password_valid) {

                // Сохраняем данные в сессию
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['role'] = $user['role'];

                // Перенаправление по роли
                if ($user['role'] === 'admin') {
                    header("Location:adminpanel.php");
                    exit();
                }

                if ($user['role'] === 'employee') {
                    header("Location: employee.php");
                    exit();
                }

                header("Location:profile.php");
                exit();
            } else {
                $error = 'Неверный логин или пароль';
            }

        } else {
            $error = 'Неверный логин или пароль';
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="auth-section">
    <div class="container auth-container">

        <div class="auth-form">
            <h2>Авторизация</h2>

            <form method="POST" class="form-grid">

                <div class="form-row">
                    <label>Логин</label>
                    <input required type="text" name="login" value="<?= isset($login) ? htmlspecialchars($login) : '' ?>">
                </div>

                <div class="form-row">
                    <label>Пароль</label>
                    <input required 
                           type="password" 
                           name="password"
                           minlength="6">
                </div>

                <div class="form-row button-row">
                    <label></label>
                    <button type="submit">Войти</button>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="error-message">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

            </form>
        </div>

        <div class="auth-image">
            <img src="img/регистрация.jpg" alt="Авторизация">
        </div>

    </div>
</section>

</body>
</html>