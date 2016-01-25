<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
interface DataValue_Property_PropertyInterface
{

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     * @return DataValue_Property_PropertyInterface
     */
    public function setValue($value);


    /**
     * @return DataValue_Property_PropertyInterface
     */
    public function setReadOnly();

    /** @return  boolean */
    public function isValueSet();

    /**
     * @return DataValue_Property_PropertyInterface
     */
    public function setRequired();

    /** @return string */
    public function getPropertyName();
}
