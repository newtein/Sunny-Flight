<?php

class FlightAware
{
    private $client;
    
    public function __construct()
    {
        $options = [
            'trace'      => true,
            'exceptions' => 0,
            'login'      => FA_API_LOGIN,
            'password'   => FA_API_KEY,
        ];
        $this->client = new SoapClient('http://flightxml.flightaware.com/soap/FlightXML2/wsdl', $options);
    }
    
    public function getTrack($info)
    {
        $flightId = $info->faFlightID;
        
        $params = [
            'faFlightID' => $flightId,
        ];
        $result = $this->client->GetHistoricalTrack($params);
        if ($result instanceof SoapFault) {
            throw new Exception('SOAP: ' . $result->getMessage());
        }
        
        $track = $result->GetHistoricalTrackResult->data;
        if (empty($track)) {
            print_r($params);
            print_r($result);
            throw new Exception('SOAP: missing track');
        }
        
        return $track;
    }
    
    public function getFlightInfo($flight)
    {
        $params = [
            'ident' => $flight,
            'howMany' => 1,
            'offset' => 3,
        ];
        $result = $this->client->FlightInfoEx($params);
        if ($result instanceof SoapFault) {
            throw new Exception('SOAP: ' . $result->getMessage());
        }
        
        // TODO: check for estimatedarrivaltime < now
        
        $info = $result->FlightInfoExResult->flights;
        $flightId = $info->faFlightID;
        if (empty($flightId)) {
            print_r($result);
            throw new Exception('SOAP: missing flight id');
        }
        
        return $info;
    }
            
}
