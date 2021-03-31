<?php
session_start();

if (!isset($_SESSION['isadmin']) || $_SESSION['isadmin'] != 1) {
  header("Location: ./index.php", true, 302);
  exit();
}

$connection = new PDO('mysql:host=localhost;dbname=php_pool_10;charset=UTF8', '', '');
$req = $connection->prepare('DELETE FROM users WHERE id=? AND is_admin=0 LIMIT 1');

$req->execute([$_GET['userID']]);

if ($req->rowCount() == 0) {
  header("Location: ./admin.php?error=deleteadmin", true, 302);
  exit();
} else {
  $message = 'The user is deleted';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Page</title>
</head>
<body>
  <p><?= $message ?></p>
</body>
</html>