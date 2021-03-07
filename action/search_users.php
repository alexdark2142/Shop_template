<?php

require_once '../db/db.php';

$text = strval(@$_GET['search']);

$search_users = $link->query("SELECT * FROM `user` WHERE `login` like '{$text}%' OR `email` like '{$text}%'");
while($res[]=$search_users->fetch_array()) {
    $users = $res;
}