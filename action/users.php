<?php

require_once '../db/db.php';
require_once 'removeDir.php';

$id = $_POST['id_user'];
$action = $_POST['action_id'];
$description = $_POST['description'];

if ($action == 'add_black_list') {
  $check = $link->query("SELECT `ban` FROM `user` WHERE `id` = {$id}")->fetch_array();
  $status = $check[0];

  if ($status != -1) {
    if ($status != 1) {
      $black_list = $link->query("INSERT INTO `black_list`(`id_user`, `description`) VALUES ({$id},'$description')");
      $user_status = $link->query("UPDATE `user` SET `ban`= 1 WHERE `id` = {$id}");
    } else {
      echo 'black_list';
    }
  } else {
    echo 'block';
  }

} elseif ($action == 'block') {

  $query = $link->query("SELECT `ban` FROM `user` WHERE `id` = {$id}");
  while ($res[] = $query->fetch_array()) {
    $result = $res;
  }

  if ($result[0][0] != -1) {
    $user_status = $link->query("UPDATE `user` SET `ban`= -1 WHERE `id` = {$id}");
    $delete_black_list = $link->query("DELETE FROM `black_list` WHERE `id_user` = {$id}");
  } else {
    echo 'true';
  }

} elseif ($action == 'unblock') {

  $query = $link->query("SELECT `ban` FROM `user` WHERE `id` = {$id}");
  while ($res[] = $query->fetch_array()) {
    $result = $res;
  }

  if ($result[0][0] == -1) {
    $user_status = $link->query("UPDATE `user` SET `ban`= 0 WHERE `id` = {$id}");
    echo 'true';
  }

} elseif ($action == 'delete') {

  $path = '../../img/';
  $dirs = ['extedns_photo_people', 'people_history', 'proverka_photo'];

  $query = $link->query(
    "SELECT `people`.`id`
    FROM `user`
    LEFT JOIN `people` ON `people`.`id_user` = `user`.`id`
    WHERE `user`.`id` = {$id}"
  );

  while ($delUser[] = $query->fetch_array()) {
    $idPeople = $delUser;
  }

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
    WHERE `user`.`id` = {$id}"
  );

  if (!empty($idPeople)) {
    $RDir = new removeDir();
    foreach ($idPeople as $id) {
      if (!empty($id['id'])) {
        foreach ($dirs as $dir) {
          $deleteDir = $RDir->RDir($path . $dir . '/' . $id['id']);
        }
      }
    }
  }

}
