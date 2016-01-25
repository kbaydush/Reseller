<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
abstract class DataValue_AbstractDataValue
{
    protected $properties = array();

    final  public function __construct()
    {
        $this->_initFields();
    }

    abstract protected function _initFields();

    final public function __call($name, array $arguments)
    {
        $prefix = mb_substr($name, 0, 3);
        $dataName = mb_strtolower(mb_substr($name, 3));

        if (!$this->isPropertyExist($dataName)) {
            throw  new DataValue_Exception_BadProperty();
        }

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

    /**
     * @param string $dataName
     * @return bool
     */
    protected function isPropertyExist($dataName)
    {
        return isset($this->properties[$dataName]);
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

    /**
     * @param array $arguments
     * @param integer $count
     * @return bool
     */
    protected function isArgumentsCount(array $arguments, $count)
    {
        return count($arguments) === $count;
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
     * @param string $name
     * @param mixed $value
     * @return DataValue_AbstractDataValue
     */
    final protected function addProperty($name, $value)
    {
        $this->properties[mb_strtolower($name)] = $value;
        return $this;
    }
}
