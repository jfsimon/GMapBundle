<?php

namespace Bundle\GMapBundle\Encoder;

// based on http://www.scribd.com/doc/3599978/PolylineEncoder-class-php

class PolylineEncoder
{

    protected
        $options,
        $quantum,
        $factor,
        $zoomLevelBreaks;

    public function __construct(array $options)
    {
        $this->options = $options;
        $this->factor = pow(10, $this->options['accuracy']);
        $this->quantum = 1 / $this->factor;
        $this->zoomLevelBreaks = array();

        for($i = 0; $i < $this->options['levels']; $i ++) {
            $this->zoomLevelBreaks[$i] = $this->quantum * pow($this->options['zoom'], $this->options['levels'] - $i - 1);
        }
    }

    public function encode(array $points)
    {
        $absMaxDist = 0;
        $stack = array();
        $dists = array();

        if(count($points) > 2) {
            $stack[] = array(0, count($points) - 1);

            while(count($stack) > 0) {
                $current = array_pop($stack);
                $maxDist = 0;
                $segmentLength = pow($points[$current[1]][0] - $points[$current[0]][0], 2) + pow($points[$current[1]][1] - $points[$current[0]][1], 2);

                for($i = $current[0]+1; $i < $current[1]; $i++) {
                    $temp = $this->computeDistance($points[$i], $points[$current[0]], $points[$current[1]], $segmentLength);

                    if($temp > $maxDist) {
                        $maxDist = $temp;
                        $maxLoc = $i;
                        if($maxDist > $absMaxDist) {
                            $absMaxDist = $maxDist;
                        }
                    }
                }

                if($maxDist > $this->quantum) {
                    $dists[$maxLoc] = $maxDist;
                    $stack[] = array($current[0], $maxLoc);
                    $stack[] = array($maxLoc, $current[1]);
                }
            }
        }

        $encodedPoints = $this->encodePoints($points, $dists);
        $encodedLevels = $this->encodeLevels($points, $dists, $absMaxDist);

        return array (
            'points' => str_replace('\\', '\\\\', $this->encodePoints($points, $dists)),
            'levels' => str_replace('\\', '\\\\', $this->encodeLevels($points, $dists, $absMaxDist)),
        );
    }

    protected function encodePoints ($points, $dists) {
        $encoding = '';
        $plat = 0;
        $plng = 0;

        for($i = 0; $i < count($points); $i ++) {
            if (isset($dists[$i]) || $i == 0 || $i == count($points)-1) {

                $lat = $points[$i][0];
                $lng = $points[$i][1];

                $late5 = floor($lat * $this->factor);
                $lnge5 = floor($lng * $this->factor);

                $dlat = $late5 - $plat;
                $dlng = $lnge5 - $plng;

                $plat = $late5;
                $plng = $lnge5;

                $encoding .= $this->encodeSignedNumber($dlat) . $this->encodeSignedNumber($dlng);
            }
        }
        return $encoding;
    }

    protected function encodeLevels($points, $dists, $absMaxDist) {
        $encoding = '';

        if($this->options['endpoints']) {
            $encoding .= $this->encodeUnsignedNumber($this->options['levels'] - 1);
        } else {
            $encoding .= $this->encodeUnsignedNumber($this->options['levels'] - $this->computeLevel($absMaxDist) - 1);
        }

        for ($i=1; $i < count($points) - 1; $i++) {
            if(isset($dists[$i])) {
                $encoding .= $this->encodeUnsignedNumber($this->options['levels'] - $this->computeLevel($dists[$i]) - 1);
            }
        }

        if ($this->options['endpoints']) {
            $encoding .= $this->encodeUnsignedNumber($this->options['levels'] - 1);
        } else {
            $encoding .= $this->encodeUnsignedNumber($this->options['levels'] - $this->computeLevel($absMaxDist) - 1);
        }

        return $encoding;
    }

    protected function encodeUnsignedNumber($number)
    {
        $encoding = '';

        while ($number >= 0x20) {
            $next = (0x20 | ($number & 0x1f)) + 63;
            $encoding .= chr($next);
            $number >>= 5;
        }
        $encoding .= chr($number + 63);

        return $encoding;
    }

    protected function encodeSignedNumber($number)
    {
        $unsigned = $number << 1;

        if ($number < 0) {
            $unsigned = ~ $unsigned;
        }

        return $this->encodeUnsignedNumber($unsigned);
    }

    protected function computeLevel($distance) {
        $level = 0;

        if ($distance > $this->quantum) {
            while($distance < $this->zoomLevelBreaks[$level]) {
                $level++;
            }
        }

        return $level;
    }

    protected function computeDistance($p0, $p1, $p2, $segLength)
    {
        $distance = null;

        if($p1[0] === $p2[0] && $p1[1] === $p2[1]) {
            $distance = sqrt(pow($p2[0] - $p0[0], 2) + pow($p2[1] - $p0[1], 2));

        } else {

            $u = (($p0[0] - $p1[0]) * ($p2[0] - $p1[0]) + ($p0[1] - $p1[1]) * ($p2[1] - $p1[1])) / $segLength;

            if($u <= 0) {
                $distance = sqrt(pow($p0[0] - $p1[0],2) + pow($p0[1] - $p1[1], 2));
            } elseif ($u >= 1) {
                $distance = sqrt(pow($p0[0] - $p2[0],2) + pow($p0[1] - $p2[1], 2));
            } else {
                $distance = sqrt(pow($p0[0] - $p1[0] - $u * ($p2[0] - $p1[0]), 2) + pow($p0[1] - $p1[1] - $u * ($p2[1] - $p1[1]), 2));
            }
        }

        return $distance;
    }

}