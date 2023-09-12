<?php
$title = 'INSERT TASK';

session_start();

if (!$_SESSION['is_logged_in']) {
  header("Location: tasks.php");
}

include 'include/Database.php';
include 'include/Task.php';
include 'include/Category.php';

$db = new Database();
$conn = $db->getConn();

$category = Category::getAllCategory($conn);
$cat_ids = [];

// CODE FOR INSERT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $task = new Task();
  $task->name = $_POST['name'];
  $task->email = $_POST['email'];
  $task->phone = $_POST['phone'];
  $task->course = $_POST['course'];
  $task->created = $_POST['created'];
  $cat_ids = $_POST['category'] ?? [];
  if ($task->insertTask($conn)) {
    $task->setCatNewWay($conn, $cat_ids);
    header('Location: tasks.php');
  }
}

?>

<?php include 'layout/header.php' ?>

<form method="POST">
  <div class="mb-3">
    <label>Name</label>
    <input type="text" class="form-control" name="name" value="Name 1" placeholder="Name" required />
  </div>
  <div class="mb-3">
    <label>Email</label>
    <input type="text" class="form-control" name="email" value="asaad@gmail.com" placeholder="Email" required />
  </div>
  <div class="mb-3">
    <label>Phone</label>
    <input type="text" class="form-control" name="phone" value="123456789" placeholder="Phone" required />
  </div>
  <div class="mb-3">
    <label>Course</label>
    <input type="text" class="form-control" name="course" value="Course 1" placeholder="Course" required />
  </div>
  <div class="mb-3">
    <label>Created</label>
    <input type="datetime-local" class="form-control" name="created_at" required />
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
      <input type="text" class="form-control" name="image"  placeholder="Image" />
    </div> -->
  <div class="mb-3">
    <button class="btn btn-primary"><?= $title ?></button>
  </div>
</form>

<?php include('layout/footer.php'); ?>