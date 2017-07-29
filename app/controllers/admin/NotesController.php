<?php
/**
 * Created by PhpStorm.
 * User: Andriy
 * Date: 29.07.2017
 * Time: 22:40
 */

namespace app\controllers\admin;

use app\models\Notes;


class NotesController extends AppController
{
    public function delete()
    {
        $this->layout = false;
        if($this->isAjax() && !empty($this->route['alias'])){
            $model = new Notes();
            echo json_encode($model->delete($this->route['alias']));
            die;
        } else {
            throw new \Exception('Сторінка не знайддена', 404);
        }
    }
    public function edit()
    {
        $this->layout = false;
        if($this->isAjax() && !empty($this->route['alias']) && !empty($_POST['msg'])){
            $model = new Notes();
            echo $model->edit($this->route['alias'], $_POST['msg']);
            die;
        } else {
            throw new \Exception('Сторінка не знайддена', 404);
        }
    }


}