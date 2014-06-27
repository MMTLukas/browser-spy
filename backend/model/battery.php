<?php

/**
 * User: Enthusiasmus
 * Date: 17.02.14
 * Time: 10:34
 */
class Battery
{
    private $level;
    private $isLoading;
    private $loadingDuration;
    private $unloadingDuration;

    public function __construct(
        $level, $isLoading, $loadingDuration, $unloadingDuration)
    {
        $this->level = $level;
        $this->isLoading = $isLoading;
        $this->loadingDuration = $loadingDuration;
        $this->unloadingDuration = $unloadingDuration;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public
    function getIsLoading()
    {
        return $this->isLoading;
    }

    public
    function setIsLoading($isLoading)
    {
        $this->isLoading = $isLoading;
    }

    public
    function getLoadingDuration()
    {
        return $this->loadingDuration;
    }

    public
    function setLoadingDuration($loadingDuration)
    {
        $this->loadingDuration = $loadingDuration;
    }

    public
    function getUnloadingDuration()
    {
        return $this->unloadingDuration;
    }

    public
    function setUnloadingDuration($unloadingDuration)
    {
        $this->unloadingDuration = $unloadingDuration;
    }

}