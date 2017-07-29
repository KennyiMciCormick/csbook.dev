<?php

namespace vendor\core\base;


abstract class Controller
{
    /**
     * Поточний маршрут
     * @var array
     */
    public $route = [];

    /**
     * Поточний вид
     * @var string
     */
    public $view;

    /**
     * Поточний лайаут
     * @var string
     */
    public $layout;

    /**
     * Данні з контроллера
     * @var array
     */
    public $vars = [];

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = $route['action'];
    }

    public function getView()
    {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);

    }

    public function set($vars)
    {
        $this->vars = $this->vars + $vars;
    }

    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function isPost()
    {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }

    public function redirect($newURL)
    {
        header('Location: '.$newURL);
        die();
    }

    public function loadView($view, $vars = [])
    {
        extract($vars);
        require APP. "/views/{$this->route['controller']}/{$view}.php";
    }

}