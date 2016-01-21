<?php

class Config_Mail extends Abstract_DataValue
{
    /** @var  string */
    protected $email;
    /** @var  string */
    protected $name;

    /**
     * Config_Mail constructor.
     * @param string $email
     * @param null $name
     */
    public function __construct($email, $name = null)
    {
        $this->email = $email;
        $this->name = $name;

        if (is_null($name)) {
            $this->name = $email;
        }
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->getName() . " <" . $this->getEmail() . " >";
    }


}
