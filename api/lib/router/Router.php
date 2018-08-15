<?php

/**
 * This is a modified version of PHPRouter by mohdrashid
 * GitHub: https://github.com/mohdrashid/PHPRouter
 */

require_once('Response.php');

class Router {
  private $method = null;
  private $routes = [];
  private $currentPath = null;
  private $request = null;
  private $response = null;

  /**
   * __construct() - Class constructor
   * @method __construct
   */
  public function __construct() {
    $this->currentPath = $_SERVER['REQUEST_URI'];
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->request['method'] = $_SERVER['REQUEST_METHOD'];
    $this->request['headers'] = headers_list();

    if (isset($_GET)) {
      $this->request['params'] = $_GET;
    }

    if (isset($_POST)) {
      $this->request['body'] = $_POST;
    }

    $jsonData = json_decode(file_get_contents('php://input'), true);
    if (is_array($jsonData)) {
      $this->request['body'] = array_merge($this->request['body'], $jsonData);
    }

    if (isset($_FILES)) {
      $this->request['files'] = $_FILES;
    }

    if (isset($_COOKIE)) {
      $this->request['cookies'] = $_COOKIE;
    }

    $this->response = new Response();
    $this->routes = [
      'GET' => [],
      'POST' => [],
      'PUT' => [],
      'PATCH' => [],
      'DELETE' => [],
      'defaults' => [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => []
      ]
    ];
  }

  /**
   * undefinedRoute() 
   * Displays an error message if the requested route does not exist
   * @param route
   */
  private function undefinedRoute($route) {
    http_response_code(404);
    header('Content-Type: text/plain');
    die('Cannot ' . $this->method . ' ' . $route);
  }

  /**
   * getRouteRegex()
   * Creates a regular expression based on the route
   * @param route
   */
  private function getRouteRegex($route) {
    if (preg_match('/[^-:\/_{}()a-zA-Z\d]/', $route) && $route !== '*') {
      return false;
    }

    $allowedCharacters = '[a-zA-Z0-9\_\-]+';

    $route = preg_replace('#\(/\)#', '/?', $route);
    $route = preg_replace('/:(' . $allowedCharacters . ')/', '(?<$1>' . $allowedCharacters . ')', $route);
    $route = preg_replace('/{(' . $allowedCharacters . ')}/', '(?<$1>' . $allowedCharacters . ')', $route);

    $pattern = '@^' . $route . '$@D';
    return $pattern;
  }

  public function get($route, callable ...$callbacks) {
    if ($route === '*') {
      $this->routes['defaults']['GET'] = $callbacks;
    } else {
      $this->routes['GET'][$this->getRouteRegex($route)] = $callbacks;
    }
  }

  public function post($route, callable ...$callbacks) {
    if ($route === '*') {
      $this->routes['defaults']['POST'] = $callbacks;
    } else {
      $this->routes['POST'][$this->getRouteRegex($route)] = $callbacks;
    }
  }

  public function put($route, callable ...$callbacks) {
    if ($route === '*') {
      $this->routes['defaults']['PUT'] = $callbacks;
    } else {
      $this->routes['PUT'][$this->getRouteRegex($route)] = $callbacks;
    }
  }

  public function patch($route, callable ...$callbacks) {
    if ($route === '*') {
      $this->routes['defaults']['PATCH'] = $callbacks;
    } else {
      $this->routes['PATCH'][$this->getRouteRegex($route)] = $callbacks;
    }
  }

  public function delete($route, callable ...$callbacks) {
    if ($route === '*') {
      $this->routes['defaults']['DELETE'] = $callbacks;
    } else {
      $this->routes['DELETE'][$this->getRouteRegex($route)] = $callbacks;
    }
  }

  /**
   * getCallbacks()
   * Retrieves the callbacks for the current path
   * @param method
   */
  public function getCallbacks($method) {
    if (!isset($this->routes[$method])) {
      return null;
    }

    foreach ($this->routes[$method] as $key => $val) {
      if (preg_match($key, $this->currentPath, $matches) || 
          preg_match($key, $this->currentPath . '/', $matches)) {
        $params = array_intersect_key($matches, array_flip(array_filter(array_keys($matches), 'is_string')));

        foreach ($params as $k => $v) {
          $this->request['params'][$k] = $v;
        }
        return $this->routes[$method][$key];
      }
    }
  }

  /**
   * runCallbacks()
   * Runs all the callback functions from the callbacks array
   * @param callbacks
   */
  public function runCallbacks($callbacks) {
    foreach ($callbacks as $callback) {
      $callback($this->request, $this->response);
    }
  }

  /**
   * start()
   * Starts the router
   */
  public function start() {
    $callbacks = $this->getCallbacks($this->method);
    if ($callbacks) {
      return $this->runCallbacks($callbacks);
    }
    $defaultCallbacks = $this->routes['defaults'][$this->method];
    if ($defaultCallbacks) {
      return $this->runCallbacks($defaultCallbacks);
    }
    return $this->undefinedRoute($this->currentPath);
  }
}

?>
