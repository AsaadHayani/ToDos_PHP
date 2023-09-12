<?php
spl_autoload_register(function ($class) {
  include dirname(__DIR__) . "/include/" . $class . ".php";
});
