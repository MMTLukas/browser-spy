<?php

/**
 * User: Enthusiasmus
 * Date: 18.02.14
 * Time: 10:34
 */
class Cookie
{
    private $key;
    private $name;

    public function __construct($key, $name)
    {
        $this->key = $key;
        $this->name = $name;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

}