<?php
  session_start();

  $name;
  if (isset($_COOKIE['name'])) $name = $_COOKIE['name'];
  if (isset($name)) {
    header("Location: ./index.php", true, 302);
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $connection = new PDO('mysql:host=localhost;dbname=php_pool_10;charset=UTF8', '', '');
    $req = $connection->prepare('SELECT name, email, password, is_admin FROM users WHERE email=?');
    $req->execute([$_POST['email']]);

    if ($req->rowCount() == 0) {
      echo "Incorrect email/password<br />";
    } else {
      $row = $req->fetch(PDO::FETCH_ASSOC);

      if (!password_verify($_POST['password'], $row['password'])) {
        echo "Incorrect email/password<br />";
      } else {
        $_SESSION['name'] = $row['name'];
        $_SESSION['isadmin'] = $row['is_admin'];

        if (!empty($_POST['remember_me'])) {
          setcookie('name', $row['name'], time() + 3600 * 24 * 30);
        }

        header("Location: ./index.php", true, 302);
        exit();
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
</head>
<body>
  <div>
    <h1>Login form:</h1>
    <form action="" method="POST">
      <label for="email">Email: </label>
      <input type="email" name="email">
      <br>
      <label for="password">Password: </label>
      <input type="password" name="password">
      <br>
      <input type="checkbox" name="remember_me">Remember me<br>
      <input type="submit" name="submit" value="Submit">
    </form>
  </div>
</body>
</html>