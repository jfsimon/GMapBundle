<?php

namespace Bundle\GMapBundle\Formatter;

use Bundle\GMapBundle\Formatter\Formatter;
use Bundle\GMapBundle\Formatter\LegCollection;
use Bundle\GMapBundle\Formatter\StepCollection;
use Bundle\GMapBundle\Tool\Distance;
use Bundle\GMapBundle\Tool\Duration;

class Leg extends Formatter implements \Iterator
{

    protected
        $steps;

    public function getSteps()
    {
        if(! is_object($this->steps)) {
            $steps = array();

            foreach($this->result['steps'] as $step) {
                $steps[] = $step;
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

    protected function uncache()
    {
        $this->steps = null;
    }

}