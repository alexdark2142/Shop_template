<?php  require_once '../db/db.php'; ?>
<!DOCTYPE>
<html>
<head>
  <meta charset=utf-8">
  <title>Админка</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&family=Shippori+Mincho:wght@600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/zero-style.css">
  <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../js/login.js"></script>
</head>
<body>
<div class="container d-flex align-items-center justify-content-center  ">
  <div class="login">
    <div  class="text-center">
      <div>
        <h1>Вход в админку</h1>
      </div>
      <div class="msg-login"></div>
      <div class="form-group">
        <input id="login" name="login" type="text" class="form-control" placeholder="Логин">
      </div>
      <div class="form-group">
        <input id="pass" name="pass" type="password" class="form-control"  placeholder="Пароль">
      </div>
      <button id="btn-login" type="submit" class="btn btn-primary">Вход</button>
    </div>
  </div>
</div>
</body>
</html>