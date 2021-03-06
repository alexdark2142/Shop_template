<?php

require_once '../db/db.php';

$query = $link->query(
    "SELECT 
          `user`.`id`, `user`.`login`, `user`.`email`, `user`.`balance`, COUNT(`people`.`id`) AS `count`, `user`.`ban`
        FROM
          `user`
        LEFT JOIN 
          `people` ON `user`.`id` = `people`.`id_user`
        GROUP BY
            `user`.`id` 
        ORDER BY `id` ASC LIMIT 3");
while($user[] = $query->fetch_array()) {
    $users = $user;
};

$query= $link->query(
    "SELECT COUNT(`user`.`id`) AS `count`
    FROM `user`");
$users_count = $query->fetch_assoc();
$cont = $users_count['count'];
$amt = ceil($cont / 3);

?>
<div class="page__header text-center"><h1>Пользователи</h1></div>
<div class="page__content">
  <div class="users table-responsive">
    <?php  if (!empty($users)) { ?>
    <table class="table table-striped table-dark text-center">
      <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Логин</th>
        <th scope="col">Email</th>
        <th scope="col">Баланс</th>
        <th scope="col">Анкет</th>
        <th scope="col">Статус</th>
        <th scope="col" colspan="2">Управление</th>
      </tr>
      </thead>
      <tbody id="show-more-list">
      <?php
      foreach ($users as $user) {
        $query_p = $link->query(
          "SELECT `photo`, `name`, `status_plan`, `end_status`, `date_created`, `id` 
          FROM `people` 
          WHERE `id_user` = '$user[0]'
          ORDER BY `date_created` DESC");
        unset($people_res);
        while($people_res[] = $query_p->fetch_array()) {
            $people = $people_res;
        };

      ?>
        <tr id="user_<?php echo $user[0]; ?>" class="user">
        <th scope="row"><?php echo $user[0]; ?></th>
        <td><?php echo $user[1]; ?></td>
        <td><?php echo $user[2]; ?></td>
        <td><?php echo $user[3]; ?></td>
        <td>
          <div class="container-form">
            <button onclick="openModal(this)" id="openModal" class="btn-show-form"><?php echo $user[4]; ?></button>
            <div id="modal" class="modal d-flex align-items-center">
              <div class="content-modal">
                <div class="modal_header d-flex">
                  <h1 class="col-11 modal-title d-flex align-items-center justify-content-center">Анкеты пользователя "<?php echo $user[1]; ?>"</h1>
                  <div id="close_modal" class="col d-flex align-items-center justify-content-end" onclick="closeModal(this)"><img src="img/close.png" alt="X"></div>
                </div>
                <div class="modal_body">
                    <?php if ($user[4] > 0) { ?>
                      <table class="table table-striped table-dark text-center table-modal">
                        <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Фото</th>
                          <th scope="col">Имя</th>
                          <th scope="col">Статус план</th>
                          <th scope="col">Дата создания</th>
                          <th scope="col">Конец статуса</th>
                          <th scope="col" colspan="2">Управление</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach ($people as $man) {?>
                          <tr>
                            <th scope="row"><?php  echo $i; $i++;?></th>
                            <td>
                              <div class="ratio_image ratio_image_1x1">
                                <img src="../../img/ava/<?php echo $man[0]; ?>" alt="ava" class="img-table">
                              </div>
                            </td>
                            <td><?php echo $man[1]; ?></td>
                            <td>
                                <?php
                                if (strtolower($man[2]) == 'vip') {
                                    echo '<span class="vip">' . strtoupper($man[2]) . '</span>';
                                }
                                elseif (strtolower($man[2]) == 'premium') {
                                    echo '<span class="premium">' . strtoupper($man[2]) . '</span>';
                                }
                                else {
                                    echo '<span class="classic">' . strtoupper($man[2]) . '</span>';
                                }
                                ?>
                            </td>
                            <td><?php echo $man[4]; ?></td>
                            <td><?php echo $man[3]; ?></td>
                            <td><a href="/info_anketa/<?php echo $man[5]; ?>"><button class="btn-img"><img src="../../img/oko.png" alt="Просмотреть"></button></a></td>
                            <td><button id="deletePeople" onclick="deletePeople(this, <?php echo $man[5]; ?>)" class="btn-img"><img src="../../img/cansel.png" alt="Удалить"></button></td>
                          </tr>
                        <?php  } ?>
                        </tbody>
                      </table>
                    <?php } else {?>
                      <h2 class="d-flex align-items-center justify-content-center">У этого пользователя нет анкет для показа</h2>
                    <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </td>
        <td><?php echo ($user[5] == -1) ? 'Заблокирован' : (($user[5] == 1) ? 'В черном списке' : ''); ?></td>
        <td>
          <select id="action_<?php echo $user[0]; ?>" name="select" class="custom-select">
            <option value="add_black_list">Добавить в черный список</option>
            <?php echo ($user[5] == -1) ?
                '<option value="unblock">Разблокировать</option>':
                '<option value="block">Заблокировать</option>';
            ?>
            <option value="delete">Удалить</option>
          </select>
        </td>
        <td><button type="submit" onclick="getOptions(this, '<?php echo $user[0]; ?>')" class="btn btn-primary">OK</button></td>
        </tr>
      <?php
      }
      ?>
      </tbody>
    </table>
    <div class="btn-list d-flex justify-content-center">
      <button id="show-more-button" data-page="1" data-max="<?php echo $amt; ?>" type="submit"  class="col btn btn-outline-info show_more">Показать еще...</button>
    </div>
    <?php
    }
    else {
      echo '<h3>Пользователей нет</h3>';
    }
    ?>
  </div>
</div>

<script>
    if (parseInt(<?php echo $cont?>, 10) < 4) {
        $('#show-more-button').hide();
    }
    $(function(){
        $('#show-more-button').click(function (){
            let $target = $(this);
            let page = $target.attr('data-page');
            page++;


            $.ajax({
                url: '/admin/action/add_users.php?page=' + page,
                dataType: 'html',
                success: function(data){
                    console.log(data);
                    $('#show-more-list').append(data);
                }
            });

            $target.attr('data-page', page);
            if (page ==  $target.attr('data-max')) {
                $target.hide();
            }

            return false;
        });
    });
</script>