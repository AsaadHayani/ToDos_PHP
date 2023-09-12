<?php

class Task
{
  public $id;
  public $name;
  public $email;
  public $phone;
  public $course;
  public $created;

  // FUNCTION FOR VIEW ALL ELEMENTS
  public static function getTasks($conn)
  {
    $query = "SELECT * FROM tasks";
    $result = $conn->query($query);
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  // FUNCTION FOR VIEW ELEMENTS BY PAGINATE
  public static function forPaginate($conn, $limit, $offset)
  {
    $query = "SELECT * FROM tasks LIMIT :limit OFFSET :offset";
    $result = $conn->prepare($query);
    $result->bindValue(":limit", $limit, PDO::PARAM_INT);
    $result->bindValue(":offset", $offset, PDO::PARAM_INT);
    $result->setFetchMode(PDO::FETCH_CLASS, "Task");
    if ($result->execute()) {
      return $result->fetchAll(PDO::FETCH_ASSOC);
    }
  }

  // FUNCTION FOR VIEW DETAILS ONE ELEMENT
  public static function getTask($conn, $id)
  {
    $query = "SELECT * FROM tasks WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->setFetchMode(PDO::FETCH_CLASS, "Task");
    if ($stmt->execute()) {
      return $stmt->fetch();
    }
  }

  // FUNCTION FOR VIEW DETAILS ONE ELEMENT with Category
  public static function getTaskwithCategory($conn, $id)
  {
    $query = "SELECT tasks.* , categories.name AS cat
    FROM tasks
    LEFT JOIN tasks_cat
    ON tasks.id = tasks_cat.task_id
    LEFT JOIN categories
    ON categories.id = tasks_cat.cat_id
    WHERE tasks.id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }

  // FUNCTION FOR INSERT
  public function insertTask($conn)
  {
    $query = "INSERT INTO tasks(`name`, `email`, `phone`, course, created)
      VALUES(:name, :email, :phone, :course, :created)";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
    $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
    $stmt->bindValue(":phone", $this->phone, PDO::PARAM_STR);
    $stmt->bindValue(":course", $this->course, PDO::PARAM_STR);
    $stmt->bindValue(":created", $this->created, PDO::PARAM_STR);
    if ($stmt->execute()) {
      $this->id = $conn->lastInsertId();
      return true;
    }
  }

  // FUNCTION FOR UPDATE
  public function updateTask($conn)
  {
    $query = "UPDATE tasks SET name = :name, email = :email, phone = :phone,
    course = :course, created = :created
    WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
    $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
    $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
    $stmt->bindValue(":phone", $this->phone, PDO::PARAM_STR);
    $stmt->bindValue(":course", $this->course, PDO::PARAM_STR);
    $stmt->bindValue(":created", $this->created, PDO::PARAM_STR);
    return $stmt->execute();
  }

  // FUNCTION FOR DELETE
  public function deleteTask($conn)
  {
    $query = "DELETE FROM tasks WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public static function getTotalRecord($conn)
  {
    $sql = "SELECT COUNT(*) FROM tasks";
    return $conn->query($sql)->fetchColumn();
  }

  public function getCategories($conn)
  {
    $sql = "SELECT categories.*
      FROM categories
      JOIN tasks_cat
      ON categories.id = tasks_cat.cat_id
      WHERE tasks_cat.task_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }

  // FUNCTION FOR SET Category
  public function setCat($conn, $ids)
  {
    if ($ids) {
      $query = "INSERT IGNORE INTO tasks_cat(task_id, cat_id)
      VALUES(" . $this->id . ", :cat_id)";
      $stmt = $conn->prepare($query);
      foreach ($ids as $id) {
        $stmt->bindValue("cat_id", $id, PDO::PARAM_INT);
        $stmt->execute();
      }
    }
  }

  // FUNCTION FOR SET Category
  public function setCatNewWay($conn, $ids)
  {
    if ($ids) {
      $query = "INSERT IGNORE INTO tasks_cat(task_id, cat_id)
      VALUES ";
      $values = [];
      foreach ($ids as $id) {
        $values[] = "(" . $this->id . ", ?)";
      }
      $query = $query . implode(", ", $values);
      $stmt = $conn->prepare($query);
      foreach ($ids as $i => $id) {
        $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
      }
      $stmt->execute();
    }
    $catDel = "DELETE FROM tasks_cat WHERE task_id = " . $this->id;
    if ($ids) {
      $placeholders = array_fill(0, count($ids), "?");
      $catDel = $catDel . " AND cat_id NOT IN (" . implode(", ", $placeholders) . ")";
    }
    $stmtDel = $conn->prepare($catDel);
    foreach ($ids as $i => $id) {
      $stmtDel->bindValue($i + 1, $id, PDO::PARAM_INT);
    }
    $stmtDel->execute();
  }
}
