<?php
class Auth {
  public static function isLoggedIn() {
    return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
  }
  public static function reqLogged() {
    if (!static::isLoggedIn()) {
      die("<h2 style='color:#870000;text-align:center'>UnAuthorised</h2>");
    }
  }
}