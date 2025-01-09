<?php
session_start();

if (isset($_SESSION["login"]) && $_SESSION["login"] == "OK") {
    // User is already logged in, redirect to index.php
    
    $subject = $_POST["subject"] ?? false;
    $explain = $_POST["explain"] ?? false;
    $neccessry = $_POST["necessary_level"] ?? false;
    echo $neccessry;
    $dtime = $_POST["dtime"] ?? false;
    $user_id = $_SESSION['id'] ?? false;
    require_once "./DBs/functions.php";

    $cr_table = sql_queies("CREATE TABLE IF NOT EXISTS works (
        work_id INT NOT NULL AUTO_INCREMENT,
        subject VARCHAR(100),
        explanation VARCHAR(500),  -- Changed from 'explain' to 'explanation'
        neccessry CHAR,
        user_id INT,
        expo_work_datetime DATETIME,

        PRIMARY KEY (work_id),
        FOREIGN KEY (user_id) REFERENCES users(user_id)
    )");

    if ($subject !== false && $explain !== false && $neccessry !== false && $user_id !== false &&
        $subject !== '' && $explain !== '' && $neccessry !== '' && $user_id !== '') {
        
        $add_work = sql_queies("INSERT INTO works (subject, explanation, neccessry, user_id, expo_work_datetime) VALUES ('$subject', '$explain', '$neccessry', '$user_id', '$dtime')");
        // Check for errors in the queries
        $work_id = get_id_new_work();
        if ($cr_table && $add_work && $work_id) {
            header('Location: show-works.php?work='.$work_id); // Redirect on success

        } else {
            echo "Error: " . mysqli_error($your_database_connection); // Replace with your actual database connection variable
            // header('Location: addwork.php'); // Redirect on error
            exit;
        }
    } else {
        // echo "Some fields are empty or invalid";
        header('Location: addwork.php'); // Redirect on empty or invalid fields
        exit;
    }
} else {
    // echo "User not logged in";
    header('Location: login.php'); // Redirect if user is not logged in
    exit;
}
?>
