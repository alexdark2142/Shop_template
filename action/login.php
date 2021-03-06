<?php
session_start();
require_once '../db/db.php';


if (isset($_POST['login']) && isset($_POST['pass'])) {
    $login = trim($_POST['login']);
    $pass = trim($_POST['pass']);

    if (empty($login)){
        echo 'login';
    }
    elseif (empty($pass)){
        echo 'pass';
    }
    else{
        $query = $link->query("SELECT * FROM `admin` WHERE `login` = '$login' && `password` = '$pass'");

        $admin = $query->fetch_array();

        if ($admin) {
            $_SESSION['login'] = $login;
            echo 'true';
        }
    }
}


