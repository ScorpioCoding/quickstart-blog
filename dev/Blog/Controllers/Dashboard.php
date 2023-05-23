<?php

namespace Modules\Blog\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Translation;

use App\Core\Meta;


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


    View::render($args, $meta, $trans, [
      'data' => $data
    ]);
  }

  protected function after()
  {
  }

  //END-Class
}
