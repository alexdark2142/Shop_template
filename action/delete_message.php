<?php

require_once '../db/db.php';

$id = $_POST['id_msg'];

$delete_msg = $link->query(
    "DELETE FROM `messages` WHERE `id` = '$id'");


if ($delete_msg) {
    echo 'true';
}