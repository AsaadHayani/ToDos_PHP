<?php

class Category
{
  public static function getAllCategory($conn)
  {
    $sql = "SELECT *
      FROM categories
      ORDER BY id desc";
    $result = $conn->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }
}
