<?php function logging()
{
    session_start();
    $con = mysqli_connect("db", "user", "password", "appDB");
    if (mysqli_connect_error()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    //$result = $con->query("SELECT * FROM accounts");
    if (isset($_POST["register-btn"])) {
        header('Location: register.php');
    }
    if (isset($_POST["login-btn"])) {
        if (empty($_POST['usname']) || empty($_POST['paswd'])) {
            echo '<script>alert("Please fill both the username and password fields!")</script>';
        } else {
            if ($stmt = $con->prepare('SELECT username, passwords FROM accounts WHERE username=?')) {
                $stmt->bind_param('s', $_POST['usname']);
                $stmt->execute();
                $stmt->store_result();
                //$result = $stmt->get_result();
                if ($stmt->num_rows) {
                    $stmt->bind_result($id, $password);
                    $stmt->fetch();
                    if ($_POST['paswd'] === $password) {
                        session_regenerate_id();
                        $_SESSION['loggedin'] = TRUE;
                        $_SESSION['name'] = $_POST['usname'];
                        $_SESSION['id'] = $id;
                        $_SESSION['pass'] = $password;
                        header('Location: index.html');
                    } else {
                        echo '<script>alert("Неправильный логин или пароль")</script>';
                    }
                } else {
                    echo '<script>alert("Неправильный логин или пароль")</script>';
                }
                $stmt->close();
            }
        }
    }
    if (isset($_POST["register-confirm-btn"])) {
        if (empty($_POST['username']) || empty($_POST['passwd'])) {
            echo '<script>alert("Пожалуйста введите пароль или имя пользователя")</script>';
        } else if (empty($_POST['email'])) {
            echo '<script>alert("Пожалуйста, введите email")</script>';
        } else if (empty($_POST["passwd-confirm"])) {
            echo '<script>alert("Пожалуйста, подвердите пароль")</script>';
        } else if ($_POST["passwd"] !== $_POST["passwd-confirm"]) {
            echo '<script>alert("Пароли не совпадают")</script>';
        } else {
            $con = mysqli_connect("db", "user", "password", "appDB");
            $stmt = $con->prepare("SELECT username FROM accounts WHERE username=?");
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows) {
                echo '<script>alert("Пользователь c таким именем уже существует")</script>';
            } else {
                $stmt->close();
                $stmt = $con->prepare("INSERT INTO accounts(username, passwords, email) VALUES (?, ?, ?)");
                $stmt->bind_param('sss', $_POST['username'], $_POST['passwd'], $_POST['email']);
                $stmt->execute();
                $stmt->close();
                header('Location: index.php');
            }
        }
    }
}
?>