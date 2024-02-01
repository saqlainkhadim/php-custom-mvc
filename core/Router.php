<?php

namespace app\core;


class Router
{
    protected array $routes = [];
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get(string $path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false){
            return "Not Found";
        }

        if(is_string($callback)){
            return $this->renderView($callback);
        }
        return call_user_func($callback);
    }

    private function renderView(string $view)
    {
        require_once __DIR__."/../views/$view.php";
    }
}