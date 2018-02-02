<?php

class Airport
{
    private $code;
    private $file = '';
    private $info;
    
    /**
     * @param string $code ICAO airport code
     */
    public function __construct($code)
    {
        $this->code = $code;
        
        $this->file = DATA_DIR . 'airports.dat';
    }
    
    public function getTimezone()
    {
        return $this->info['timezone'];
    }
    
    public function loadInfo()
    {
        if (!file_exists($this->file)) {
            $this->generateList();
        }
        
        if (!file_exists($this->file)) {
            throw new Exception('Missing airports');
        }
        
        $list = file_get_contents($this->file);
        $list = unserialize($list);
        if (empty($list[$this->code])) {
            throw new Exception('Missing airport info');
        }
        
        $this->info = $list[$this->code];
    }
    
    private function generateList()
    {
        $list = [];
        $file = fopen(DATA_DIR . 'airports.cvs', 'r');
        while (!feof($file)) {
            $line = fgetcsv($file);
            $code = $line[5];
            if (!self::validateCode($code)) {
                continue;
            }

            $list[$code] = [
                'icao' => $code,
                'iata' => $line[4],
                'name' => $line[1],
                'timezone' => $line[11],
            ]; 
        }
        
        file_put_contents($this->file, serialize($list));
    }
    
    public static function validateCode($value)
    {
        if (empty($value)) {
            return false;
        }

        if (!preg_match('#[A-Z0-9]{3}#i', $value)) {
            return false;
        }

        return true;
    }
    
}
