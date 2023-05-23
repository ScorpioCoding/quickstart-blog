<?php

namespace Modules\Accounts\Controllers;

use App\Core\Controller;
use Modules\Accounts\Utils\Auth;



/**
 *  Admin - Logout
 */
class Logout extends Controller
{
  protected function before()
  {
    if (!Auth::sessionValide())
      self::redirect('/frontend');
  }

  public function indexAction($args = array())
  {
    if (Auth::sessionDown())
      self::redirect('/frontend');
  }

  protected function after()
  {
  }

  //END-Class
}
