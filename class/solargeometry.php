<?php

class SolarGeometry
{

    #const URL = 'http://staging.solargeometryapi.tadatoshi.ca/solar_positions';
    const URL = 'http://solargeometry.tadatoshi.ca/solar_positions';
    #const URL = 'https://tadatoshi-solar-geometry.p.mashape.com/solar_positions';

    public function load()
    {
        $params = [
            'year' => '2016',
            'month' => '2',
            'day' => '21',
            'hour' => '10',
            'minute' => '20',
            'timezone_identifier' => 'America/Montreal',
            
            'latitude' => '53.90454',
            'longitude' => '27.56152',
            'meridian' => '10',
            'surface_azimuth' => '0',
            'surface_inclination' => '20',
        ];
        
        $context = $this->createContext($params);
        $result = file_get_contents(self::URL, false, $context);
        var_dump($result);
    }

    private function createContext(array $params)
    {
        $data = http_build_query($params);
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded\r\n"
                    . 'Accept: application/json' . "\r\n"
                    . 'Content-Length: ' . strlen($data) . "\r\n"
                ,
                'content' => $data
            ]
        ];
        var_dump($options);
        $context = stream_context_create($options);
        
        return $context;
    }
    
}
