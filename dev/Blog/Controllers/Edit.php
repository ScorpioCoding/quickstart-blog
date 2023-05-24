<?php

namespace Modules\Blog\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Translation;
use App\Core\Parsedown;

use App\Core\Meta;
use Modules\Accounts\Models\mCommon;
use Modules\Accounts\Utils\Auth;
use Modules\Blog\Models\mPosts;


/**
 *  Edit
 */
class Edit extends Controller
{
  protected function before()
  {
  }

  public function indexAction($args = array())
  {
    $args['template'] = 'Backend';
    //MetaData
    $meta = array();
    $meta = (new Meta($args))->getMeta();
    // Translation
    $trans = array();
    $trans = Translation::translate($args);
    // Extra data
    $data = array();

    $acc_id = Auth::getSession('id');

    $post_id = $args['id'];
    $post = mCommon::readTableById('posts', $post_id);
    foreach ($post as $m) {
      foreach ($m as $key => $value) {
        $data[$key] = $value;
      }
    }

    if ($_POST) {
      // echo '<pre>';
      // print_r($_POST);
      // echo '</pre>';
      mPosts::update($_POST);
      foreach ($_POST as $key => $value) {
        $data[$key] = $value;
      }
    }

    $data['output'] = (new Parsedown())->text($data['content']);

    View::render($args, $meta, $trans, [
      'data' => $data,
    ]);
  }

  protected function after()
  {
  }

  //END-Class
}
