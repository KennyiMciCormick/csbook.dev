<?php
/**
 * Created by PhpStorm.
 * User: HB
 * Date: 27.07.2017
 * Time: 18:59
 */

namespace vendor\core\base;


class View
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
    public $view = [];

    /**
     * Поточний лайаут
     * @var string
     */
    public $layout = [];

    public static  $meta = [''];

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
        $this->view = $view;
    }

    public function render($vars)
    {
       if(is_array($vars)){ extract($vars); };
        if ($this->layout !== false) {
            $file_view = APP . "/views/{$this->route['prefix']}{$this->route['controller']}/{$this->view}.php";
            ob_start();
            if (is_file($file_view)) {
                require $file_view;
            } else {
                throw new \Exception('<p>Нема в\'юшки..( ' . $file_view . '</p>', 404);
            }
            $content = ob_get_clean();

            $file_layout = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($file_layout)) {
                require $file_layout;
            } else {
                throw new \Exception('<p>Нема шаблону..( ' . $file_layout . '</p>', 404);
            }
        }
    }


}