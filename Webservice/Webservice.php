<?php

namespace Bundle\GMapBundle\Webservice;

abstract class Webservice
{

    protected function getData($url, array $parameters, $format)
    {
        $response = $this->callWebservice($url, $parameters);
        return $this->parseResponse($response, $format);
    }

    protected function callWebservice($url, array $parameters)
    {
        if(count($parameters) > 0) {
            $query = array();

            foreach($parameters as $key => $value) {
                if($value) {
                    $query[] = $key.'='.urlencode($value);
                }
            }

            $url .= '?'.implode('&', $query);
        }

        return file_get_contents($url);
    }

    protected function parseResponse($response, $format)
    {
        switch($format) {
            case 'xml':
                throw new \Exception('Not implemented');
            case 'json':
                return json_decode($response, true);
            default:
                throw new \Exception('Unkwown format : '.$format);
        }
    }

}