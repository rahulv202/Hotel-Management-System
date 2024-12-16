<?php

namespace App\Core;

class Route
{
    private $routes = [];

    // public function addRoute($method, $pattern, $callback, $middleware = [])
    // {
    //     $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $pattern);
    //     $pattern = "#^" . $pattern . "$#";
    //     $this->routes[] = compact('method', 'pattern', 'callback', 'middleware');
    // }
    public function get($method = 'GET', $pattern, $callback, $middleware = [])
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $pattern);
        $pattern = "#^" . $pattern . "$#";
        $this->routes[] = compact('method', 'pattern', 'callback', 'middleware');
    }
    public function post($method = 'POST', $pattern, $callback, $middleware = [])
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $pattern);
        $pattern = "#^" . $pattern . "$#";
        $this->routes[] = compact('method', 'pattern', 'callback', 'middleware');
    }

    public function resolve($requestUri, $requestMethod)
    {
        foreach ($this->routes as $route) {
            if ($requestMethod === $route['method'] && preg_match($route['pattern'], $requestUri, $matches)) {
                array_shift($matches); // Remove the full pattern match

                // Middleware stack
                $middlewareStack = $route['middleware'];

                // Define the final action (controller and method invocation)
                $next = function () use ($route, $matches) {
                    $controllerClass = "App\\Controllers\\" . explode('@', $route['callback'])[0]; //$route['callback'][0]; // Fully qualified class name
                    $action = explode('@', $route['callback'])[1]; //$route['callback'][1]; // Action method

                    // Check if the controller class exists
                    if (!class_exists($controllerClass)) {
                        //throw new Exception("Controller $controllerClass not found.");
                        http_response_code(404);
                        echo "Controller $controllerClass not found.";
                    }

                    // Create an instance of the controller
                    $controllerInstance = new $controllerClass();

                    // Check if the action exists in the controller
                    if (!method_exists($controllerInstance, $action)) {
                        //throw new Exception("Method $action not found in $controllerClass.");
                        http_response_code(404);
                        echo "Method $action not found in $controllerClass.";
                    }

                    // Call the controller action method
                    //print_r($matches);
                    return $controllerInstance->$action(...$matches); // Pass the extracted parameters
                };

                // Process middleware in reverse order
                foreach (array_reverse($middlewareStack) as $middleware) {
                    $next = function () use ($middleware, $requestUri, $requestMethod, $next) {
                        $middlewareInstance = new $middleware();
                        // print_r($requestUri);
                        // echo "<br><br>";
                        // print_r($requestMethod);
                        // echo "<br><br>";
                        // print_r($next);
                        // echo "<br><br>";
                        return $middlewareInstance->handle($requestUri,  $next); //$requestMethod,
                    };
                }

                // Execute the middleware stack and final action
                return $next();
            }
        }
        //throw new Exception("Route not found");
        http_response_code(404);
        echo "404 Not Found";
    }
}
