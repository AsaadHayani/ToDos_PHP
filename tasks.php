<?php
session_start();

$title = 'ALL TASKS';

include 'include/init.php';

$conn = include 'include/db.php';

$paginator = new Paginator(isset($_GET['page']) ? $_GET['page'] : 1, 3, Task::getTotalRecord($conn));

// CODE FOR VIEW ALL ELEMENTS
$tasks = Task::forPaginate($conn, $paginator->limit, $paginator->offset);

?>

<?php include 'layout/header.php'; ?>

<table class="table table-bordered text-center align-middle" id="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Cource</th>
      <th>Created</th>
      <th>Details</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($tasks) :
      foreach ($tasks as $task) : ?>
        <tr>
          <td><?= $task['id'] ?></td>
          <td><?= $task['name'] ?></td>
          <td><?= $task['email'] ?></td>
          <td><?= $task['phone'] ?></td>
          <td><?= $task['course'] ?></td>
          <td><?= $task['created'] ?></td>
          <td><a href="details.php?id=<?= $task['id'] ?>" class="btn btn-success">Details</a></td>
          <td><a href="edit.php?id=<?= $task['id'] ?>" class="btn btn-info<?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) : ?><?php else : ?> disabled<?php endif; ?>">Edit</a></td>
          <td><a href="delete.php?id=<?= $task['id'] ?>" class="btn btn-danger<?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) : ?><?php else : ?> disabled<?php endif; ?>">Delete</a></td>
        </tr>
      <?php endforeach; ?>
    <?php else : ?>
      <tr>
        <td colspan="9">
          <h5 class="text-danger">The Elements is Not Found, Or Wrong</h5>
        </td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item <?php if (!$paginator->prev) : ?>disabled<?php endif; ?>"><a class="page-link" href="?page=<?= $paginator->prev ?>">Previous</a></li>
    <li class="page-item <?php if (!$paginator->next) : ?>disabled<?php endif; ?>"><a class="page-link" href="?page=<?= $paginator->next ?>">Next</a></li>
  </ul>
</nav>

<?php include("layout/footer.php") ?>