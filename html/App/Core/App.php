<?php

namespace App\Core;

use App\Config\SetDb;
use App\Config\SetRoutes;


class App
{

  public function __construct()
  {
    self::setConfig();
    self::router();
  }

  private static function setConfig()
  {
    (new DotEnv(PATH_ENV . 'database.env'))->load();
    (new SetDb());
  }

  private static function router()
  {

    $routes = (new SetRoutes)->getRoutes();

    $router = new Router();

    foreach ($routes as $route => $params) {
      $router->addRoute($route, $params);
    };

    //PARSING URL
    $tokens = htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES);

    //DISPATCH
    try {
      $router->dispatch($tokens);
    } catch (NewException $e) {
      echo $e->getErrorMsg();
    }
  }

  //END-Class
}
