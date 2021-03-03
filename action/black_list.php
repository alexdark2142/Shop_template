<?php

require_once '../db/db.php';

$id = $_POST['id'];

$result = $query = $link->query("SELECT `id_user` FROM `black_list` WHERE `id` = '$id'")->fetch_array();
$query = $link->query("DELETE FROM `black_list` WHERE `id` = '$id'");

$id_user = $result[0];

$check_status = $link->query("SELECT `ban` FROM `user` WHERE `id` = '$id_user'")->fetch_array();

if ($check_status[0] == 1) {
    $status = $link->query("UPDATE `user` SET `ban`= NULL WHERE `id` = '$id_user'");
}

if ($query) {
    echo 'success';
}