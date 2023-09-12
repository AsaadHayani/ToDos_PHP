<?php

class User
{
  public $id;
  public $username;
  public $password;

  public static function login($conn, $email, $pass)
  {
    $query = 'SELECT * FROM `users` WHERE email = :email';
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
    $stmt->execute();
    $user = $stmt->fetch();
    if ($user) {
      return password_verify($pass, $user->password);
    }
  }
  public static function signup($conn, $username, $email, $pass, $cpass)
  {
    $query = "INSERT INTO `users`(`name`, `email`, `password`)
  VALUES (`:name`, `:email`, `:password`)";
    if ($pass == $cpass) {
      $stmt = $conn->prepare($query);
      $stmt->bindValue(":name", $username, PDO::PARAM_STR);
      $stmt->bindValue(":email", $email, PDO::PARAM_STR);
      $stmt->bindValue(":password", $pass, PDO::PARAM_STR);
      $stmt->execute();
      $user = $stmt->fetch();
      if ($user) {
        return password_verify($pass, $user->password);
      }
    }
  }
  public static function getUser($conn, $email)
  {
    $query = 'SELECT name FROM `users` WHERE email = :email';
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
    $stmt->execute();
    $user = $stmt->fetch();
  }
}
