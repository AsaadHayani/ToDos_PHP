<?php
session_start();

$_SESSION['is_logged_in'] = false;

header('Location: ../tasks.php');
