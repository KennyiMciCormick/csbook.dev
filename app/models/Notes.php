<?php

namespace app\models;

use \R;

use vendor\core\base\Model;

class Notes extends Model
{
    public $table = 'notes';

    /**
     * захист від XSS.. обрізає таги.. найшов ше функці htmlentities і htmlspecialchars..
     * але потім подумав шо раз обрізаю всі таги то вони не потрібні)
     * @param array $data
     * @return  array
     */
    protected function stripAllTags($data)
    {
        foreach ($data as $key => $item) {
            if (is_string($item)) {
                $item = strip_tags($item);
//                $item = htmlentities($item, ENT_QUOTES, "UTF-8");
//                $item = htmlspecialchars($item, ENT_QUOTES);
                $data[$key] = $item;
            }
        }
        return $data;
    }

    /**
     * перевіряє чи змінна являється корректним email
     * @param string $email
     * @return  string
     */
    public function isEmail($email)
    {
        return (filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    /**
     * перевіряє на наявність всіх обовязкових полів
     * @param array $data
     * @return  boolean
     */
    public function defaultValidate($data)
    {
        extract($data);
        return (!empty($name) && !empty($email) && $this->isEmail($email) && !empty($message));
    }

    /**
     * Вертає Айпі клієнта, якшо не находить вертає UNKNOWN
     * @return  string
     */
    function get_client_ip() {
        $ip = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ip = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = 'UNKNOWN';
        return $ip;
    }

    /**
     * Зберігає запис в таблицю
     * @param array $data
     * @return  boolean
     */
    public function saveNote($data)
    {
        $data = $this->stripAllTags($data);
        if ($this->defaultValidate($data)) {
            $note = R::dispense($this->table);
            $note->name = $data['name'];
            $note->email = $data['email'];
            $note->message = $data['message'];
            $note->site = (!empty($data['site'])) ? $data['site'] : null;
            $note->user_ip = $this->get_client_ip();
            $note->user_browser = (!empty( $_SERVER['HTTP_USER_AGENT'])) ?  $_SERVER['HTTP_USER_AGENT'] : 'UNKNOWN';
            $note->created = time();
            return R::store($note);
        }
        return false;
    }

    /**
     * видаляє запис з таблиці по id
     * @param int $id
     * @return  boolean
     */
    public function delete($id)
    {
        $note = R::load($this->table, $id);
        R::trash($note);
        return true;
    }

    /**
     * дозволяє редагувати повідомлення в записі по id, вуртає збережене повідомлення
     * @param int $id
     * @param string $msg
     * @return  string
     */
    public function edit($id, $msg)
    {
        $note = R::load($this->table, $id);
        $note->message = strip_tags($msg);
        R::store($note);
        return nl2br($note->message);

    }

    /**
     * Вертає пагіновані записи з таблиці, посортовані відповідно до параметрів,
     * також вертає к-сть сторінок
     * @param int $page
     * @param string $sort
     * @param string $direction
     * @return  array
     */
    public function getNotes($page, $sort, $direction)
    {
        date_default_timezone_set('Europe/Kiev');
//        $t = R::exec("SELECT COUNT(*) FROM `notes`");

//        Зробив через ПДО, бо через Ред бін завжди видавало один.. хз чо..
        $total = $this->pdo->query("SELECT COUNT(*) FROM `notes`")[0]['COUNT(*)'];
        $limit = 5;
        $pages = ceil($total / $limit);
        $offset = ($page - 1)  * $limit;

        if(!empty($sort) && !empty($direction)){
            $sql = "ORDER BY
                $sort $direction
            LIMIT
                ?
            OFFSET
                ?";
            $options = [
                $limit,
                $offset];
        } else {
            $sql = "ORDER BY
                created DESC
            LIMIT
                ?
            OFFSET
                ?";
            $options = [$limit, $offset];
        }
        $notes = R::findAll($this->table, $sql, $options);
        return ['notes' => $notes, 'notes_pages' => $pages];
    }

}