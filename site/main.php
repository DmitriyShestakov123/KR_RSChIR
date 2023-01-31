<?php
require('utils/user.php');
require('utils/surveyUtils.php');
session();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Профиль</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="icon" type="image/png" href="favicon.png" />
</head>

<body class="loggedin">
    <nav class="navtop">
        <div>
            <h1>Сервис опросов</h1>
            <a href="main.php"><i class="fas fa-home-alt"></i>Главная</a>
            <a href="profile.php"><i class="fas fa-user-circle"></i>Профиль</a>
            <a href="index.html"><i class="fa-solid fa-circle-info"></i>О нас</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Выйти</a>
        </div>
    </nav>
    <div class="profile">
        <h1 id="heading">Опросы</h1>
        <? showPreview();?>
    </div>
    <footer>
        <p>© 2022 Survey Service</p>
    </footer>
</body>