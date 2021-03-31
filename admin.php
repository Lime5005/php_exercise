<?php
session_start();

if (!isset($_SESSION['isadmin']) || $_SESSION['isadmin'] == 0) {
  header("Location: ./index.php", true, 302);
  exit();
}

$isAdmin = false;
if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1) {
  $isAdmin = true;
  $connection = new PDO('mysql:host=localhost;dbname=php_pool_10;charset=UTF8', '', '');
  $req = $connection->prepare('SELECT * FROM users ORDER BY email ASC');
  $req->execute();
  $data = $req->fetchAll(PDO::FETCH_ASSOC);
  //print_r($data);
}

if (isset($_GET['error']) && $_GET['error'] == 'deleteadmin') {
  echo "You can't delete an administrator";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
</head>
<body>
  <h1>Admin Form:</h1>
  <form action="" method="POST">
    <ul>
      <?php foreach ($data as $entry): ?>
        <li>
          <?= $entry['email'] ?><a href="delete.php?userID=<?= $entry['id'] ?>">Delete</a>
        </li>
        <?php endforeach; ?>
    </ul>
  </form>
</body>
</html>
