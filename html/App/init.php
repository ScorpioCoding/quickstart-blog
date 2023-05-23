<?php

use App\Core\App;

define("DS", DIRECTORY_SEPARATOR);
define('PATH_ROOT', dirname(__FILE__, 2) . DS);
define("PATH_ENV", PATH_ROOT . ".env" . DS);
define("PATH_APP", PATH_ROOT . "App" . DS);
define("PATH_MOD", PATH_ROOT . "Modules" . DS);

// autoloading classes
spl_autoload_register(function ($class) {
  // Replacing Backward slashes with forward slashes
  $class = str_replace("\\", "/", $class);
  $class = PATH_ROOT . $class . '.php';
  if (is_readable($class)) require $class;
});

// Invoking App
(new App());
