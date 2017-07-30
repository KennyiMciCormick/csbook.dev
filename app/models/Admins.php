<?php

namespace app\models;
use \R;
use vendor\core\App;

use vendor\core\base\Model;

class Admins extends Model
{
    public $table = 'admins';

    public function getAdmin()
    {
        return R::findOne($this->table);
    }

}