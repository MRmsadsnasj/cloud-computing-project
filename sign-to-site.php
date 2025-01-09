<?php
session_start();

if (isset($_SESSION["login"]) && $_SESSION["login"] == "OK") {
    // User is already logged in, redirect to index.php
    header('Location: index.php');
    exit;
} else {
    $name = $_POST["name"] ?? '';
    $email = $_POST["email"] ?? '';
    $pass = $_POST["password"] ?? '';

    if (!(empty($name) && empty($email) && empty($pass))) {
        require_once "./DBs/functions.php";

        $cr_table = sql_queies("CREATE TABLE IF NOT EXISTS users (
            user_id INT NOT NULL AUTO_INCREMENT,
            email VARCHAR(100) UNIQUE,
            name VARCHAR(20),
            password VARCHAR(255),
            PRIMARY KEY (user_id)
        )");
        

        // Hash the password
        $hashed_password = md5($pass);

        $add_user = sql_queies("INSERT INTO users (email, name, password) VALUES ('$email', '$name', '$hashed_password')");

        // Check for errors in the queries
        if ($cr_table && $add_user) {
            $_SESSION['login'] = "OK";
            $_SESSION['name'] = $name;
            $_SESSION['id'] = get_id($email);
            $_SESSION['email'] = $email;
            header('Location: index.php'); // Try again
        } else {
            // echo "Error: " . mysqli_error($your_database_connection); // Replace with your actual database connection variable
            header('Location: signup.php'); // Try again
        }
    } else {
        header('Location: signup.php'); // Try again
        exit;
    }
}
?>
