<?php

/**
 * User: Enthusiasmus
 * Date: 17.02.14
 * Time: 10:34
 */
class Photo
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }
}