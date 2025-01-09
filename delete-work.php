<?php

$id = $_GET['id'] ?? '';

if (!empty($id)){
    require_once "./DBs/functions.php";
    sql_queies("DELETE FROM works WHERE work_id='$id'");
    header('Location: '."show-works.php");
}