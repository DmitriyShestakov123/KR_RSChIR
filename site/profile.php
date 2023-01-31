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
		<h2>Профиль</h2>
		<div class="profileAndPassword">
			<div class="aboutMe">
				<p style="color=black">Детали аккаунта:</p>
				<table>
					<tr>
						<td>Логин:</td>
						<td><?= $_SESSION['name'] ?></td>
					</tr>
					<tr>
						<td>ID:</td>
						<td><?= $_SESSION['id'] ?></td>
					</tr>
					<tr>
						<td>Статус:</td>
						<td><?= getStatus() ?></td>
					</tr>
				</table>
			</div>
			<form class="change-password" method="POST">
				<p>Смена пароля</p>
				<div class="forminput">
					<input type="Password" name="passwd" placeholder="Старый пароль" />
				</div>
				<div class="forminput">
					<input type="Password" name="new_passwd" placeholder="Новый пароль" />
				</div>
				<div class="forminput">
					<input type="Password" name="new_passwd_confirm" placeholder="Новый пароль" />
				</div>
				<input type="submit" name="submitpassword" value="Подтвердить" />
			</form>

		</div>
		<div class="create-survey">
			<a href="createsurvey.php"><button>Создать опрос</button></a>
		</div>
		<div class='my-serveys'>
			<?php
            function showMySurveys()
            {
	            $mysqli = new mysqli("db", "user", "password", "appDB");
	            $mysqli->set_charset("utf-8");
	            $result = $mysqli->query("SELECT DISTINCT * FROM completed_surveys");
	            echo "<h1>Пройденные опросы</h1>";
	            foreach ($result as $row) {
		            if ($row['username'] == $_SESSION['name']) {
			            echo "<br>";
			            echo "<h2>{$row['surveyName']}</h2>";
		            }
	            }
	            $mysqli->close();
            }
            showMySurveys();
            echo "<br><br>";
            ?>
		</div>
		<div class='my-surveys'>
			<h1>Созданные мною</h1>
			<?php makeOwnResults();
			echo "</div></div>";
			?>
		</div>
		<?php
        if (getStatus() == 'Администратор') {
	        echo "<div class='my-surveys'>";
	        echo "<h1>Результаты опросов</h1>";
	        makeResults();
	        echo "</div>";
        } ?>
	</div>
	<footer>
		<p>© 2022 Servey Service</p>
	</footer>
	<script>
		function myFunction(id) {
			var x = document.getElementById(id).nextSibling;
			if (x.style.display === "none") {
				x.style.display = "block";
			} else {
				x.style.display = "none";
			}
		}
	</script>
</body>

</html>