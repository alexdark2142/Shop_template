<?php  require_once '../db/db.php'; ?>
<div class="page__header text-center"><h1>Пользователи</h1></div>
<div class="page__content">
  <div class="users table-responsive">
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
      <tbody>
      <?php
      $query = $link->query(
        "SELECT 
          `user`.`id`, `user`.`login`, `user`.`email`, `user`.`balance`, COUNT(`people`.`id`) AS `count`, `user`.`status`
        FROM
          `user`
        LEFT JOIN 
          `people` ON `user`.`id` = `people`.`id_user`
        GROUP BY
            `user`.`id` 
        ORDER BY `id` ASC");
      $users = $query->fetch_all();
      foreach ($users as $user) { ?>
        <tr id="user_<?php echo $user[0]; ?>" >
            <th scope="row"><?php echo $user[0]; ?></th>
        <td><?php echo $user[1]; ?></td>
        <td><?php echo $user[2]; ?></td>
        <td><?php echo $user[3]; ?></td>
        <td><?php echo $user[4]; ?></td>
        <td id="status_<?php echo $user[0]; ?>"><?php echo $user[5]; ?></td>
        <td>
          <select id="action_<?php echo $user[0]; ?>" name="select" class="custom-select">
            <option value="add_black_list">Добавить в черный список</option>
            <option value="block">Заблокировать</option>
            <option value="delete">Удалить</option>
          </select>
        </td>
        <td><button type="submit" onclick="getOptions('<?php echo $user[0]; ?>')" class="btn btn-primary">OK</button></td>
        </tr>
      <?php
      }
      ?>
      </tbody>
    </table>
  </div>
</div>
