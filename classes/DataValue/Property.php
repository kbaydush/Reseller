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
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
