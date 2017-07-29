<?php


namespace app\controllers;

use app\models\Notes;
use app\widgets\tables\NotesTable;


class NotesController extends AppController
{

    public function index()
    {
        require WWW . '/botdetect.php';
        $Captcha = new \Captcha("Captcha");
        $Captcha->UserInputID = "CaptchaCode";
        $model = new Notes();
        if ($this->isAjax()) {
            $this->layout = false;
            if (!$Captcha->Validate()) {
                echo json_encode(['error' => 'Капча введена невірно!']);
//                echo json_encode(['error' => 'RRR']);
                die;
            }
            if (!$model->saveNote($_POST)) {
                echo json_encode(['error' => 'Помилка валідації']);
                die;
            }
            echo json_encode(['error' => 0]);
            die;
        }
        if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
            $this->set(['admin' => true]);
        }
        $table = new NotesTable($_GET, $model);

        if (!empty($_SESSION['error'])) {
            $this->set(['error' => $_SESSION['error']]);
            unset($_SESSION['error']);
        }
        $captcha = $Captcha->Html();

        $this->set(['captcha' => $captcha, 'table' => $table->table_html]);
    }

    public function updateTable()
    {
        $this->layout = false;
        if ($this->isAjax()) {
            $model = new Notes();
            $table = new NotesTable($_GET, $model);
            echo $table->table_html;
            die;
        }
        throw new \Exception('Сторінка не найдена', 404);
    }


}