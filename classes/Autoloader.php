<?php

class Autoloader
{
    private static $_lastLoadedFilename;

    public static function loadPackages($className)
    {
        $pathParts = explode('_', $className);
        self::$_lastLoadedFilename = implode(DIRECTORY_SEPARATOR, $pathParts) . '.php';
//        echo self::$_lastLoadedFilename;
        require_once(self::$_lastLoadedFilename);
    }

    public static function loadPackagesAndLog($className)
    {
        self::loadPackages($className);
        printf("Class %s was loaded from %sn", $className, self::$_lastLoadedFilename);
    }
}