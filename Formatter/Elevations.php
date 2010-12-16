<?php

namespace Bundle\GMapBundle\Formatter;

use Bundle\GMapBundle\Formatter\Formatter;

class Elevations extends Formatter implements \Iterator
{

    protected $cursor;

    public function getLength()
    {
        return count($this->data);
    }

    public function getPoint($resultOrIndex)
    {
        if(is_int($resultOrIndex)) {
            $resultOrIndex = $this->data[$resultOrIndex];
        }

        return array(
            'lat' => $resultOrIndex['location']['lat'],
            'lng' => $resultOrIndex['location']['lng'],
            'location' => array($resultOrIndex['location']['lat'], $resultOrIndex['location']['lng']),
            'elevation' => $resultOrIndex['elevation'],
        );
    }

    public function getAll()
    {
        $result = array();

        foreach($this->data as $point) {
            $result[] = $this->getPoint($point);
        }

        return $result;
    }

    public function rewind()
    {
        $this->cursor = 0;
    }

    public function current()
    {
        return $this->getPoint($this->cursor);
    }

    public function key()
    {
        return $this->cursor;
    }

    public function valid()
    {
        return isset($this->data[$this->cursor]);
    }

    public function next()
    {
        $this->cursor ++;
    }

}