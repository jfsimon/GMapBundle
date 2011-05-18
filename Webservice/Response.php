<?php

namespace GMapBundle\Webservice;

class Response
{

    const OK = 'OK';
    const ZERO_RESULTS = 'ZERO_RESULTS';
    const OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
    const REQUEST_DENIED = 'REQUEST_DENIED';
    const INVALID_REQUEST = 'INVALID_REQUEST';

    protected
        $status,
        $result,
        $length;

    public function __construct($content, $format='json')
    {
        $parse = 'parse'.ucfirst($format);
        $this->setup($this->$parse($content));
    }

    public function isOk()
    {
        return $this->status === self::OK;
    }

    public function isCollection()
    {
        return $this->isOk() && $this->length > 1;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getResult($index = null)
    {
        return is_null($index) ? $this->result : $this->result[$index];
    }

    protected function parseJson($content)
    {
        return json_decode($content, true);
    }

    protected function setup(array $data)
    {
        $this->status = $data['status'];

        if($this->isOk()) {
            $this->result = $data['results'];
            $this->length = count($data['results']);
        }
    }

}