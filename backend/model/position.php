<?php

/**
 * User: Enthusiasmus
 * Date: 17.02.14
 * Time: 10:34
 */
class Position
{
    private $timestamp;
    private $latitude;
    private $longitude;
    private $accuracy;
    private $altitude;
    private $altitudeAccuracy;
    private $speed;
    private $heading;

    public function __construct(
        $timestamp, $latitude, $longitude, $accuracy, $altitude, $altitudeAccuracy, $speed, $heading)
    {
        $this->timestamp = $timestamp;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->accuracy = $accuracy;
        $this->altitude = $altitude;
        $this->altitudeAccuracy = $altitudeAccuracy;
        $this->speed = $speed;
        $this->heading = $heading;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    public function getAccuracy()
    {
        return $this->accuracy;
    }

    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;
    }

    public function getAltitude()
    {
        return $this->altitude;
    }

    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
    }

    public function getAltitudeAccuracy()
    {
        return $this->altitudeAccuracy;
    }

    public function setAltitudeAccuracy($altitudeAccuracy)
    {
        $this->altitudeAccuracy = $altitudeAccuracy;
    }

    public function setSpeed($speed)
    {
        $this->speed = $speed;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function setHeading($heading)
    {
        $this->heading = $heading;
    }

    public function getHeading()
    {
        return $this->heading;
    }
}