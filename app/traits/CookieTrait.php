<?php
namespace app\traits;
use app\models\Admins;

trait CookieTrait
{
    /**
     * зберігає куку на місяць
     */
    protected function setCookie($name, $value)
    {
        setcookie($name,$value,time()+60*60*24*30, '/', null, null, true);
    }

    /**
     * перевіряє чи є кука для входу в адмінку, якщо є і дані збігаються - записує сесію
     * @return boolean
     */
    protected function checkRememberMeCookies()
    {
//        debug($_COOKIE['admin']); die;
        if(!empty($_COOKIE['admin_login']) && !empty($_COOKIE['admin_pass'])){
            $config = require ROOT . '/config/config.php';
            $model = new Admins();
            $admin = $model->getAdmin();
            if ($_COOKIE['admin_login'] == $admin->login && md5($_COOKIE['admin_pass'] . $config['security_salt']) == $admin->pass) {
                $_SESSION['admin'] = true;
                return true;
            }
        }
        return false;
    }

}