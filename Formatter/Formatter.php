<?php

namespace Bundle\GMapBundle\Formatter;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Formatter implements \Iterator
{

    protected
        $container,
        $result,
        $valid;

    public function __construct(ContainerInterface $container, array $result)
    {
        $this->container = $container;
        $this->result = $result;
    }

    public function isCollection()
    {
        return false;
    }

    public function rewind()
    {
        $this->valid = true;
    }

    public function next()
    {
        $this->valid = false;
    }

    public function valid()
    {
        return $this->valid;
    }

    public function current()
    {
        return $this;
    }

    public function key()
    {
        return 0;
    }

    protected function getService($id)
    {
        return $this->container->get('gmap.'.$id);
    }

}