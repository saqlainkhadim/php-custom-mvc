<?php


namespace app\core;


class Controller
{
    private $layout = 'main';

    public function render(string $view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

}