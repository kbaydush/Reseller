<?php

namespace reseller\Config;

use reseller\Abstract_DataValue;

class ConfigPDF extends Abstract_DataValue
{

    /** @var  string */
    protected $title;
    /** @var  string */
    protected $author;
    /** @var  integer */
    protected $lifetime;

    /**
     * Config_PDF constructor.
     * @param string $title
     * @param string $author
     * @param int $lifetime
     */
    public function __construct($title, $author, $lifetime)
    {
        $this->title = $title;
        $this->author = $author;
        $this->lifetime = $lifetime;
    }


    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ConfigPDF
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return ConfigPDF
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @param int $lifetime
     * @return ConfigPDF
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;
        return $this;
    }

}
