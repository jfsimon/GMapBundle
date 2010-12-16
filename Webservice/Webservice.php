<?php

namespace Bundle\GMapBundle\Webservice;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Webservice
{

    protected
        $container,
        $options;

    public function __construct(ContainerInterface $container, array $options)
    {
        $this->container = $container;
        $this->options = $options;
    }

    protected function get($service)
    {
        return $this->container->get('gmap.'.$service);
    }

    protected function getData($parameters)
    {
        $response = $this->callWebservice(
            $this->options['url'].'/'.$this->options['format'],
            array_merge($this->getDefaultParameters(), $parameters)
        );

        return $this->parseResponse($response, $this->options['format']);
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

    abstract protected function getDefaultParameters();

    protected function encodePolyline(array $polyline)
    {
        $encoded = $this->get('polyline_encoder')->encode($polyline);
        return 'enc:'.$encoded['points'];
    }

}