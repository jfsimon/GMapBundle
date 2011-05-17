<?php

namespace GMapBundle\Webservice;

class Request
{

    protected
        $baseUrl,
        $responseFormat,
        $parameters;

    public function __construct($baseUrl, $responseFormat = 'json')
    {
        $this->baseUrl = $baseUrl;
        $this->responseFormat = $responseFormat;
        $this->prameters = array();
    }

    public function getParameter($key)
    {
        if(isset($this->parameters[$key])) {
            return $this->parameters[$key];
        }
        return null;
    }

    public function setParameter($key, $value)
    {
        if(is_bool($value)) {
            $value = $value ? 'true' : 'false';
        } else {
            $value = (string)$value;
        }

        $this->parameters[$key] = $value;
    }

    public function removeParameter($key)
    {
        unset($this->parameters[$key]);
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function addParameters(array $parameters)
    {
        foreach($parameters as $key => $value) {
            $this->setParameter($key, $value);
        }
    }

    public function setParameters(array $parameters)
    {
        $this->removeParameters();
        $this->addParameters($parameters);
    }

    public function removeParameters()
    {
        $this->parameters = array();
    }

    public function getUrl()
    {
        return $this->baseUrl.'/'.$this->responseFormat.'?'.$this->getQueryString();
    }

    public function getQueryString()
    {
        $parameters = array();
        foreach($this->parameters as $key => $value) {
            $parameters[] = $key.'='.$value;
        }
        return implode('&', $parameters);
    }

    public function send()
    {
        return file_get_contents($this->getUrl());
    }

}