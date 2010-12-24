<?php

namespace Bundle\GMapBundle\Formatter;

use Bundle\GMapBundle\Formatter\Formatter;
use Bundle\GMapBundle\Formatter\LegCollection;
use Bundle\GMapBundle\Formatter\StepCollection;
use Bundle\GMapBundle\Tool\Distance;
use Bundle\GMapBundle\Tool\Duration;

class Step extends Formatter implements \Iterator
{

    public function getDistance($string = false)
    {
        return $this->result['distance'][$string ? 'text' : 'value'];
    }

    public function getDuration($string = false)
    {
        return $this->result['duration'][$string ? 'text' : 'value'];
    }

    public function getStart($string = false)
    {
        $latLng = array($this->result['start_location']['lat'], $this->result['start_location']['lng']);
        return $string ? implode(',', $latLng) : $latLng;
    }

    public function getEnd($string = false)
    {
        $latLng = array($this->result['end_location']['lat'], $this->result['end_location']['lng']);
        return $string ? implode(',', $latLng) : $latLng;
    }

    public function getPolyline($array = false)
    {
        $polyline = $this->result['polyline'];
        return $array ? $this->getService('polyline')->decode($polyline) : $polyline;
    }

    public function getInstructions()
    {
        return $this->result['html_instructions'];
    }

    public function getCheckpoints($string = false)
    {
        return array($this->getStart($string), $this->getEnd($string));
    }

}