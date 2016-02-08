<?php

namespace reseller\DataValue;

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
class Property extends \reseller\DataValue\Property\PropertyAbstract implements \reseller\DataValue\Property\PropertyInterface
{

    /** @var  mixed */
    protected $value;
    /** @var  boolean */
    protected $isReadOnly = false;
    /** @var boolean */
    protected $isValueSet = false;
    /** @var  boolean */
    protected $isRequired = false;

    /**
     * @return mixed
     * @throws DataValue_Exception_Property_Required
     */
    public function getValue()
    {
        if ($this->isRequired === true and $this->isValueSet() !== true) {
            throw  new DataValue_Exception_Property_Required();
        }
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return DataValue_Property_PropertyInterface
     * @throws DataValue_Exception_Property_ReadOnly
     */
    public function setValue($value)
    {
        if ($this->isReadOnly === true and $this->isValueSet() === true) {
            throw  new DataValue_Exception_Property_ReadOnly();
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

    /**
     * @return DataValue_Property_PropertyInterface
     */
    public function setRequired()
    {
        $this->isRequired = true;
        return $this;
    }
}
