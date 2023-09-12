<?php
$title = 'DETAILS TASK';

session_start();

include 'include/init.php';

$conn = include 'include/db.php';

// CODE FOR VIEW DETAILS ONE ELEMENT
if (isset($_GET['id'])) {
  $task = Task::getTaskwithCategory($conn, $_GET['id']);
} else {
  $task = null;
}

?>

<?php include 'layout/header.php'; ?>

<table class="table table-bordered text-center align-middle">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Cource</th>
      <th>Created</th>
      <th>Category</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($task) : ?>
      <tr>
        <td><?= $task[0]['id'] ?></td>
        <td><?= $task[0]['name'] ?></td>
        <td><?= $task[0]['email'] ?></td>
        <td><?= $task[0]['phone'] ?></td>
        <td><?= $task[0]['course'] ?></td>
        <td><?= $task[0]['created'] ?></td>
        <td>
          <ul class="m-0 p-0" style="list-style:none;">
            <?php foreach ($task as $t) : ?>
              <?php if ($t['cat'] != '') : ?>
                <li style="font-size: 13px;"><?= $t['cat'] ?></li>
              <?php else : ?>
                <li>No Category</li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </td>
        <td><a href="edit.php?id=<?= $task[0]['id'] ?>" class="btn btn-info<?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) : ?><?php else : ?> disabled<?php endif; ?>">Edit</a></td>
        <td><a href="delete.php?id=<?= $task[0]['id'] ?>" class="btn btn-danger<?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) : ?><?php else : ?> disabled<?php endif; ?>">Delete</a></td>
      </tr>
    <?php else : ?>
      <tr>
        <td colspan="8">
          <h5 class="text-danger">The Element is Not Found, Or Wrong</h5>
        </td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>
<?php include 'layout/footer.php'; ?>
