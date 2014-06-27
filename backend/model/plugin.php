<?php

/**
 * User: Enthusiasmus
 * Date: 18.02.14
 * Time: 10:34
 */
class Plugin
{
    private $name;
    private $version;
    private $description;

    public function __construct($name, $version, $description)
    {
        $this->version = $version;
        $this->name = $name;
        $this->description = $description;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
}