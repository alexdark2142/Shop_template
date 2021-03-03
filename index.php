<?php
session_start();
include_once 'db/db.php';
if(!isset($_SESSION['login'])){
    echo '<script>location.href="/admin/page/login.php"</script>';
}
?>
  <!DOCTYPE>
  <html>
  <head>
    <meta charset=utf-8">
    <title>Админка</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="css/zero-style.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/app.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  </head>
  <body>
  <div class="container-fluid">
    <div class="row">
      <div class="menu col-sm-12 col-md-4 col-lg-3 col-xl-2">
        <div class="row">
          <div class="menu__header col-sm-6 col-md-12">
            <h2 class="text-center">Админ</h2>
            <img src="img/ava.png" alt="ava" class="img-fluid rounded mx-auto d-block">
          </div>
          <nav class="menu__items col d-flex justify-content-center align-items-center btn-group btn-group-toggle">
            <ul>
              <li><a style="cursor: pointer;" onclick="location.href='/admin'">Проверка фото</a></li>
              <li><a href="#" data-target="message">Сообщение</a></li>
              <li><a href="#" data-target="black-list">Черный список</a></li>
              <li><a href="#" data-target="users">Пользователи</a></li>
              <li><a style="cursor: pointer;" onclick="location.href='/admin?exit=1'">Выход</a></li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="page col-sm-12 col-md-8 col-lg-9 col-xl-10">
          <?php include('page/checking-photo.php'); ?>
      </div>
    </div>
  </div>
  </body>
  </html>

<?php
if(isset($_GET['exit'])){
    unset($_SESSION['login']);
    echo '<script>location.reload()</script>';
}
?>