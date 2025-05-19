<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
$session_started = false;
if (session_start()) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
    // Если есть логин в сессии, то пользователь уже авторизован.
    // Делаем перенаправление на форму.
    header('Location: ./');
    exit();
  }
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
<div class="auth-section">
    <form method="POST" class="auth-form">
        <h3>Вход в систему</h3>
        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <div class="form-group">
            <label for="login">Логин:</label>
            <input type="text" id="login" name="login" required>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="auth-btn">Войти</button>
    </form>
</div>
<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.

  // Подключение к БД
    $user = 'u68891'; 
    $pass = '3849293'; 
    try {
        $db = new PDO('mysql:host=localhost;dbname=u68891', $user, $pass, [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Проверка логина и пароля
        $stmt = $db->prepare("SELECT id, password_hash FROM users WHERE username = ?");
        $stmt->execute([$_POST['login']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && md5($_POST['password']) === $user['password_hash']) {
            // Успешная авторизация
            if (!$session_started) {
                session_start();
            }
              // Если все ок, то авторизуем пользователя.
            $_SESSION['login'] = $_POST['login'];
              // Записываем ID пользователя.
            $_SESSION['uid'] = $user['id'];
            
            // Перенаправление на главную
            header('Location: index.php');
            exit();
        } else {
            // Неверный логин/пароль
            $error = "Неверный логин или пароль";
        }
    } catch (PDOException $e) {
        $error = "Ошибка базы данных: " . $e->getMessage();
    }
}
