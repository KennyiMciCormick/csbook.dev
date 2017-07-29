<?php

namespace app\controllers\admin;

use app\models\Admins;


class AdminsController extends AppController
{

    public function login()
    {
        if(isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
            throw new \Exception('сторінку не знайдено', 404);
        };
        require WWW . '/botdetect.php';
        $Captcha = new \Captcha("CaptchaAdmin");
        $Captcha->UserInputID = "CaptchaCode";
        if ($this->isPost()) {
            if (!$Captcha->Validate()) {
                $_SESSION['error'] = 'Капча введена не вірно!';
                $this->redirect('/admin/login');
            }
            $data = $_POST;
            extract($data);
            if (!empty($login) && !empty($pass)) {
                $config = require ROOT . '/config/config.php';
                $model = new Admins();
                $admin = $model->getAdmin();
                if ($login == $admin->login && md5($pass . $config['security_salt']) == $admin->pass) {
                    if (isset($rememberMe) && $rememberMe == 'on') {
                        $this->setCookie("admin_login", $login);
                        $this->setCookie("admin_pass", $pass);
                    }
                    $_SESSION['admin'] = true;
                    $this->redirect('/');
                }
            }
            $_SESSION['error'] = 'Логін або пароль введені невірно!';
            $this->redirect('/admin/login');
        }
        $error = '';

        if(!empty($_SESSION['error'])){
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        $captcha = $Captcha->Html();
        $captcha = str_replace('src="botdetect.php', 'src="http://csbook.dev/botdetect.php', $captcha);
        $this->set(compact(['captcha', 'error']));
    }

    public function test()
    {

    }

    public function logout()
    {
        unset($_SESSION['admin']);
        unset($_COOKIE['admin_login']);
        unset($_COOKIE['admin_pass']);
        setcookie('admin_login', null, -1, '/');
        setcookie('admin_pass', null, -1, '/');
        $this->redirect('/');
    }
}