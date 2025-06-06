<!DOCTYPE html>
<html lang="ru">
   <head>
      <meta charset="utf-8">
      <title>Задание 5</title>
      <link rel="stylesheet" href="style.css">
   </head>
   <body>
      <?php 
         if (!empty($messages)) {
             print('<div id="messages">');
             foreach($messages as $message) {
                 print($message);
             }
             print('</div>');
         }
         ?>
      <div class="auth-section">
         <?php if (!empty($_SESSION['login'])): ?>
         <div class="auth-info">
            Вы вошли как: <strong><?= htmlspecialchars($_SESSION['login']) ?></strong>
            <a href="logout.php" class="logout-btn">Выйти</a>
         </div>
         <?php else: ?>
         <form method="POST" class="auth-form">
            <?php if (!empty($auth_error)): ?>
            <div class="error"><?= $auth_error ?></div>
            <?php endif; ?>
            <?php if (!empty($_COOKIE['login']) && !empty($_COOKIE['password'])): ?>
            <div class="auth-hint">
               Ваши данные для входа:<br>
               Логин: <?= htmlspecialchars($_COOKIE['login']) ?><br>
               Пароль: <?= htmlspecialchars($_COOKIE['password']) ?>
            </div>
            <?php endif; ?>
            <a href='login.php' class='auth-btn'>Войти для изменения данных</a>
         </form>
         <?php endif; ?>
      </div>
      <div class="formular">
         <form action="" method="POST">
            <h2>Анкета</h2>
            <div class="container">
               <label for="name">ФИО:</label>
               <input type="text" id="name" name="name" maxlength="100"
                  <?php if ($errors['name']) { print 'class="error"'; } ?> 
                  value="<?php print htmlspecialchars($values['name'] ?? ''); ?>">
            </div>
            <div class="container">
               <label for="phone">Телефон:</label>
               <input type="tel" id="phone" name="phone"
                  <?php if ($errors['phone']) { print 'class="error"'; } ?> 
                  value="<?php print htmlspecialchars($values['phone'] ?? ''); ?>">
            </div>
            <div class="container">
               <label for="email">E-mail:</label>
               <input type="email" id="email" name="email"
                  <?php if ($errors['email']) { print 'class="error"'; } ?> 
                  value="<?php print htmlspecialchars($values['email'] ?? ''); ?>">
            </div>
            <div class="container">
               <label for="birthdate">Дата рождения:</label>
               <input type="date" id="birthdate" name="birthdate"
                  <?php if ($errors['birthdate']) { print 'class="error"'; } ?> 
                  value="<?php print htmlspecialchars($values['birthdate'] ?? ''); ?>">
            </div>
            <div class="container">
               <label>Пол:</label>
               <div id="gender">
                  <input type="radio" id="male" name="gender" value="male"
                     <?php if (($values['gender'] ?? '') == 'male') { print 'checked'; } ?>>
                  <label for="male">Мужской</label>
                  <input type="radio" id="female" name="gender" value="female"
                     <?php if (($values['gender'] ?? '') == 'female') { print 'checked'; } ?>>
                  <label for="female">Женский</label>
               </div>
            </div>
            <div class="container">
               <label for="languages">Любимый язык программирования:<br></label>
               <select id="languages" name="languages[]" multiple 
                  <?php if ($errors['languages']) { print 'class="error"'; } ?>>
               <?php
                  $allLanguages = ['Pascal', 'C', 'C++', 'JavaScript', 'PHP', 'Python', 'Java', 'Haskel', 'Clojure', 'Prolog', 'Scala', 'Go'];
                  $selectedLanguages = is_array($values['languages']) ? $values['languages'] : [];
                  
                  foreach ($allLanguages as $lang) {
                      echo '<option value="' . htmlspecialchars($lang) . '"';
                      if (in_array($lang, $selectedLanguages)) {
                          echo ' selected';
                      }
                      echo '>' . htmlspecialchars($lang) . '</option>';
                  }
                  ?>
               </select>
            </div>
            <div class="container">
               <label for="bio">Биография:<br></label>
               <textarea id="bio" name="bio" rows="4"
                  <?php if ($errors['bio']) { print 'class="error"'; } ?>><?php print htmlspecialchars($values['bio'] ?? ''); ?></textarea>
            </div>
            <div class="container">
               <label>
               <input type="checkbox" name="agreement" value="1"
                  <?php if ($values['agreement']) { print 'checked'; } ?>>
               С контрактом ознакомлен(а)
               </label>
            </div>
            <div class="container"> 
               <button type="submit" id='send_btn'>Отправить</button>
            </div>
         </form>
      </div>
   </body>
</html>