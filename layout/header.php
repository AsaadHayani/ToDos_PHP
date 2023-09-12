<?php
// include '../include/init.php';

$db = new Database();
$conn = $db->getConn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TASKS - <?= $title ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="/web/tasks/tasks.php">TASKS</a>
      <div class="my-2 my-lg-0 d-flex">
        <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) : ?>
          <a href="/web/tasks/auth/logout.php" class="btn btn-danger">Logout</a>
        <?php else : ?>
          <a href="/web/tasks/auth/signup.php" class="btn btn-success">SignUp</a>
          <a href="/web/tasks/auth/login.php" class="btn btn-warning mx-2">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
  <div class="container">
    <div class="row">
      <div class="col-md-12 mt-4 text-center">
        <div class="d-flex <?php if (isset($tasks)) : ?> justify-content-between<?php else : ?> justify-content-end<?php endif; ?>  align-items-center text-capitalize">
          <?php if (isset($tasks)) {
            if (Task::getTotalRecord($conn) >= 1) {
              echo "<b>Tasks Count is : <span class='text-primary'>" . Task::getTotalRecord($conn) . " / Total</span></b>";
            } else {
              echo "<b class='text-danger'>Not Found Task</b>";
            }
          } ?>
          <?php if ($title != 'SIGNUP' && $title != 'LOGIN' && $title != 'PIN') : ?>
            <b>Username : <?php if (isset($_SESSION['username']) && $_SESSION['is_logged_in']) : ?>
                <span class="text-primary"><?= $_SESSION['username'] ?></span>
              <?php else : ?><span class="text-danger">Not Register</span><?php endif; ?></b>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="mb-4 col-md-12">
      <div class="card">
        <div class="d-flex <?php if ($title === "ALL TASKS") : ?>justify-content-between<?php else : ?> justify-content-end<?php endif; ?> align-items-center card-header">
          <?php if ($title === "ALL TASKS") : ?>
            <form>
              <input class="form-control mr-sm-2" type="search" placeholder="Search" id="search" />
            </form>
          <?php endif; ?>

          <div>
            <a href="/web/tasks/tasks.php" class="btn btn-info mx-2">HOME</a>
            <a href="/web/tasks/add.php" class="btn btn-primary<?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) : ?><?php else : ?> disabled
<?php endif; ?>">Add</a>
          </div>
        </div>
        <div class="card-body">