<?php

namespace Modules\Blog\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Translation;

use App\Core\Meta;

use Modules\Blog\Models\mPosts;


/**
 *  Dashboard
 */
class Dashboard extends Controller
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

    $data['drafts'] = mPosts::countByStatus('drafts');
    $data['published'] = mPosts::countByStatus('published');
    $data['archived'] = mPosts::countByStatus('archived');



    View::render($args, $meta, $trans, [
      'data' => $data
    ]);
  }

  protected function after()
  {
  }

  //END-Class
}
