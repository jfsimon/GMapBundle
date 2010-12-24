<?php

namespace Bundle\GMapBundle\Formatter;

use Bundle\GMapBundle\Formatter\Collection;
use Bundle\GMapBundle\Exception\ZeroResultsException;

class RouteCollection extends Collection implements \Iterator
{

    protected
        $legs,
        $steps,
        $summary,
        $warnings;

    public function getLegs()
    {
        if(! is_object($this->legs)) {
            foreach($this as $index => $oute) {
                if($index === 0) {
                    $this->legs = $oute->getLegs();
                } else {
                    $this->legs->addCollection($oute->getLegs());
                }
            }
        }

        return $this->legs;
    }

    public function getSteps()
    {
        if(! is_object($this->steps)) {
            foreach($this->getLegs() as $index => $leg) {
                if($index === 0) {
                    $this->steps = $leg->getSteps();
                } else {
                    $this->steps->addCollection($leg->getSteps());
                }
            }
        }

        return $this->steps();
    }

    public function getSummary()
    {
        if(! is_array($this->summary)) {
            foreach($this as $route) {
                $sthis->summary[] = $route->getSummary();
            }
        }

        return $this->summary;
    }

    public function getWarnings()
    {
        if(! is_array($this->warnings)) {
            foreach($this as $route) {
                $sthis->warnings[] = $route->getWarnings();
            }
        }

        return $this->warnings;
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
        $this->legs = null;
        $this->steps = null;
        $this->summary = null;
        $this->warnings = null;
    }

}