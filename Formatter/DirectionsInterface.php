<?php

namespace Bundle\GMapBundle\Formatter\Directions;

interface DirectionsInterface
{

    public function getDistance();
    public function getDuration();
    public function getInstructions();
    public function getPolyline($encoded = false);
    public function getCheckpoints($string = false);

}