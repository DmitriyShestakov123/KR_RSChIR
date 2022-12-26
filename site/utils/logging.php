<?php function logging() {
    session_start();
    $con = mysqli_connect("db", "user", "password", "appDB");
    if (mysqli_connect_errno()) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    $result = $con->query("SELECT * FROM accounts");

    if (isset($_POST["login-btn"])) {
        // Could not get the data that should have been sent.
        if (empty($_POST['usname']) || empty($_POST['paswd'])) {
            // Could not get the data that should have been sent.
            echo '<script>alert("Please fill both the username and password fields!")</script>';
        } else {
            if ($stmt = $con->prepare('SELECT username, passwords FROM accounts WHERE username = ?')) {
                // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
                $stmt->bind_param('s', $_POST['usname']);
                $stmt->execute();
                // Store the result so we can check if the account exists in the database.
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($id, $password);
                    $stmt->fetch();
                    // Account exists, now we verify the password
                    if ($_POST['paswd'] === $password) {
                        // Verification success! User has logged-in!
                        // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                        session_regenerate_id();
                        $_SESSION['loggedin'] = TRUE;
                        $_SESSION['name'] = $_POST['usname'];
                        $_SESSION['id'] = $id;
                        $_SESSION['pass'] = $password;
                        header('Location: index.html');
                    } else {
                        echo '<script>alert("incorrect password")</script>';
                    }
                } else {
                    echo '<script>alert("incorrect username")</script>';
                }
                $stmt->close();
            }
        }
    }
}
?>