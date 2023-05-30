<?php

namespace Modules\Accounts\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Meta;
use Modules\Accounts\Models\mCommon;
use Modules\Accounts\Models\mAccounts;
use Modules\Accounts\Utils\Auth;



/**
 *  Accounts - Profile
 */
class Profile extends Controller
{
  protected function before()
  {
    if (Auth::sessionValide())
      self::redirect('/backend');
  }

  public function indexAction($args = array())
  {
    $args['template'] = 'Basic';
    //MetaData
    $meta = array();
    $meta = (new Meta($args))->getMeta();
    // Translation
    $trans = array();
    // Extra data
    $data = array();

    if ($_POST) {

      $data['errorList'] = mAccounts::validateLogin($_POST);

      if (empty($data['errorList'])) {
        $account = mAccounts::authenticate($_POST);
        if ($account) {
          if (Auth::sessionUp($account))
            self::redirect('/backend');
        }
      }
    }

    View::render($args, $meta, $trans, [
      'data' => $data
    ]);
  }

  protected function after()
  {
  }

  //END-Class
}
