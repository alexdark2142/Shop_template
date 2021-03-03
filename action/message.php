<?php

require_once '../db/db.php';

$id_to = $_POST['id_to'];
$id_from = $_POST['id_from'];
$msg = $_POST['msg'];
$theme = $_POST['theme'];

$send_msg = $link->query("INSERT INTO `messages`(`id_to`, `id_from`, `msg`, `theme`) VALUES ('$id_to','$id_from','$msg', '$theme')");

if ($send_msg) {
    echo 'true';
}