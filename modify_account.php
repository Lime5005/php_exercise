<?php
session_start();

$name;
if (isset($_SESSION['name'])) $name = $_SESSION['name'];
if (isset($_COOKIE['name'])) $name = $_COOKIE['name'];
if (!isset($name)) {
  header("Location: ./index.php", true, 302);
  exit();
}

$connection = new PDO('mysql:host=localhost;dbname=php_pool_10;charset=UTF8', '', ''); //TODO: change password

$req = $connection->prepare('SELECT * FROM users WHERE name=?');

$req-> execute([$name]);

$row = $req->fetch(PDO::FETCH_ASSOC);
//print_r($row['id]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['modify'])) {
    if (strlen($_POST['name']) < 3 || strlen($_POST['name']) > 10) {
      throw new Exception("Invalid name");
    }
    $newName = $_POST['name'];

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new Exception("Invalid email");
    }
    $newEmail = $_POST['email'];

    if (strlen($_POST['password']) < 3 || strlen($_POST['password']) > 10 || $_POST['password'] !== $_POST['password_confirmation']) {
      throw new Exception("Invalid new password or new password confirmation");
    }
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $modify = $connection->prepare('UPDATE users SET name=?, email=?, password=? WHERE id=? LIMIT 1');
    $modify->execute([$newName, $newEmail, $newPassword, $row['id']]);
    $_SESSION['name'] = $newName;

    header("Location: ./index.php", true, 302);
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modify Account Page</title>
</head>
<body>
  <h1>Modify Form:</h1>
  <form action="" method="POST">
    <label for="name">New name: </label><input type="text" name="name" value="<?= $row['name']; ?>"><br>
    <label for="email">New email: </label><input type="email" name="email" value="<?= $row['email']; ?>"><br>
    <label for="password">New password: </label><input type="password" name="password"><br>
    <label for="password_confirmation">New password confirmation: </label><input type="password" name="password_confirmation" ><br>
    <input type="submit" name="modify" value="Modify">
  </form>
</body>
</html>