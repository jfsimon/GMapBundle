<?php

namespace GMapBundle\Formatter;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Collection implements \Iterator
{

    protected
        $container,
        $results,
        $formatter;

    public function __construct(ContainerInterface $container, array $results, $formatter)
    {
        $this->container = $container;
        $this->results = $results;
        $this->formatter = $formatter;
    }

    public function isCollection()
    {
        return true;
    }

    public function getLength()
    {
        return count($this->results);
    }

    public function getOne($index)
    {
        return new $this->formatter($this->container, $this->results[$index]);
    }

    public function rewind()
    {
        $this->cursor = 0;
    }

    public function next()
    {
        $this->cursor ++;
    }

    public function valid()
    {
        return $this->cursor < $this->getLength();
    }

    public function current()
    {
        return $this->getOne($this->cursor);
    }

    public function key()
    {
        return $this->cursor;
    }

    protected function getService($id)
    {
        return $this->container->get('gmap.'.$id);
    }

}