<?php

namespace Bundle\GMapBundle\Formatter;

use Bundle\GMapBundle\Formatter\Collection;
use Bundle\GMapBundle\Exception\ZeroResultsException;

class LegCollection extends Collection implements \Iterator
{

    protected $steps;

    public function getSteps()
    {
        if(! is_object($this->steps)) {
            foreach($this as $index => $leg) {
                if($index === 0) {
                    $this->steps = $leg->getSteps();
                } else {
                    $this->steps->addCollection($leg->getSteps());
                }
            }
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

    public function getPolyline($encoded = false)
    {
        return $this->getSteps()->getCheckpoints($encoded);
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