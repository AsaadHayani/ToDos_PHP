<?php
$title = 'UPDATE TASK';

session_start();

if (!$_SESSION['is_logged_in']) {
  header("Location: tasks.php");
}

include 'include/init.php';

$conn = include 'include/db.php';

$category = Category::getAllCategory($conn);

// CODE FOR UPDATE
if (isset($_GET['id'])) {
  $task = Task::getTask($conn, $_GET['id']);
  $myCategory = $task->getCategories($conn);
  $cat_ids = array_column($myCategory, 'id');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $task->name = $_POST['name'];
  $task->email = $_POST['email'];
  $task->phone = $_POST['phone'];
  $task->course = $_POST['course'];
  $task->created = $_POST['created'];
  $cat_ids = $_POST['category'] ?? [];
  if ($task->updateTask($conn)) {
    $task->setCatNewWay($conn, $cat_ids);
    header('Location: tasks.php');
  }
}

?>

<?php include 'layout/header.php' ?>

<form method="POST">
  <div class="mb-3">
    <label>Name</label>
    <input type="text" class="form-control" name="name" value="<?= $task->name ?>" placeholder="Name" required />
  </div>
  <div class="mb-3">
    <label>Email</label>
    <input type="text" class="form-control" name="email" value="<?= $task->email ?>" placeholder="Email" required />
  </div>
  <div class="mb-3">
    <label>Phone</label>
    <input type="text" class="form-control" name="phone" value="<?= $task->phone ?>" placeholder="Phone" required />
  </div>
  <div class="mb-3">
    <label>Course</label>
    <input type="text" class="form-control" name="course" value="<?= $task->course ?>" placeholder="Course" required />
  </div>
  <div class="mb-3 d-flex justify-content-between">
    <label>Categories:</label>
    <?php foreach ($category as $cat) : ?>
      <div>
        <label for="<?= $cat['id'] ?>"><?= $cat['name'] ?></label>
        <input type="checkbox" name="category[]" id="<?= $cat['id'] ?>" value="<?= $cat['id'] ?>" <?php if (in_array($cat['id'], $cat_ids)) : ?> checked<?php endif; ?>>
      </div>
    <?php endforeach; ?>
  </div>
  <!-- <div class="mb-3">
      <label>Course</label>
      <input type="text" class="form-control" name="image" value="<?= $task->course ?>" placeholder="Image" />
    </div> -->
  <div class="mb-3">
    <button class="btn btn-primary"><?= $title ?></button>
  </div>
</form>

<?php include('layout/footer.php'); ?>