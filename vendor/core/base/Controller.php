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

    /**
     * рендерить потрібну вюшку
     * @return void
     */
    public function getView()
    {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    /**
     * Сетає змінні в вюшку (можна декілька раз)
     */
    public function set($vars)
    {
        $this->vars = $this->vars + $vars;
    }

    /**
     * перевіряє чи виконувався запит AJAX
     * @return boolean
     */
    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * перевіряє чи виконувався запит POST
     * @return boolean
     */
    public function isPost()
    {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }

    /**
     * перенаправляє на потрібний url
     * @param string $newURL
     */
    public function redirect($newURL)
    {
        header('Location: '.$newURL);
        die();
    }
    /**
     * лоадить не дефолтну вюшку, і за потреби кидає в ню змінні з масиву
     * @param string $view
     * @param array $vars
     */
    public function loadView($view, $vars = [])
    {
        extract($vars);
        require APP. "/views/{$this->route['controller']}/{$view}.php";
    }

}