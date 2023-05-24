<?php

namespace Modules\Blog\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Translation;

use App\Core\Meta;

use Modules\Blog\Models\mPosts;


/**
 *  Posts
 */
class Posts extends Controller
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

    $data['status'] = $args['status'];

    $posts = mPosts::readByStatus($args['status']);
    foreach ($posts as $key => $value) {
      $data['posts'][$key] = $value;
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
