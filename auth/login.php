<?php
$title = 'LOGIN';

session_start();

include '../include/init.php';

$conn = include '../include/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (User::login($conn, $_POST['email'], $_POST['password'])) {
    session_regenerate_id(true);
    $_SESSION['is_logged_in'] = true;
    $_SESSION['username'] = $_POST['username'];
    header('Location: ../tasks.php');
  } else {
    echo "<h2>the user is not found</h2>";
  }
}

?>

<?php include '../layout/header.php' ?>

<form method="POST">
  <div class="mb-3">
    <label>Username</label>
    <input type="text" class="form-control" name="username" value="asaad" required />
  </div>
  <div class="mb-3">
    <label>Email</label>
    <input type="text" class="form-control" name="email" value="asaad@gmail.com" required />
  </div>
  <div class="mb-3">
    <label>Password</label>
    <input type="password" class="form-control" name="password" value="12345678" required />
  </div>
  <div class="mb-3">
    <button class="btn btn-primary"><?= $title ?></button>
  </div>
  <p>Don't have an account? <a href="signup.php" class="link-success">SignUp Now</a></p>
  <p class="pin">Do you Forget Password <a href="pin.php" class="link-danger">Change it</a></p>
</form>

<?php include('../layout/footer.php'); ?>