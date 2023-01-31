<?php
require('utils/logging.php');
logging();
?>
<!DOCTYPE html>
<html>
<head lang>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Сервис опросов</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" type="image/png" href="favicon.png"/>
</head>
<body>
    <div class="container">
        <div class="container2">
            <a href="index.php"><button class='back-btn'>< назад</button></a>
            <div class="login">
                <form method = "post">
                    <div class="form-input">
                        <input type="text" name="username" placeholder="Логин"/>	
                    </div>
                    <div class="form-input">
                        <input type="text" name="email" placeholder="E-mail"/>
                    </div>
                    <div class="form-input">
                        <input type="Password" name="passwd" placeholder="Пароль"/>
                    </div>
                    <div class="form-input">
                        <input type="Password" name="passwd-confirm" placeholder="Подтвердите пароль"/>
                    </div>
                        <input type="submit" value="Регистрация" class="btn-login" name ="register-confirm-btn"/>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
?>