<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
class DataValue_Property implements DataValue_Property_PropertyInterface
{

    /** @var  mixed */
    protected $value;
    /** @var  boolean */
    protected $isReadOnly = false;
    /** @var boolean */
    protected $isValueSet = false;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return DataValue_Property_PropertyInterface
     * @throws DataValue_Exception_ReadOnlyProperty
     */
    public function setValue($value)
    {
        if ($this->isReadOnly === true and $this->isValueSet() === true) {
            throw  new DataValue_Exception_ReadOnlyProperty();
        }
        $this->value = $value;
        $this->isValueSet = true;
        return $this;
    }

    /** @return  boolean */
    public function isValueSet()
    {
        return ($this->isValueSet);
    }

    /**
     * @return DataValue_Property_PropertyInterface
     */
    public function setReadOnly()
    {
        $this->isReadOnly = true;
        return $this;
    }
}
