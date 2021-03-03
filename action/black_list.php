<?php

require_once '../db/db.php';

$id = $_POST['id'];

$result = $query = $link->query("SELECT `id_user` FROM `black_list` WHERE `id` = '$id'")->fetch_array();
$query = $link->query("DELETE FROM `black_list` WHERE `id` = '$id'");

$id_user = $result[0];

$check_status = $link->query("SELECT `status` FROM `user` WHERE `id` = '$id_user'")->fetch_array();

if ($check_status[0] == 'В черном списке') {
    $status = $link->query("UPDATE `user` SET `status`= NULL WHERE `id` = '$id_user'");
}