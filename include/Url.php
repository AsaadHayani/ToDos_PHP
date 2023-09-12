<?php

class Url
{
  public static function redirect($path)
  {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/web/tasks/' . $path);
  }
}
