<?php
  session_start();

  $isAdmin = false;
  $name;
  if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1) {
    $isAdmin = true;

    $connection = new PDO('mysql:host=localhost;dbname=php_pool_10;charset=UTF8', '', '');
    // How to find the name in table 'users' with author_id in table 'newsletter' :
    $req = $connection->prepare('SELECT * FROM newsletter JOIN users ON users.id = newsletter.author_id ORDER BY newsletter.id DESC');
    $req->execute();
    $data = $req->fetchAll(PDO::FETCH_ASSOC);
  }

  if (isset($_SESSION['name'])) $name = $_SESSION['name'];
  if (isset($_COOKIE['name'])) $name = $_COOKIE['name'];

  if (!isset($name)) {
    header("Location: ./login.php", true, 302);
    exit();
  }

  echo 'Hello ' . $name;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
</head>
<body>
  <ul>
    <li><a href="logout.php">Logout</a></li>
    <br>
    <li><a href="modify_account.php">Settings</a></li>
    <br>
    <?php
      if ($isAdmin) {
        echo '<li><a href="admin.php">Admin settings</a></li>';
        echo '<li><a href="newsletter.php">Create newsletter</a></li>';
      }
    ?>
  </ul>
  <br>
  <ul>
    <?php if (!empty($data)) foreach ($data as $entry): ?>
      <li>
        <?= $entry['content'] ?>&nbsp;Created by&nbsp;<?= $entry['name'] ?>
      </li>
    <?php endforeach; ?>
  </ul>
</body>
</html>