<?php  require_once '../db/db.php'; ?>

<div class="page__header text-center"><h1>Сообщения</h1></div>
<div class="page__content ">
<?php

$query = $link->query(
    "SELECT  `user`.`login`, `messages`.`data_created`, `messages`.`msg`, 
     `messages`.`id`, `messages`.`id_from`, `messages`.`id_to`, `messages`.`theme`
    FROM `messages` INNER JOIN `user` ON `messages`.`id_from` = `user`.`id` 
    ORDER BY `messages`.`data_created` DESC");
$message = $query->fetch_all();
if (!empty($message)) {
  foreach ($message as $msg) {
?>
<div id="msg<?php echo $msg[3]; ?>" class="msg_row">
  <div id="list" class="message row d-flex justify-content-between">
    <div class="message__data col-sm-12 col-md-12 col-lg-3  d-flex align-items-center justify-content-center">
      <div class="name"><?php echo $msg[0]; ?></div>
      <div class="date"><?php echo $msg[1]; ?></div>
    </div>
    <div class="message__theme col-sm-12 col-md-12 col-lg-5  d-flex align-items-center justify-content-center">
      <h2 class="theme">Тема: <?php echo $msg[6]; ?></h2>
    </div>
    <div class="message__btn col-sm-12  col-md-12 col-lg-4 d-flex align-items-center justify-content-between">
      <input id="btn_<?php echo $msg[3]; ?>" onclick="open_msg(<?php echo $msg[3]; ?>)" type="submit" class="btn btn-primary" value="Открыть">
      <input id="btn_<?php echo $msg[3]; ?>" onclick="open_answer_msg(<?php echo $msg[3]; ?>)" type="submit" class="btn btn-primary" value="Ответить">
      <input id="btn_<?php echo $msg[3]; ?>" onclick="delete_msg(<?php echo $msg[3]; ?>, this)" type="submit" class="btn btn-primary" value="Удалить">
    </div>
  </div>
  <div id="msg_<?php echo $msg[3]; ?>" class="msg row">
    <p><?php echo $msg[2]; ?></p>
  </div>
  <div id="block_msg_<?php echo $msg[3]; ?>" class="msg row">
    <input id="theme_<?php echo $msg[3]; ?>" class="theme" type="text" value="Тема: <?php echo $msg[6]; ?>" disabled="disabled">
    <textarea name="msg" id="answer_msg_<?php echo $msg[3]; ?>" cols="30" rows="10"></textarea>
    <input id="btn_<?php echo $msg[3]; ?>" onclick="send_answer_msg(<?php echo $msg[3]; ?>,<?php echo $msg[4]; ?>, <?php echo $msg[5]; ?>, '<?php echo $msg[6]; ?>')" type="submit" class="btn btn-primary" value="Ответить">
  </div>
</div>
<?php
  }
?>
<div class="btn-list d-flex justify-content-center">
  <button id="show_more" type="submit"  class="col btn btn-outline-info show_more">Показать еще...</button>
</div>
  <div id="masonry"></div>
<?php
}
else {
  echo '<h1>Сообщений нет.</h1>';
}
?>
</div>
<script>
  $(document).ready(function(){
    let element = document.getElementById("show_more");
    if ($( ".msg_row" ).is( ":hidden" )){
      $(".msg_row").slice(0, 5).show();
    }
    else {
      element.parentNode.removeChild(element);
    }
    $('#show_more').on('click', function (){
      $('.msg_row:hidden').slice(0,5).slideDown();
      if ($( ".msg_row" ).is( ":hidden" )){
      }
      else {
        element.parentNode.removeChild(element);
      }
    });
  });
</script>