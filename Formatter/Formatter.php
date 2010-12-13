<?php

namespace Bundle\GMapBundle\Formatter;

use Bundle\GMapBundle\Encoder\Polyline;

abstract class Formatter
{

    protected $data, $status;

    public function __construct(array $data)
    {
        $this->status = $data['status'];

        if($this->isOk()) {
            $this->data = $data['results'][0];
        }
    }

    public function getStatus()
    {
        return $this->status();
    }

    public function isOk()
    {
        return $this->status === 'OK';
    }

    protected function encodePolyline(array $points, array $options = array())
    {
        $encoder = new Polyline($options);
        return $encoder->encode($points);
    }

}