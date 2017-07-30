<?php
/**
 * Created by PhpStorm.
 * User: Andriy
 * Date: 27.07.2017
 * Time: 20:22
 */

namespace app\controllers\admin;

use \vendor\core\base\Controller;
use app\traits\CookieTrait;

class AppController extends Controller
{
    use CookieTrait;

    public $layout = 'admin';

    /**
     * перевіряє чи залогіннений адмін, якщо так - вертає 404
     * якщо ні, то дозволяє зайти тільки на  Admins - login
     * також перевіряє чи є кука Запамятати..
     */
    public function __construct($route)
    {
        parent::__construct($route);
        session_start();
        if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
            $bool = $this->checkRememberMeCookies();
            $bool = (!$bool && $this->route['controller'] === 'Admins' && $this->route['action'] === 'login');
            if (!$bool) {
                throw new \Exception('Нема доступу', 404);
            }
        }
    }

}