<?php
$title = 'Reset Password';

session_start();

include '../include/init.php';

$conn = include '../include/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $npass = $_POST['npass'];
  $cnpass = $_POST['cnpass'];

  $query = "UPDATE `users` SET `password` = ? WHERE email = ?";
  if ($npass == $cnpass) {
    $stmt = $conn->prepare($query);
    $stmt->execute(array(password_hash($npass, PASSWORD_DEFAULT), $email));
    session_regenerate_id(true);
    $_SESSION['is_logged_in'] = true;
    header('Location: ../tasks.php');
  } else {
    echo "<h2>Password does not Match</h2>";
  }
}

?>

<?php include '../layout/header.php' ?>

<form method="POST">
  <div class="mb-3">
    <label>Email</label>
    <input type="text" class="form-control" name="email" value="asaad@gmail.com" required />
  </div>
  <div class="mb-3">
    <label>Password</label>
    <input type="password" class="form-control" name="npass" value="12345678" required />
  </div>
  <div class="mb-3">
    <label>Confirm Password</label>
    <input type="password" class="form-control" name="cnpass" value="12345678" required />
  </div>
  <button class="btn btn-primary"><?= $title ?></button>
</form>

<?php include('../layout/footer.php'); ?>