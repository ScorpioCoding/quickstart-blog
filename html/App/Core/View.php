<?php

namespace App\Core;


/** THE VIEW
 * 
 */
class View
{
  public function __construct()
  {
    echo ('test within the class not static');
  }

  public static function setPage($args = array())
  {
    $page = PATH_MOD;
    $page .= ucfirst($args['module']) . DS . 'Views' . DS;
    $page .= strtolower($args['controller']);
    $page .= '.phtml';

    try {
      self::checkFile($page);
      return $page;
    } catch (NewException $e) {
      echo $e->getErrorMsg();
      return false;
    }
  }

  public static function setTemplate($args = array())
  {
    $template = PATH_MOD;
    $template .= ucfirst($args['module']) . DS . 'Templates' . DS;
    $template .= strtolower($args['template']);
    $template .= '.phtml';

    try {
      self::checkFile($template);
      return $template;
    } catch (NewException $e) {
      echo $e->getErrorMsg();
      return false;
    }
  }


  /*
    * rendering the page - View.php
    * @params   array   $paths
    * @params   array   $data
    */
  public static function render($args = array(), $meta = array(), $trans = array(), $data = array())
  {
    try {
      $page = self::setPage($args);

      $template = self::setTemplate($args);

      if ($page) {
        extract($meta);
        extract($trans);
        extract($data);
        require $template;
      } else {
        throw new NewException("View.php : render : Rendering FAILED");
      }
    } catch (NewException $e) {
      echo $e->getErrorMsg();
    }
  } //END render


  /*
    * Path checking at View base level - View.php
    * @params   array   $file
    */
  public static function checkFile($file)
  {
    if (!is_readable($file)) {
      throw new NewException("View.php : checkFile : File doesn't exist in Views : $file ");
      return false;
    } else {
      return true;
    }
  } //END checkFile








  //END-Class
}
