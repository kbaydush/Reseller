<?php

/**
 * PHP Class Autoloader
 * Created by K.Baidush
 *
 */

class Autoloader implements Autoloader_Interface
{
    /** @var  string */
    protected $rootPath;
    /** @var  Logger_Interface */
    protected $logger = null;


    /**
     * @param Autoloader_Interface $loader
     */
    public static function register(Autoloader_Interface $loader)
    {
        spl_autoload_register(array($loader, 'loadClass'));
    }

    public function setLogger($filename) {

        $this->logger = new Logging($this->rootPath . $filename);

    }
    /**
     * @param string $realPath
     * @return Autoloader
     */
    public function setRootPath($realPath)
    {
        $this->rootPath = $realPath;

        return $this;
    }

    /**
     * @param string $className
     * @return boolean
     * @throws Exception
     */
    public function loadClass($className)
    {

        $classPath = $this->prepareClassPath($className);

        if (!$this->tryLoadClass($classPath)) {

            if (!is_null($this->logger)) {
                $this->logger->logError("Cant load class " . $className);
            }

            throw new Exception("Can`t load class " . $className);
        } else {
            if (!is_null($this->logger)) {
                $this->logger->logInfo(sprintf("Class %s was loaded from %sn", $className, $classPath));
            }
        }
    }

    /**
     * @param string $className
     * @return string
     */
    private function prepareClassPath($className)
    {
        $pathParts = explode('_', $className);


        return $this->rootPath . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $pathParts) . '.php';
    }

    private function tryLoadClass($classPath)
    {
        if (is_readable($classPath)) {
            include $classPath;

            return true;
        }

        return false;
    }
}
