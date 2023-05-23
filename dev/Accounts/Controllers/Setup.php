<?php

namespace Modules\Accounts\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Translation;
use App\Core\Meta;
use Modules\Accounts\Models\mAccounts;
use Modules\Accounts\Models\mCommon;
use Modules\Accounts\Utils\Auth;


/**
 *  Setup
 */
class Setup extends Controller
{
  protected function before()
  {
  }

  public function indexAction($args = array())
  {
    $args['template'] = 'Basic';
    //MetaData
    $meta = array();
    $meta = (new Meta($args))->getMeta();
    // Translation
    $trans = array();
    $trans = Translation::translate($args);
    // Extra data
    $data = array();


    //1. test for connection
    if (!mCommon::testForConnection())
      echo 'No Database connection';

    //2 & 3. read from user table where super
    if (mCommon::testForTable('accounts')) {
      $res = mAccounts::readByPermission('super');
      if (empty($res)) {
        //4. Need to create user
        $data['readonly'] = false;
      } else {
        self::redirect('/backend');
        exit();
      }
    }

    if ($_POST) {
      $data['errorList'] = mAccounts::validate($_POST);
      if (empty($data['errorList'])) {
        $id = mAccounts::create($_POST);
        if ($id > 0) {
          //TODO Create tables
          //mCommon::createTables($id);
          self::redirect('/backend');
        }
      }
      if (!empty($data['errorList'])) {
        foreach ($_POST as $key => $value) {
          $data[$key] = $value;
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
