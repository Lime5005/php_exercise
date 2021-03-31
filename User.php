<?php

class User {

  private $name;
  private $email;
  private $password;

  public function setName($name) {
    if (strlen($name) < 3 || strlen($name) > 10) {
      throw new Exception("Invalid name");
    }

    $this->name = $name;
  }

  public function setEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception("Invalid email");
    }

    $this->email = $email;
  }

  public function setPassword($password, $confirmation) {
    if (strlen($password) < 3 || strlen($password) > 10 || $password !== $confirmation) {
      throw new Exception("Invalid password or password confirmation");
    }

    $this->password = password_hash($password, PASSWORD_DEFAULT);
  }

  public function saveToDatabase() {
    if (!isset($this->name) || !isset($this->email) || !isset($this->password)) {
      throw new Exception("Invalid values");
    }

    $createdAt = date('Y-m-d');

    $connection = new PDO('mysql:host=localhost;dbname=php_pool_10;charset=UTF8', '', '');

    $sql = 'INSERT INTO users (name, password, email, created_at, is_admin) VALUES (?, ?, ?, ?, ?)';
    $statement = $connection->prepare($sql);
    $statement->execute([$this->name, $this->password, $this->email, $createdAt, 0]);
  }
}
?>