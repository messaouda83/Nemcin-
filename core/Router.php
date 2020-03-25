<?php


/**
 * Class Router
 */
class Router
{
    private $uri;
    private $routes = [];
    private $namedRoutes = [];

    /**
     * Router constructor.
     * @param $uri
     */
    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function addRouteGET($path, $callable, $name = null)
    {
        return $this->addRoute($path, $callable, $name, 'GET');
    }

    /**
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function addRoutePOST($path, $callable, $name = null)
    {
        return $this->addRoute($path, $callable, $name, 'POST');
    }

    public function error404GET(string $path)
    {
        return $this->addRoute($path, "NotFound.showNotFound", null, "GET");
    }

    private function addRoute($path, $callable, $name, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     * @return mixed
     * @throws RouterException
     */
    public function startRouter()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException("REQUEST_METHOD does not exist"); //405 ??
        }

        /** @var Route $route object from Class Route. Assigned in $this->addRoute() */
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->uri)) {
                return $route->call();
            }
        }

        throw new RouterException("No routes matches"); //404
    }
}