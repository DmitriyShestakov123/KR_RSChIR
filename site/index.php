<?php
error_reporting(-1);
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
            <div class="login">
                <form method = "post">
                    <div class="form-input">
                        <input type="text" name="usname" placeholder="Логин"/>	
                    </div>
                    <div class="form-input">
                        <input type="Password" name="paswd" placeholder="Пароль"/>
                    </div>
                    <input type="submit" value="ЛОГИН" class="btn-login" name ="login-btn"/>
                    <input type="submit" value="РЕГИСТРАЦИЯ" class="btn-login" name="register-btn"/>
                </form>
            </div>
        </div>
    </div>
</body>
</html>