<?php  require_once '../db/db.php'; ?>
<div class="page__header text-center"><h1>Черный список</h1></div>
<div class="page__content">
<?php
$query = $link->query(
    "SELECT `user`.`login`, `black_list`.`description`, `black_list`.`id` FROM `user` 
    INNER JOIN `black_list` ON `black_list`.`id_user` = `user`.`id` 
");
$black_list = $query->fetch_all();

foreach ($black_list as $value) { ?>
  <div id="black_<?php echo $value[2]; ?>" class="black-list row d-flex justify-content-between">
    <div class="col d-flex align-items-center justify-content-center">
      <img src="<?php echo ''.$value[4]? $value[4]: 'img/placeholder-ava.png';?>" alt="" class="img-fluid rounded-circle" >
    </div>
    <div class="col d-flex align-items-center justify-content-center">
      <div class="user-name"><?php echo $value[0]; ?></div>
    </div>
    <div class="col d-flex align-items-center justify-content-center">
      <div class="description"><?php echo $value[1]; ?></div>
    </div>
    <div class="black-list__btn col-sm-2 d-flex align-items-center justify-content-center">
      <button onclick="removeFromBlackList(<?php echo $value[2]; ?>)" type="submit" class="btn btn-outline-success" >Убрать из ЧС</button>
    </div>
  </div>
<?php
}
?>
</div>