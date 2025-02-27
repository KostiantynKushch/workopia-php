<?php

namespace Framework;

use App\Controllers\ErrorController;

class Router
{

  protected $routes = [];

  /**
   * register route
   *
   * @param string $method
   * @param string $uri
   * @param string $action
   * @return void
   */
  public function registerRoute($method, $uri, $action)
  {
    list($controller, $controllerMethod) = explode('@', $action);

    $this->routes[] = [
      'method' => $method,
      'uri' => $uri,
      'controller' => $controller,
      'controllerMethod' => $controllerMethod,
    ];
  }

  /**
   * Add a GET router
   * 
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function get($uri, $controller)
  {
    $this->registerRoute('GET', $uri, $controller);
  }

  /**
   * Add a POST router
   * 
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function post($uri, $controller)
  {
    $this->registerRoute('POST', $uri, $controller);
  }

  /**
   * Add a PUT router
   * 
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function put($uri, $controller)
  {
    $this->registerRoute('PUT', $uri, $controller);
  }

  /**
   * Add a DELETE router
   * 
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function delete($uri, $controller)
  {
    $this->registerRoute('DELETE', $uri, $controller);
  }

  /**
   * Route the request
   * 
   * @param string $uri
   * @param string $method
   * @return void
   */
  public function route($uri)
  {
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    // Check _method input
    if ($requestMethod === 'POST' && isset($_POST['_method'])) {
      // Override the requestMethod with the value of _method
      $requestMethod = strtoupper($_POST['_method']);
    }


    // Split the current URI on segments
    $uriSegments = explode('/', trim($uri, '/'));

    foreach ($this->routes as $route) {

      // Split the route URI on segments
      $routeSegments = explode('/', trim($route['uri'], '/'));

      $match = true;

      // Check the number of segments matches
      if (count($uriSegments) === count($routeSegments) && $route['method'] === $requestMethod) {

        $params = [];
        $match = true;

        for ($i = 0; $i < count($uriSegments); $i++) {
          // if the uri's do not match and there is no param
          if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
            $match = false;
            break;
          }
          // Check fot the param and add to $params array
          if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
            $params[$matches[1]] = $uriSegments[$i];
          }
        }

        if ($match) {
          // Extract controller and controllerMethod
          $controller = 'App\\Controllers\\' . $route['controller'];
          $controllerMethod = $route['controllerMethod'];

          // Instantiate the controller and call the method
          $controllerInstance = new $controller();
          $controllerInstance->$controllerMethod($params);
          return;
        }
      }
    }

    ErrorController::notFound();
  }
}
