<div class="page__header text-center"><h1>Проверка фото</h1></div>
<div id="response"></div>
<div id="#ajax" class="page__content row">
<?php

$query = $link->query("SELECT `id`,`name`, `proverka_photo` FROM `people` WHERE  `proverka_photo` != '0' AND `proverka_photo` != '1' AND `proverka_photo` != '-1'");

while($res[]=$query->fetch_array()) {
    $check_photo = $res;
};

if (!empty($check_photo)) {
  foreach ($check_photo as $value) { ?>
    <div id="photo_<?php echo $value[0]; ?>" class="col-sm-12 col-md-6 col-lg-3">
      <h2 class="text-center"><?php echo $value[1]; ?></h2>
      <div class="check_img">
        <img src="../img/proverka_photo/<?php echo  $value[0] . '/' .$value[2]; ?>" alt="photo" class="img">
      </div>
      <div class="btn-group">
        <button type="submit" onclick="check_photo(<?php echo $value[0]; ?>, 1, '<?php echo $value[2]; ?>')" class="col btn btn-success">Одобрить</button>
        <button type="submit" onclick="check_photo(<?php echo $value[0]; ?>, -1, '<?php echo $value[2]; ?>')" class="col btn btn-danger">Отказать</button>
      </div>
    </div>
<?php
  }
}
else {
  echo '<h3>Фото на проверку нет</h3>';
}
?>
</div>
