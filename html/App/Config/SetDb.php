<?php

namespace App\Config;

/**
 * SetDb
 */

class SetDb
{
  public function __construct()
  {
    // Database Creadentials
    define('DB_TYPE', getenv('DB_TYPE'));
    define('DB_HOST', getenv('DB_HOST'));
    define('DB_CHARSET', getenv('DB_CHARSET'));
    define('DB_COLLATE', getenv('DB_COLLATE'));
    define('DB_NAME', getenv('DB_NAME'));
    define('DB_USER', getenv('DB_USER'));
    define('DB_PASS', getenv('DB_PASS'));
    define('BASE_URL', getenv('BASE_URL'));

    // Stop Getting PDO Error Reports set to 0
    error_reporting(getenv('PDO_ERROR_REPORTING'));
  }
}
