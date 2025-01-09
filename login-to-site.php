<?php
session_start();

if (isset($_SESSION["login"]) && $_SESSION["login"] == "OK") {
    // User is already logged in, redirect to index.php
    header('Location: index.php');
    exit;
} else {
    $email = $_POST["email"] ?? '';
    $pass = $_POST["password"] ?? '';

    if (!(empty($email) && empty($pass))) {
        require_once "./DBs/functions.php";
        
        // Hash the password
        $hashed_password = md5($pass);

        $check = check_user($email, $hashed_password);
        
        // Check for errors in the queries
        if ($check) {
            $_SESSION['login'] = "OK";
            $_SESSION['name'] = $check['name'];
            $_SESSION['id'] = $check['user_id'];
            $_SESSION['email'] = $check['email'];
            header('Location: index.php'); // Try again
        } else {
            // echo "Error: " . mysqli_error($your_database_connection); // Replace with your actual database connection variable
            header('Location: login.php?er="password not correct"'); // Try again
        }
    } else {
        header('Location: signup.php'); // Try again
        exit;
    }
}
?>
