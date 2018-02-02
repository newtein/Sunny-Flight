<?php
class Aggregator
{
    private $sunOnLeft = 0;
    private $sunOnRight = 0;
    private $flightDuration = 0;
    /**
     * @var Flight
     */
    private $flight;
    private $firstTimestamp;
    /**
     * @var TrackPoint
     */
    private $lastPoint;
    
    public function __construct(Flight $flight)
    {
        $this->flight = $flight;
    }
    
    public function calculate()
    {
        foreach ($this->flight->getTrack() as $point) {
            $this->processPoint($point);
            $this->lastPoint = $point;
        }
    }
    
    private function processPoint(TrackPoint $point) 
    {
        if (empty($this->firstTimestamp)) {
            $this->firstTimestamp = $point->timestamp;
        }
        
        if (empty($this->lastPoint)) {
            $this->lastPoint = $point;
        }
        
        $sun = new SunPosition($point->latitude, $point->longitude);
        $timestamp = $point->timestamp - $this->firstTimestamp + $this->flight->getStartTimestamp();
        $sun->setTimestamp($timestamp);
        $sun->update();
        
        $azimuth = $point->azimuthTo($this->lastPoint);
        if (false) {
        echo $point->longitude . ' x ' . $point->latitude
            . ' -> ' . $this->lastPoint->longitude . ' x ' . $this->lastPoint->latitude 
            . ' = ' . $azimuth . PHP_EOL;
        }
        
        $timeDiff = $point->timestamp - $this->lastPoint->timestamp;
        $this->addState($sun, $azimuth, $timeDiff);
    }
    
    private function addState($sun, $azimuth, $timeDiff)
    {
        $this->flightDuration += $timeDiff;
        if ($this->isDark($sun, $azimuth))
        {
            return;
        }
        
        if ($this->checkRight($sun, $azimuth))
        {
            $this->sunOnRight += $timeDiff;
            return;
        }
        
        $this->sunOnLeft += $timeDiff;
    }
    
    private function checkRight(SunPosition $sun, $azimuth)
    {
        $diff = $sun->azimuth - $azimuth;
        
        if ($sun->azimuth > $azimuth)
        {
            if ($diff < 180.)
            {
                return true;
            }
        }
        
        if ($sun->azimuth < $azimuth)
        {
            if (abs($diff) > 180.)
            {
                return true;
            }
        }
        
        return false;
    }
    
    private function isDark(SunPosition $sun, $azimuth)
    {
        $minimumDiffGrad = 5;
        if ($sun->altitude < 0)
        {
            // Sun is behind horizont
            return true;
        }
        
        if ($sun->altitude > 90 - $minimumDiffGrad)
        {
            // Sun is straight above plane
            return true;
        }
        
        $diff = $sun->azimuth - $azimuth;
        if (abs($diff) < $minimumDiffGrad 
            || abs(180. - abs($diff)) < $minimumDiffGrad)
        {
            // Sun is straight behind or in front of the plane
            return true;
        }
        
        return false;
    }
    
    public function getStat()
    {
        return [
            'left' => $this->sunOnLeft,
            'right' => $this->sunOnRight,
            'total' => $this->flightDuration,
        ];
    }
    
}
