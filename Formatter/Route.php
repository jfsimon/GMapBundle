<?php

namespace Bundle\GMapBundle\Formatter;

use Bundle\GMapBundle\Formatter\Formatter;
use Bundle\GMapBundle\Formatter\LegCollection;
use Bundle\GMapBundle\Formatter\StepCollection;

class Route extends Formatter implements \Iterator
{

    protected
        $legs,
        $steps;

    public function getLegs()
    {
        if(! is_object($this->legs)) {
            $legs = array();

            foreach($this->result['legs'] as $leg) {
                $legs[] = $leg;
            }

            $this->legs = new LegCollection($this->container, $legs);
        }

        return $this->legs;
    }

    public function getSteps()
    {
        if(! is_object($this->steps)) {
            $steps = array();

            foreach($this->result['legs'] as $leg) {
                foreach($leg['steps'] as $step) {
                    $steps[] = $step;
                }
            }

            $this->steps = new StepCollection($this->container, $steps);
        }

        return $this->steps;
    }

    public function getDistance()
    {
        return $this->getSteps()->getDistance();
    }

    public function getDuration()
    {
        return $this->getSteps()->getDuration();
    }

    public function getInstructions()
    {
        return $this->getSteps()->getInstructions();
    }

    public function getPolyline($array = false)
    {
        return $this->getSteps()->getPolyline($array);
    }

    public function getCheckpoints($string = false)
    {
        return $this->getSteps()->getCheckpoints($string);
    }

    public function getSummary()
    {
        return $this->result['summary'];
    }

    public function getWarnings()
    {
        return $this->result['warnings'];
    }

    protected function uncache()
    {
        $this->legs = null;
        $this->steps = null;
    }

}