<?php

namespace Modules\Accounts\Utils;

/**
 * Collection of helper Functions tobe used through out the App
 * By calling on it's 'self::' or 'App::' functionality.
 */
class Functions
{

  public static function pre_e($args): void
  {
    echo '<br>';
    echo $args;
    echo '<br>';
  }

  public static function pre_r(array $args): void
  {
    echo '<pre>';
    print_r($args);
    echo '</pre>';
  }

  public static function pre_dump($obj)
  {
    echo '<pre> var_dump <br>';
    var_dump($obj);
    echo '</pre>';
    exit;
  }


  //
  //END CLASS
}
