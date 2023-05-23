<?php

namespace App\Core;

/** THE ROUTER
 * 
 */
class Router
{
  /** Associative array of routes (the routing table)
   * @var array
   */
  protected $routes = array();

  /** Parameters from the matched route
   * @var array
   */
  protected $params = array();

  /** Add a Route to the Routing Table
   * @param string $route - The route URI
   * @param array $params - Parameters (controller, action, etc)
   * @return void
   */
  public function addRoute($route, $params = array())
  {
    //var_dump($params);
    //var_dump($route);

    // Convert the route to a regular expression: escape forward slashes
    $route = preg_replace('/\//', '\\/', $route);
    //echo ('<br>Convert the route to a regular expression: escape forward slashes' . $route);

    // Convert variables e.g. {controller}
    $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
    //echo ('<br> Convert variables e.g. {controller} ' . $route);

    // Convert variables with custom regular expressions e.g. {id:\d+}
    $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
    //echo ('<br> Convert variables with custom regular expressions e.g. {id:\d+}' . $route);

    // Add start and end delimiters, and case insensitive flag
    $route = '/^' . $route . '$/i';
    //echo ('<br> Add start and end delimiters, and case insensitive flag' . $route);

    $this->routes[$route] = $params;
    //var_dump($this->routes);
  }

  /** Dispatch the route, 
   * creating the controller object and running the action method
   *
   * @param string $url - The route URI
   * @return void
   */
  public function dispatch($uri)
  {
    //www.example.com/Happy/index?page=123&title=My-home-depot
    //QueryStringVariable == ?page=123&title=My-home-depot
    $uri = $this->removeQueryStringVariables($uri);

    if ($this->match($uri)) {

      $controller = $this->params['controller'];
      // echo '<pre> ';
      //var_dump($controller);
      // echo '</pre>';
      $controller = $this->convertToStudlyCaps($controller);
      $controller = $this->setFullNamespace() . $controller;

      // echo 'full namespace : ' . $this->setFullNamespace() . '<br>';
      //echo ' full controller : ' . $controller;

      // echo '<pre> ';
      //var_dump($controller);
      // echo '</pre>';

      if (class_exists($controller)) {
        $controller_object = new $controller($this->params);

        $action = $this->params['action'];
        $action = $this->convertToCamelCase($action);

        if (is_callable([$controller_object, $action])) {
          //remove namespace & controller & action by using the unset
          //and passing the rest to the action
          //unset($this->params['namespace']);
          //unset($this->params['controller']);
          //unset($this->params['action']);
          $controller_object->$action($this->params);
        } else {
          throw new NewException("ROUTER :: The Method '$action' (in controller '$controller') was not found");
        }
      } else {
        throw new NewException("ROUTER :: The Controller for route '$uri' was not found, Check Config/routes");
      }
    } else {
      //TODO REDIRECT HEADER TO CUSTOM 404
      //throw new NewException('ROUTER :: No route matched.', 404);
      header('HTTP/1.1 404 Not Found');
      header("Refresh:0; url=404.php");
    }
  }


  /** Convert the string with hyphens to StudlyCaps,
   * e.g. post-authors => PostAuthors
   *
   * @param string $string - The string to convert
   * @return string
   */
  protected function convertToStudlyCaps($string)
  {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
  }

  /** Convert the string with hyphens to camelCase,
   * e.g. add-new => addNew
   *
   * @param string $string - The string to convert
   * @return string
   */
  protected function convertToCamelCase($string)
  {
    return lcfirst($this->convertToStudlyCaps($string));
  }

  /** Match the route to the routes in the routing table, 
   * setting the parameters if a route is found.
   *
   * @param string $url  - The route URI
   * @return boolean  - true if a match found, false otherwise
   */
  protected function match($uri)
  {
    foreach ($this->routes as $route => $params) {
      if (preg_match($route, $uri, $matches)) {
        // Get named capture group values
        foreach ($matches as $key => $match) {
          if (is_string($key)) {
            $params[$key] = $match;
          }
        }
        $this->params = $params;
        return true;
      }
    }
    return false;
  }

  /** Remove the query string variables from the URL (if any). 
   * As the full query string is used for the route, 
   * any variables at the end will need to be removed, 
   * before the route is matched to the routing table. 
   * For example:
   *
   *   URL                           $_SERVER['QUERY_STRING']  Route
   *   -------------------------------------------------------------------
   *   localhost                     ''                        ''
   *   localhost/?                   ''                        ''
   *   localhost/?page=1             page=1                    ''
   *   localhost/posts?page=1        posts&page=1              posts
   *   localhost/posts/index         posts/index               posts/index
   *   localhost/posts/index?page=1  posts/index&page=1        posts/index
   *
   * A URL of the format localhost/?page (one variable name, no value) won't
   * work however. (NB. The .htaccess file converts the first ? to a & when
   * it's passed through to the $_SERVER variable).
   *
   * @param string $url The full URL
   *
   * @return string The URL with the query string variables removed
   */
  protected function removeQueryStringVariables($url)
  {
    if ($url != '') {
      $parts = explode('&', $url, 2);
      if (strpos($parts[0], '=') === false) {
        $url = $parts[0];
      } else {
        $url = '';
      }
    }
    return $url;
  }

  /** Get the namespace for the controller class. 
   * The namespace defined in the route parameters is added if present.
   *
   * @return string The request URL
   */
  protected function setFullNamespace()
  {
    try {
      if (array_key_exists('namespace', $this->params)) {
        $namespace = '';
        $name = array();
        $name = explode('/', $this->params['namespace']);
        foreach ($name as $key => $value) {
          $namespace .= $this->convertToStudlyCaps($value) . '\\';
        }
        return $namespace;
      } else {
        throw new NewException("Router.php : setFullNamespace : namespace not in the routing table/params check Config/routes file");
      }
    } catch (NewException $e) {
      echo $e->getErrorMsg();
    }
  }


  //END-class
}
