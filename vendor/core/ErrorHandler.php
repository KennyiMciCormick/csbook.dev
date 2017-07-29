<?php
/**
 * Created by PhpStorm.
 * User: Andriy
 * Date: 28.07.2017
 * Time: 23:47
 */

namespace vendor\core;


class ErrorHandler
{
    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }
        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        $this->logSave($errstr, $errfile, $errline);
        $this->displayError($errno, $errstr, $errfile, $errline);
        return true;
    }

    public function fatalErrorHandler()
    {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            $this->logSave($error['message'], $error['file'], $error['line']);
            ob_end_clean();
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }

    public function exceptionHandler($e)
    {
        $this->logSave($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Виняток', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

    protected function logSave($msg = '', $file = '', $line = '')
    {
        error_log("[" . date('Y-m-d H:i:s') . "] Текст помилки: {$msg} | Файл: {$file}, | Рядок: {$line}\n==========================\n", 3, ROOT . '/tmp/errors.log');
    }


    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500)
    {
        http_response_code($response);

        if (DEBUG) {
            require ROOT . '/app/views/errors/dev.php';
        } else {
            if ($response == 404) {
                require ROOT . '/app/views/errors/404.html';
                die;
            }
            require ROOT . '/app/views/errors/prod.php';
        }
        die;
    }
}