<?php
use vendor\core\Router;

$query = rtrim($_SERVER['QUERY_STRING'], '/');

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__));
define('LIBS', dirname(__DIR__) . '/vendor/libs');
define('APP', dirname(__DIR__) . '/app');
define('CACHE', dirname(__DIR__) . '/tmp/cache');
define('LAYOUT', 'default');
define('DEBUG', 0);

require '../vendor/libs/functions.php';

spl_autoload_register(function ($class) {
    $file =  str_replace('\\', '/', ROOT . '/' .$class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

new \vendor\core\App;

//Router::add('^page/?(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Page']);
//Router::add('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Page', 'action' => 'view']);


//    default
Router::add('^admin$', ['controller' => 'Admins', 'action' => 'login', 'prefix' => 'admin']);
//Router::add('^admin/?(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Admins', 'prefix' => 'admin']);
Router::add('^admin/?(?P<action>[a-z-]+)$', ['controller' => 'Admins', 'prefix' => 'admin']);

Router::add('^admin/?(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/(?P<alias>[0-9]+)?$', ['prefix' => 'admin']);



Router::add('^$', ['controller' => 'Notes', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');


Router::dispatch($query);
