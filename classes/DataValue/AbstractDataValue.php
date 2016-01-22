<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
abstract class DataValue_AbstractDataValue
{
    final  public function __construct()
    {
        $this->_initFields();
    }

    final public function __call($name, array $arguments)
    {
        $prefix = mb_substr($name, 0, 3);
        $dataName = mb_strtolower(mb_substr($name, 3));
        switch ($prefix) {
            case "set":
                $this->setter($dataName, $arguments);
                break;
            case "get":
                $this->getter($dataName, $arguments);
                break;
            default:
                throw new DataValue_Exception_NotSetterNotGetter();
        }
    }

    protected function setter($name, array $arguments)
    {
        if ($this->isArgumentsCount($arguments, 1)) {
            var_dump($name);
            var_dump($arguments);
        } else {
            throw new DataValue_Exception_SetterOneArgument();
        }
    }

    protected function getter($name, array $arguments)
    {
        if ($this->isArgumentsCount($arguments, 0)) {
            var_dump($name);
            var_dump($arguments);
        } else {
            throw new DataValue_Exception_GetterWithoutArguments();
        }
    }

    /**
     * @param array $arguments
     * @param integer $count
     * @return bool
     */
    protected function isArgumentsCount(array $arguments, $count)
    {
        return count($arguments) === $count;
    }

    abstract protected function _initFields();
}
