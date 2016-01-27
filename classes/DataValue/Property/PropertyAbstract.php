<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
abstract class DataValue_Property_PropertyAbstract implements \DataValue_Property_PropertyInterface
{

    /** @var  string */
    protected $name;

    final public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    final public function getPropertyName()
    {
        return $this->name;
    }
}
