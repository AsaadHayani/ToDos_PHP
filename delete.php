<?php
$title = 'DELETE TASK';

session_start();

if (!$_SESSION['is_logged_in']) {
  header("Location: tasks.php");
}

include 'include/init.php';

$conn = include 'include/db.php';

if (isset($_GET['id'])) {
  $task = Task::getTask($conn, $_GET['id']);
}

// CODE FOR DELETE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $task = Task::getTask($conn, $_GET['id']);
  if ($task->deleteTask($conn)) {
    header('Location: tasks.php');
  }
}

?>

<?php include 'layout/header.php'; ?>

<body>
  <div class="card-body d-flex justify-content-evenly">
    <h3><?= $title ?> : <?= $task->name ?></h3>
    <form method="POST">
      <button class="btn btn-primary"><?= $title ?></button>
    </form>
  </div>

  <?php include 'layout/footer.php'; ?>
