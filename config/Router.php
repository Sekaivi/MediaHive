<?php
class Router {
    private $routes = [];

    // Add a route
    public function addRoute($route, $controller, $method) {
        $this->routes[$route] = ['controller' => $controller, 'method' => $method];
    }

    // Handle incoming request
    public function handleRequest($dbConnection) {
        // Get the current request URI (e.g., /user/1 or /article/123)
        $requestUri = $_SERVER['REQUEST_URI'];

        // Strip out the base URL (if it's not the root, you might have something like /MediaHive)
        $basePath = '/MediaHive';  // Adjust if necessary
        $requestUri = str_replace($basePath, '', $requestUri);

        // Split the URI into segments (e.g., /user/1 -> ['user', '1'])
        $segments = explode('/', trim($requestUri, '/'));

        // Default route (home page) if no segments are provided
        if (empty($segments[0])) {
            $segments[0] = 'home'; // Default route could be 'home' or any route you want
        }

        // Check if this route exists in the route list
        $route = $segments[0];

        // If route exists, call the appropriate controller and method
        if (array_key_exists($route, $this->routes)) {
            $controllerName = $this->routes[$route]['controller'];
            $methodName = $this->routes[$route]['method'];

            // Remove the route part (e.g., 'user', 'article') to get dynamic params
            array_shift($segments);

            // Create the controller instance
            $controller = new $controllerName($dbConnection);

            // Call the method dynamically, passing any remaining URI segments as parameters
            call_user_func_array([$controller, $methodName], $segments);
        } else {
            // If route doesn't exist, show 404
            $this->show404();
        }
    }

    // Show a 404 page
    private function show404() {
        echo "404 - Page Not Found";
    }
}


?>