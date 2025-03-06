<?php
class Mage
{
    private static $registory;
    public static function init()
    {
        $front = new Core_Controller_Front();
        $front->init();
    }

    public static function getModel($className)
    {
        $class = str_replace('/', '_Model_', $className);
        $class = ucwords($class, '_');
        return new $class;
    }
    public static function getSingleton($className)
    {
        $class = str_replace('/', '_Model_', $className);
        $class = ucwords($class, '_');
        if (isset(self::$registory[$className])) {
            return self::$registory[$className];
        } else {
            self::$registory[$className] = new $class;
            return self::$registory[$className];
        }
    }
    public static function getBlockSingleton($className)
    {
        $class = str_replace('/', '_Block_', $className);
        $class = ucwords($class, '_');
        if (isset(self::$registory[$className])) {
            return self::$registory[$className];
        } else {
            self::$registory[$className] = new $class;
            return self::$registory[$className];
        }
    }
    public static function getBlock($className)
    {
        $class = str_replace('/', '_Block_', $className);
        $class = ucwords($class, '_');
        return new $class;
    }
    public static function getBaseDir()
    {
        return 'C:/xampp/htdocs/ecommerceweb/';
    }

    public static function getBaseUrl()
    {
        return 'http://localhost/ecommerceweb/';
    }
}