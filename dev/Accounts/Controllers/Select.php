<?php

namespace Modules\Accounts\Controllers;

use App\Core\Controller;
use App\Core\NewException;
use Modules\Accounts\Models\mAccounts;
use Modules\Accounts\Models\mCommon;
use Modules\Accounts\Utils\Auth;



/**
 *  Accounts - Select
 */
class Select extends Controller
{
  protected function before()
  {
  }

  public function indexAction($args = array())
  {
    try {
      if (mCommon::testForTable('accounts')) {
        $res = mAccounts::readByPermission('super');
        if (empty($res)) {
          self::redirect('/setup');
        } else if (Auth::sessionValide()) {
          self::redirect('/backend');
        } else {
          self::redirect('/frontend');
        }
      } else {
        throw new NewException("Accounts::Select:: Table `accounts` not found");
      }
    } catch (NewException $e) {
      echo $e->getErrorMsg();
    }
  }

  protected function after()
  {
  }

  //END-Class
}
