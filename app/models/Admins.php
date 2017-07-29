<?php

namespace app\models;
use \R;
use vendor\core\App;

use vendor\core\base\Model;

class Admins extends Model
{
    public $table = 'admins';


//    public function createAdmin($login, $pass)
//    {
//        $config = require ROOT.'/config/config.php';
//        $admin = R::dispense($this->table);
//        $admin->login = $login;
//        $admin->pass = md5($pass. $config['security_salt']);
//        return R::store($admin);
//    }
    public function getAdmin()
    {
        return R::findOne($this->table);
    }

}