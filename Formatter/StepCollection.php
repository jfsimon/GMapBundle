<?php

namespace Bundle\GMapBundle\Formatter;

use Bundle\GMapBundle\Formatter\Collection;
use Bundle\GMapBundle\Exception\ZeroResultsException;

class StepCollection extends Collection implements \Iterator
{

    protected
        $distance,
        $duration,
        $instructions,
        $polyline,
        $checkpoints;

    public function getDistance()
    {
        if(! is_int($this->distance)) {
            $this->distance = 0;

            foreach($this as $step) {
                $this->distance += $step->getDistance();
            }
        }

        return $this->distance;
    }

    public function getDuration()
    {
        if(! is_int($this->duration)) {
            $this->duration = 0;

            foreach($this as $step) {
                $this->duration += $step->getDuration();
            }
        }

        return $this->duration;
    }

    public function getInstructions()
    {
        if(! is_array($this->duration)) {
            $this->instructions = array();

            foreach($this as $step) {
                $this->instructions[] = $step->getInstructions();
            }
        }

        return $this->instructions;
    }

    public function getPolyline($array = false)
    {
        if(! is_array($this->polyline)) {
            $this->polyline = array();


            foreach($this as $step) {
                $this->polyline = array_merge($this->polyline, $step->getPolyline(true));
            }
        }

        $encoder = $this->getService('polyline_encoder');
        return $array ? $this->polyline : $encoder->encode($this->polyline);
    }

    public function getCheckpoints($string = false)
    {
        if(! is_array($this->checkpoints)) {
            $this->checkpoints = array();
            $last = $this->getLength() - 1;

            foreach($this as $index => $step) {
                $this->checkpoints[] = $step->getStart($string);

                if($index == $last) {
                    $this->checkpoints[] = $step->getEnd($string);
                }
            }
        }

        return $this->checkpoints;
    }

    protected function uncache()
    {
        $this->distance = null;
        $this->duration = null;
        $this->instructions = null;
        $this->polyline = null;
        $this->checkpoints = null;
    }

}