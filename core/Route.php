<?php


/**
 * Class Route
 */
class Route
{
    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    /**
     * Route constructor.
     * @param $path
     * @param $callable
     */
    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    /**
     * @param $url
     * @return bool
     */
    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, "paramMatch"], $this->path);
        $regex = "#^" . $path . "$#i";

        if (!preg_match($regex, $url, $matches)) {
            return false; //404???
        }

        array_shift($matches);
        $this->matches = $matches;

        return true;
    }

    /**
     * @return mixed
     */
    public function call()
    {
        if (is_string($this->callable)) {
            $params = explode('.', $this->callable);
            $controllerName = $params[0] . "Controller";
            $controller = new $controllerName;
            return call_user_func_array([$controller, $params[1]], $this->matches);
        }
        return call_user_func_array($this->callable, $this->matches);
    }

    /**
     * @param $match
     * @return string
     */
    private function paramMatch($match)
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

}