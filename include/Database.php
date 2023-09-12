<?php

class Database {
  public function getConn() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "db";

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the PDO error mode to exception
      return $conn;
    } catch (PDOException $e) {
      echo "Connection Failed (Catch) : " . $e->getMessage();
    }
  }
}