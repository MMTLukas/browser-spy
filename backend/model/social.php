<?php

/**
 * User: Enthusiasmus
 * Date: 18.02.14
 * Time: 10:34
 */
class Login
{
    private $state;
    private $name;

    public function __construct($name, $state)
    {
        $this->state = $state;
        $this->name = $name;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
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