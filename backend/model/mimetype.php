<?php

/**
 * User: Enthusiasmus
 * Date: 18.02.14
 * Time: 10:34
 */
class MimeType
{
    private $name;
    private $suffix;
    private $type;
    private $plugin;

    public function __construct($name, $suffix, $type, $plugin)
    {
        $this->name = $name;
        $this->suffix = $suffix;
        $this->type = $type;
        $this->plugin = $plugin;
    }

    public function getSuffix()
    {
        return $this->suffix;
    }

    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPlugin()
    {
        return $this->plugin;
    }

    public function setPlugin($plugin)
    {
        $this->plugin = $plugin;
    }
}