<?php
class Flight
{
    private $number;
    private $startTimestamp;
    private $file = '';
    
    private $info;
    
    public function __construct($number)
    {
        $this->number = $number;
        
        $this->file = DATA_DIR . 'flights' . DIRECTORY_SEPARATOR . $this->number . '.dat';
    }
    
    public function load()
    {
        if (!file_exists($this->file)) {
            $this->loadFromApi();
        }
        
        if (!file_exists($this->file)) {
            throw new Exception('Flight is missing!');
        }
        
        $info = file_get_contents($this->file);
        $this->info = unserialize($info);
    }
    
    /**
     * Handle the entered time in timezone of the start airport
     * 
     * @param DateTime $startDateTime
     */
    public function setStartDatetime(DateTime $startDateTime)
    {
        $airport = new Airport($this->info->origin);
        $airport->loadInfo();
        $timezone = new DateTimeZone($airport->getTimezone());
        
        $startDateTime->setTimezone($timezone);
        $this->startTimestamp = $startDateTime->getTimestamp() - $startDateTime->getOffset();
    }
    
    public function getStartTimestamp()
    {
        return $this->startTimestamp;
    }
    
    private function loadFromApi()
    {
        $api = new FlightAware();
        $info = $api->getFlightInfo($this->number);
        if (!$info) {
            return;
        }
        
        $track = $api->getTrack($info);
        $info->track = $track;
        
        file_put_contents($this->file, serialize($info));
    }
    
    public function getStartAirport()
    {
        return $this->info->originName;
    }
    
    public function getDestAirport()
    {
        return $this->info->destinationName;
    }
    
    public function getTrack()
    {
        $points = $this->info->track;
        if (isset($points->data)) {
            // TODO: remove it after update
            $points = $points->data;
        }
        
        foreach ($points as &$point) {
            $point = new TrackPoint($point);
        }
        
        unset($point);
        
        return $points;
    }
    
}
