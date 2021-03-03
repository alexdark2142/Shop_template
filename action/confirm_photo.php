<?php

require_once '../db/db.php';
require_once 'removeDir.php';

$id = $_POST['id'];
$check_photo = $_POST['photo'];
$name = $_POST['name'];

$query = $link->query("UPDATE `people` SET `proverka_photo` = '$check_photo' WHERE `id`= '$id' ");

$dir = '../../img/proverka_photo/' . trim($id);

if ($query) {
    echo 'success';
}

$RDir = new removeDir();

$deleteDir = $RDir->RDir($dir);