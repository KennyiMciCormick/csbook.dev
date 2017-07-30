<?php
/**
 * Created by PhpStorm.
 * User: Andriy
 * Date: 27.07.2017
 * Time: 20:22
 */

namespace app\controllers;

use \vendor\core\base\Controller;
use app\traits\CookieTrait;

class AppController extends Controller
{
    use CookieTrait;
    public $meta = [];
    /**
     * перевіряє чи залогіннений адмін, перевіряє чи є кука Запамятати..
     */
    public function __construct($route)
    {
        parent::__construct($route);
        session_start();
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] !== true){
            $this->checkRememberMeCookies();
        }

    }
}