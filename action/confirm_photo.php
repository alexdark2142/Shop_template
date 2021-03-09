<?php

require_once '../db/db.php';
require_once 'removeDir.php';

$id = $_POST['id'];
$check_photo = $_POST['photo'];
$name = $_POST['name'];

$dir = '../../img/proverka_photo/' . trim($id);
$query = $link->query("UPDATE `people` SET `proverka_photo` = '$check_photo' WHERE `id`= '$id' ");

if ($query) {
  $RDir = new removeDir();
  $deleteDir = $RDir->RDir($dir);
  echo 'success';
}

