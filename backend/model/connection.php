<?php

/**
 * User: Enthusiasmus
 * Date: 17.02.14
 * Time: 10:34
 */
class Connection
{
    private $bandwidth;
    private $metered;

    public function __construct($bandwidth, $metered)
    {
        $this->bandwidth = $bandwidth;
        $this->metered = $metered;
    }

    public function getBandwidth()
    {
        return $this->bandwidth;
    }

    public function setBandwidth($bandwidth)
    {
        $this->bandwidth = $bandwidth;
    }

    public function getMetered()
    {
        return $this->metered;
    }

    public function setMetered($metered)
    {
        $this->metered = $metered;
    }

}