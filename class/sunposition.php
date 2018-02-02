<?php
class SunPosition
{
    public $azimuth;
    public $altitude;
    
    private $latitude;
    private $longitude;
    private $timestamp;
    
    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
    
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }
    
    public function update()
    {
        $date = Date::fromPhpTime($this->timestamp);
        $result = suncalc_SunCalc::getPosition($date, $this->latitude, $this->longitude);
        #var_dump($result);
        $this->azimuth = 180 + $result->azimuth / suncalc_SunCalc::$rad;
        $this->altitude = $result->altitude / suncalc_SunCalc::$rad;
    }
    
}
