<?php

require_once '../db/db.php';
require_once 'removeDir.php';

$id = $_POST['id_user'];
$action = $_POST['action_id'];
$description = $_POST['description'];

if ($action == 'add_black_list') {
    $check = $link->query("SELECT `status` FROM `user` WHERE `id` = '$id'")->fetch_array();
    $status = $check[0];
    if ($status !== 'Заблокированный' && $status !== 'В черном списке') {
        $query = $link->query("SELECT * FROM `black_list` WHERE `id_user` = '$id'");
        $result = $query->fetch_all();
        $black_list = $link->query(
            "INSERT INTO `black_list`(`id_user`, `description`)
            VALUES ('$id','$description')");
        $user_status = $link->query("UPDATE `user` SET `status`= 'В черном списке' WHERE `id` = '$id'");
    }
    else{
        echo 'true';
    }
}
elseif ($action == 'block') {
    $query = $link->query("SELECT `status` FROM `user` WHERE `id` = '$id'");
    $result = $query->fetch_all();
    if ($result[0][0] !== 'Заблокированный') {
        $user_status = $link->query("UPDATE `user` SET `status`= 'Заблокированный' WHERE `id` = '$id'");
    }
    else {
        echo 'true';
    }
}
else {
    $path = '../../img/';
    $dirs = ['extedns_photo_people', 'people_history', 'proverka_photo'];
    $query = $query = $link->query(
        "SELECT `people`.`id`
            FROM `user`
            LEFT JOIN `people` ON `people`.`id_user` = `user`.`id` 
            WHERE `user`.`id` = '$id';"
    );
    $idPeople = $query->fetch_all();

    $deleteUser = $link->query(
        "DELETE `user`, `people`, `history`, `extends_photo`, `comments`, `black_list`, `messages`
            FROM `user`
            LEFT JOIN `people` ON `people`.`id_user` = `user`.`id` 
            LEFT JOIN `history` ON `history`.`id_user` = `user`.`id`
            LEFT JOIN `extends_photo` ON `extends_photo`.`id_people` = `people`.`id`
            LEFT JOIN `comments` ON `comments`.`id_author` = `user`.`id`
            LEFT JOIN `black_list` ON `black_list`.`id_user` = `user`.`id`
            LEFT JOIN `messages` ON `messages`.`id_from` = `user`.`id` OR
            `messages`.`id_to` = `user`.`id`
            WHERE `user`.`id` = '$id';"
    );

    if ($deleteUser) {
        $RDir = new removeDir();

        foreach ($idPeople as $id) {
            foreach ($dirs as $dir){
                $deleteDir = $RDir->RDir($path . $dir . '/' . $id[0]);
            }
        }
    }

}