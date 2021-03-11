<?php

require_once '../db/db.php';

$id = intval($_POST['id_user']);
$balance = $_POST['balance_value'];

if (!empty($balance)) {
  $user_status = $link->query("UPDATE `user` SET `balance`= {$balance} WHERE `id` = {$id}");

  if ($user_status) {
    echo 'success';
  }
} else {
  echo 'error';
}

