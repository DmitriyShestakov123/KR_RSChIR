<?php
require('utils/user.php');
require('utils/surveyUtils.php');
session();
addSurvey();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Создать опрос</title>
	<link href="styles/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<link rel="icon" type="image/png" href="favicon.png" />
    <link rel="stylesheet" href=
"//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href=
"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
</head>

<body class="loggedin" style="background-color: #435165;">
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
        <h1>Создание опроса</h1>
        <form method="post">
            <div class="col-lg-12">
                <input type="text" class="form-control m-input" name="surveyName" placeholder="Название"  method="post">
                <div id="row">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button
                                id="DeleteRow" type="button">
                                <i class="bi-trash"></i>
                                Удалить
                            </button>
                        </div>
                        <input type="text"
                            class="form-control m-input" method="post" name="0">
                    </div>
                </div>
                <div id="newinput"></div>
                <div style="width:100%" class="input-group"><button id="rowAdder" type="button"
                    class="btn btn-dark">
                    <span class="bi bi-plus-square-dotted">
                    </span> Добавить
                </button></div>
                <div class="div-submit">
                    <input type="submit" value="Добавить Опрос" class="btn" name="make-survey-btn" method="post"/>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        var id = 1;
        $("#rowAdder").click(function () {
            newRowAdd =
            '<div id="row"> <div class="input-group">' +
            '<div class="input-group-prepend">' +
            '<button id="DeleteRow" type="button">' +
            '<i class="bi bi-trash"></i>Удалить</button> </div>' +
            '<input name=' + '\"' + id + '\"' + ' type="text" class="form-control m-input" method="post"> </div> </div>';
 
            $('#newinput').append(newRowAdd);
            id += 1;
        });
 
        $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        })
    </script>
</body>