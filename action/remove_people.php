<?php

require_once '../db/db.php';
require_once 'removeDir.php';

$id = $_POST['id'];
$path = '../../img/';
$dirs = ['extedns_photo_people', 'people_history', 'proverka_photo'];


$people = $link->query("DELETE `people`, `history`, `extends_photo`, `comments`
            FROM `people`
            LEFT JOIN `history` ON `history`.`id_people` = `people`.`id`
            LEFT JOIN `extends_photo` ON `extends_photo`.`id_people` = `people`.`id`
            LEFT JOIN `comments` ON `comments`.`id_user` = `people`.`id`
            WHERE `people`.`id` = '$id'");

if ($people) {
    echo 'success';
    $RDir = new removeDir();

    foreach ($dirs as $dir){
        $deleteDir = $RDir->RDir($path . $dir . '/' . trim($id));
    }
}