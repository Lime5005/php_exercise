<?php
  session_start();

  if (!isset($_SESSION['isadmin']) || $_SESSION['isadmin'] == 0) {
    header("Location: ./index.php", true, 302);
    exit();
  }

  $isAdmin = false;
  if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1) {
  $isAdmin = true;
  $name;
  if (isset($_SESSION['name']) && isset($_POST['submit'])) {
    if ($_POST['title'] != '' && $_POST['content'] != '') {
      $name = $_SESSION['name'];
      // $connection = new PDO('mysql:host=localhost;port=3306;dbname=gecko', '', '');
      $connection = new PDO('mysql:host=localhost;dbname=php_pool_10;charset=UTF8', '', '');
      // How to insert the author_id that I got from another table 'users':
      $sql = 'INSERT INTO newsletter (title, content, author_id) VALUES (?, ?, (SELECT id FROM users WHERE users.name = ?))';
      $statement = $connection->prepare($sql);
      $statement->execute([$_POST['title'], $_POST['content'], $name]);

    } else if ($_POST['title'] == '') {
      echo "Invalid title";
    } else if ($_POST['content'] == '') {
      echo "Invalid content";
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
  <title>Newsletter Page</title>
</head>
<body>
  <h1>Create newsletter:</h1>
  <form action="" method="POST">
    <label for="title">Title:</label><input type="text" name="title"><br>
    <label for="content">Content:</label><input type="textarea" name="content">
    <input type="submit" name="submit" value="Publish">
  </form>
</body>
</html>