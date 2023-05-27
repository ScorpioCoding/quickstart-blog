<?php

namespace Modules\Site\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Translation;
use App\Core\Meta;
use App\Core\Parsedown;

use Modules\Blog\Models\mPosts;
use Modules\Accounts\Models\mCommon;


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
    $args['template'] = 'Frontend';
    //MetaData
    $meta = array();
    $meta = (new Meta($args))->getMeta();
    // Translation
    $trans = array();
    $trans = Translation::translate($args);
    // Extra data
    $data = array();

    if ($args['id']) {
      $post = mCommon::readTableById('posts', $args['id']);
    } else if ($args['slug']) {
      $post = mPosts::readBySlug($args['slug']);
    } else {
      $data['errorList'] = "No Blog Post Found.";
    }

    if ($post) {
      foreach ($post as $m) {
        foreach ($m as $key => $value) {
          $data[$key] = $value;
        }
      }
      $data['output'] = (new Parsedown())->text($data['content']);
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
