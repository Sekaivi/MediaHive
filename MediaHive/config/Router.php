<?php
class Router
{
    private $routes = [];
    private $cnxDB;

    public function __construct($cnxDB)
    {
        $this->cnxDB = $cnxDB;
    }

    public function addRoute($method, $url, $action)
    {
        $url = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $url);
        $this->routes[$method][$url] = $action;
    }

    public function resolve()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = substr($url, strlen("/MediaHive"));
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] as $route => $action) {
            if (preg_match('#^' . $route . '$#', $url, $params)) {
                list($controllerName, $actionName) = explode('@', $action);

                array_shift($params);

                $controller = new $controllerName($this->cnxDB);
                call_user_func_array([$controller, $actionName], $params);
                return;
            }
        }

        echo "Error: Undefined route". $route ;
    }
}

?>
