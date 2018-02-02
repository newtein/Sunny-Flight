<?php
class TrackPoint
{
    public $altitude;
    public $latitude;
    public $longitude;
    public $timestamp;
    public $updateType;
    
    public function __construct(stdClass $info)
    {
        $this->altitude = (int)$info->altitude;
        $this->latitude = (float)$info->latitude;
        $this->longitude = (float)$info->longitude;
        $this->timestamp = (int)$info->timestamp;
        $this->updateType = (string)$info->updateType;
    }
    
    /**
     * Azimuth between two points
     * 
     * @param TrackPoint $point
     * @return float
     */
    public function azimuthTo(TrackPoint $point)
    {
        $longitude1 = suncalc_SunCalc::$rad * $this->longitude;
        $latitude1 = suncalc_SunCalc::$rad * $this->latitude;
        
        $longitude2 = suncalc_SunCalc::$rad * $point->longitude;
        $latitude2 = suncalc_SunCalc::$rad * $point->latitude;
        
        $longDiff = $longitude2 - $longitude1;
        $y = sin($longDiff) * cos($latitude2);
        $x = cos($latitude1) * sin($latitude2)
            - sin($latitude1) * cos($latitude2) * cos($longDiff);
        $resultDegree = atan2($y, $x) / suncalc_SunCalc::$rad;
        $resultDegree = ($resultDegree + 360.) % 360;
        
        return $resultDegree;
    }
    
}
