<?php

namespace Bundle\GmapBundle\Formatter;

interface LocationInterface
{
    public function getLat();
    public function getLng();
    public function getLatLng($array = false);
    public function __toString();
}