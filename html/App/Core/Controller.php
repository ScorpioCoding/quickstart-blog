<?php

namespace App\Core;

use RecursiveIteratorIterator;
use RecursiveArrayIterator;

abstract class Controller
{
  protected $route_params = array();

  public function __construct($route_params = array())
  {
    $this->route_params = $route_params;
  }

  public function getRouteParams()
  {
    return $this->route_params;
  }


  /** Magic method called when a non-existent or inaccessible method is
   * called on an object of this class. Used to execute before and after
   * filter methods on action methods. Action methods need to be named
   * with an "Action" suffix, e.g. indexAction, showAction etc.
   *
   * @param string $name  - Method name
   * @param array $args   - Arguments passed to the method
   * @return void
   */
  public function __call($name, $args)
  {
    $method = $name . 'Action';
    try {

      if (method_exists($this, $method)) {
        if ($this->before() !== false) {
          call_user_func_array([$this, $method], $args);
          $this->after();
        }
      } else {
        throw new NewException("Controller.php : Method $method not found in controller : " . get_class($this));
      }
    } catch (NewException $e) {
      echo $e->getErrorMsg();
    }
  }


  /** Before filter - called before an action method.
   *
   * @return void
   */
  protected function before()
  {
  }

  /** After filter - called after an action method.
   *
   * @return void
   */
  protected function after()
  {
  }

  /**
   * Redirect to a Different Page
   * @param string : $url -> The Relative path
   * @return void
   */
  public function redirect($url)
  {
    header('Location:' . $url, true, 303);
    //header('Location: http://bing.com', true, 301);
    exit;
  }





  //END-Class
}
