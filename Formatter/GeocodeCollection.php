<?php

namespace Bundle\GMapBundle\Formatter;

use Bundle\GMapBundle\Formatter\Collection;

class GeocodeCollection extends Collection implements \Iterator
{

    public function filterType($types)
    {
        if(! is_array($types)) {
            $types = array($types);
        }

        $results = array();
        foreach($this->results as $result) {
            foreach($result['types'] as $type) {
                if(in_array($type, $types)) {
                    $results[] = $result;
                    break;
                }
            }
        }

        $this->results = $results;
        return $this;
    }

}