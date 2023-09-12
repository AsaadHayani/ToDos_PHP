<?php
$title = 'SIGNUP';

session_start();

include '../include/init.php';

$conn = include '../include/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $cpass = $_POST['cpassword'];

  $query = "INSERT INTO `users`(`name`, `email`, `password`)
  VALUES (?, ?, ?)";
  if ($pass == $cpass) {
    $stmt = $conn->prepare($query);
    $stmt->execute(array($username, $email, password_hash($pass, PASSWORD_DEFAULT)));
    session_regenerate_id(true);
    $_SESSION['is_logged_in'] = true;
    $_SESSION['username'] = $_POST['username'];
    header('Location: ../tasks.php');
  } else {
    echo "<h2>Password does not Match</h2>";
  }

  // if (User::signup($conn, $username, $email, $pass, $cpass)) {
  //   session_regenerate_id(true);
  //   $_SESSION['is_logged_in'] = true;
  //   $_SESSION['username'] = $_POST['username'];
  //   header('Location: ../tasks.php');
  // } else {
  //   echo "<h2>Password does not Match</h2>";
  // }
}

?>

<?php include '../layout/header.php' ?>

<form method="POST" autocomplete="off">
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
    <label>Confirm Password</label>
    <input type="password" class="form-control" name="cpassword" value="12345678" required />
  </div>
  <div class="mb-3">
    <button class="btn btn-primary"><?= $title ?></button>
  </div>
  <p>Already have an account? <a href="login.php" class="link-success">Login Now</a></p>
</form>

<?php include('../layout/footer.php'); ?>