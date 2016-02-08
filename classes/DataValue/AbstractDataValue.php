<?php

namespace reseller\DataValue;

use reseller\DataValue\Exception\Property\Bad;
use reseller\DataValue\Exception\NotSetterNotGetter;
use reseller\DataValue\Exception;
use reseller\DataValue\Property\PropertyInterface;
use reseller\DataValue\Exeption\GetterWithoutArguments;


/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
abstract class AbstractDataValue
{
    /**
     * @var PropertyInterface[]
     */
    protected $properties = array();

    final public function __construct(array $fields = null)
    {
        if (!is_array($fields)) {
            $fields = $this->_getInitPropertyList();
        }

        if (is_array($fields)) {
            /** @var PropertyInterface $property */
            foreach ($fields as $property) {
                $this->addProperty($property);
            }
        }
    }

    /**
     * @return array
     */
    abstract protected function _getInitPropertyList();

    /**
     * @param DataValue_Property_PropertyInterface $value
     * @return DataValue_AbstractDataValue
     */
    final protected function addProperty(PropertyInterface $value)
    {
        $this->properties[mb_strtolower($value->getPropertyName())] = $value;
        return $this;
    }

    final public function __call($name, array $arguments)
    {
        $name = mb_strtolower($name);
        $prefix = mb_substr($name, 0, 3);
        $dataName = mb_substr($name, 3);

        if (!$this->isPropertyExist($dataName)) {
            throw  new Bad();
        }

        switch ($prefix) {
            case "set":
                return $this->setter($dataName, $arguments);
                break;
            case "get":
                return $this->getter($dataName, $arguments);
                break;
            default:
                throw new NotSetterNotGetter();
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

    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     * @throws DataValue_Exception_SetterOneArgument
     */
    protected function setter($name, array $arguments)
    {
        if ($this->isArgumentsCount($arguments, 1)) {
            $this->getProperty($name)->setValue(current($arguments));
            return $this;
        } else {
            throw new SetterOneArgument();
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

    /**
     * @param string $name
     * @return DataValue_Property_PropertyInterface
     */
    protected function getProperty($name)
    {
        return $this->properties[$name];
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws DataValue_Exception_GetterWithoutArguments
     */
    protected function getter($name, array $arguments)
    {
        if ($this->isArgumentsCount($arguments, 0)) {
            return $this->getProperty($name)->getValue();
        } else {
            throw new GetterWithoutArguments();
        }
    }
}
