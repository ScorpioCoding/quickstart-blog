<?php

namespace Modules\Blog\Controllers;

use App\Core\Controller;

use Modules\Accounts\Models\mCommon;
use Modules\Accounts\Utils\Auth;
use Modules\Blog\Models\mPosts;


/**
 *  Create
 */
class Create extends Controller
{
  protected function before()
  {
  }

  public function indexAction($args = array())
  {


    $data = array();
    $data['acc_id'] = Auth::getSession('id');
    $data['status'] = 'drafts';
    $data['date_at'] =  date('d M Y');
    $data['img_landscape'] = 'https://picsum.photo/445/250';
    $data['img_portrait'] = 'https://picsum.photo/150/250';


    $acc = mCommon::readTableById('accounts', $data['acc_id']);
    if ($acc) {
      $data['author'] = $acc[0]['name'];
      $data['avatar'] = $acc[0]['avatar'];
    }

    $id = mPosts::createEmptyBlog($data);
    self::redirect('/blog/edit/' . $id);
  }

  protected function after()
  {
  }

  //END-Class
}
