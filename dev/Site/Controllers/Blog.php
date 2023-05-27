<?php

namespace Modules\Site\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Translation;
use App\Core\Meta;

use Modules\Blog\Models\mPosts;


/**
 *  Blog
 */
class Blog extends Controller
{
  protected function before()
  {
  }

  public function indexAction($args = array())
  {
    $args['template'] = 'Frontend';
    //MetaData
    $meta = array();
    $meta = (new Meta($args))->getMeta();
    // Translation
    $trans = array();
    $trans = Translation::translate($args);
    // Extra data
    $data = array();

    $posts = mPosts::readByStatus('published');
    if ($posts) {
      foreach ($posts as $key => $value) {
        $data['posts'][$key] = $value;
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
