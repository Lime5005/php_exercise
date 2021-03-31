<?php
// Test in debug
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
include_once("User.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user = new User();
  try {
    $user->setName($_POST['name']);
    $user->setEmail($_POST['email']);
    $user->setPassword($_POST['password'], $_POST['password_confirmation']);
    $user->saveToDatabase();

    echo 'User created<br>';
  } catch (Exception $e) {
    echo $e->getMessage() . '<br>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription Page</title>
</head>
<body>
  <h1>Registration form:</h1>
  <form action="" method="POST">
    <label for="name">Name: </label><input type="text" name="name" placeholder="Enter your name"><br>
    <label for="email">Email: </label><input type="email" name="email" placeholder="Enter you email"><br>
    <label for="password">Password: </label><input type="password" name="password" placeholder="Enter your password"><br>
    <label for="password_confirmation">Password Confirmation: </label><input type="password" name="password_confirmation" placeholder="Confirm your password"><br>
    <input type="submit" name="submit" value="Register">
  </form>
</body>
</html>