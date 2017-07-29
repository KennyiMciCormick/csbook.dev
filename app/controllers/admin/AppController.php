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

    public $meta = [];
    public $layout = 'admin';
//    типу beforeFilter? initialize і тд..
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

    protected function setMeta($title = '', $description = '', $keywords = '')
    {
        $this->meta['title'] = $title;
        $this->meta['description'] = $description;
        $this->meta['keywords'] = $keywords;
    }
}