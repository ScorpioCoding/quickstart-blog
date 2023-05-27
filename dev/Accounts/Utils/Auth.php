<?php

namespace Modules\Accounts\Utils;

use App\Core\NewException;
use App\Core\Session;


class Auth
{
  public static function sessionUp(object $acc): bool
  {
    if ($acc) {
      $session = new Session();
      $session->set('auth', 'true');
      $session->set('id', $acc->id);
      $session->set('permission', $acc->permission);
      $session->set('created', time());
      return true;
      exit;
    }
    return false;
  }

  public static function sessionValide(): bool
  {
    $session = new Session();
    $created = $session->get('created');
    if (!isset($created)) {
      return false;
      exit;
    }

    if (time() - $created > 1800) {
      session_regenerate_id(true);
      return false;
      exit;
    }

    $auth = $session->get('auth');
    if (!isset($auth) || $auth == false) {
      return false;
      exit;
    }

    return true;
  }

  public static function getSession(string $arg)
  {
    $str = (new Session())->get($arg);
    return $str;
  }

  public static function sessionDown(): bool
  {
    $rtn = false;
    try {
      $session = new Session();
      $session->remove('auth');
      $session->remove('id');
      $session->remove('permission');
      $session->clear();
      $session->destroy();
      $rtn = true;
    } catch (NewException $e) {
      echo $e->getErrorMsg();
      $rtn = false;
    }
    return $rtn;
  }





  //
  //END CLASS
}
