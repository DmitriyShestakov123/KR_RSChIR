<?php
function getStatus()
{
    $con = mysqli_connect("db", "user", "password", "appDB");
    $getStatus = $con->prepare("SELECT administrator FROM accounts WHERE username=?");
    $getStatus->bind_param('s', $_SESSION['name']);
    $getStatus->execute();
    $result = $getStatus->get_result();
    $row = $result->fetch_assoc();
    if ($row['administrator'] == 1) {
        $admin = 'Администратор';
    } else {
        $admin = 'Пользователь';
    }
    return $admin;
}


function session()
{
    // We need to use sessions, so you should always start sessions using the below code.
    if (!isset($_SESSION)) {
        session_start();
    }
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit;
    }
    header('Content-Type: text/html; charset=utf8');

    if (isset($_POST["submitpassword"])) {
        $con = mysqli_connect("db", "user", "password", "appDB");
        if (mysqli_connect_errno()) {
            exit('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
        $username = $_SESSION['name'];
        $password = $_SESSION['pass']; // старый пароль из БД
        $oldPassword = $_POST['passwd'];
        $newPassword = $_POST['new_passwd'];
        $newPasswordConfirm = $_POST['new_passwd_confirm'];
        if (empty($_POST['passwd'])) {
            echo '<script>alert("Пожалуйста, введите старый пароль")</script>';
        } else if ($_POST['passwd'] != $_SESSION['pass']) {
            echo '<script>alert("Неправильный пароль")</script>';
        } else if (empty($_POST['new_passwd'])) {
            echo '<script>alert("Пожалуйста, введите новый пароль")</script>';
        } else if (empty($_POST['new_passwd_confirm'])) {
            echo '<script>alert("Пожалуйста, подтвердите новый пароль")</script>';
        } else if ($_POST['new_passwd'] != $_POST['new_passwd_confirm']) {
            echo '<script>alert("Пароли не совпадают")</script>';
        } else if ($oldPassword === $password && $newPasswordConfirm === $newPassword) {
            $stmt = $con->prepare("UPDATE users SET passwords=? WHERE username=?");
            $stmt->bind_param('ss', $_POST['new_passwd'], $username);
            $stmt->execute();
        }
    }
    if (isset($_POST["login-btn"])) {
        echo $_POST['usname'], "<br>";
    }

}
?>