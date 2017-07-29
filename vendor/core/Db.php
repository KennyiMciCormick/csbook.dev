<?php

namespace vendor\core;
use \R;

class Db
{
    use SingletonTrait;
    protected $pdo;

    /**
     * Для дебагу, скіки було запитів
     * @int
     */
    public static $countSql = 0;
    /**
     * Для дебагу, запити
     * @array
     */
    public static $queries = [];


    protected function __construct()
    {
        $db = require ROOT . '/config/config_db.php';
        require LIBS . '/rb.php';

        R::setup($db['dsn'], $db['user'], $db['pass']);
        //Шоб не мінялась структура таблиці
        R::freeze(TRUE);
        //Для дебагу
//        R::fancyDebug(TRUE);



//        ALL WITHOUT REDBEAN

//        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION - шоб викидувало помилки коли нема такої таблиці і тд..
//        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC - для того шоб виводило тіки масив тіки з норм ключами
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];
        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $options);
    }







//        ALL WITHOUT REDBEAN

    /**
     * коли тре шось зробити в БД(шось записати, видалити, змінити), відповідь так/ні.
     * @return bool
     */
//    public function execute($sql, $params = [])
//    {
//        self::$countSql++;
//        self::$queries[] = $sql;
//        $stmt = $this->pdo->prepare($sql);
//        return $stmt->execute($params);
//    }


    /**
     * коли тре дістати данні з БД.
     * @return array
     */
    public function query($sql, $params = [])
    {
        self::$countSql++;
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);
        if($res !== false){
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return [];
    }

}