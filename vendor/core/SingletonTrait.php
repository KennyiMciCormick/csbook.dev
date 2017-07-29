<?php

namespace vendor\core;


trait SingletonTrait
{
    protected static $instance;

//singleton шаблон проектування - клас має тільки один екземпляр!
    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}