<?php

require_once "connect.php";

$conn = conn();

function sql_queies ($sql){
    global $conn;
    if ($conn){
        if ($conn -> query($sql) === TRUE){
            return 1;
        }
        echo "Error in sql query: " . $conn->error;
    }
    return null;
}

function get_id ($email){
    global $conn;
    if ($conn){
        $stmt = $conn -> query("SELECT user_id FROM users WHERE email = '$email'");
        $id = $stmt->fetch_assoc();
        if ($id) {
            return $id['user_id'];
        }
    }
    return null;
}

function get_id_new_work (){
    global $conn;
    if ($conn){
        return $conn-> insert_id;
    }
    return null;
}

function get_works_info ($user_id){
    global $conn;
    if ($conn){
        $stmt = $conn -> query("SELECT * FROM works WHERE user_id = '$user_id'");
        $id = $stmt->fetch_all();
        return $id;
    }
    return null;
}

function check_user($email, $password){
    global $conn;
    if ($conn){
        echo $email."\n".$password;
        $stmt = $conn -> query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
        $fetch = $stmt->fetch_assoc();
        if ($fetch) {
            return $fetch;
        }
    }
    return null;

}


