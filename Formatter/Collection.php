<?php

namespace Bundle\GMapBundle\Formatter;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Bundle\GMapBundle\Exception\ZeroResultsException;

class Collection implements \Iterator
{

    protected
        $formatters,
        $container,
        $results,
        $formatter;

    public function __construct(ContainerInterface $container, array $results, $formatter)
    {
        $this->container = $container;
        $this->results = $results;
        $this->formatter = $formatter;
        $this->uncache();
    }

    public function isCollection()
    {
        return true;
    }

    public function getLength()
    {
        if(! is_int($this->length)) {
            $this->length = count($this->results);
        }

        return $this->length;
    }

    public function getOne($index = 0)
    {
        if(! isset($this->formatters[$index])) {
            $this->formatters[$index] = new $this->formatter($this->container, $this->results[$index]);
        }

        return $this->formatters[$index];
    }

    public function getResults()
    {
        return $this->results;
    }

    public function addCollection(Collection $collection)
    {
        if(! get_class($collection) === get_class($this)) {
            throw new \Exception('The added collection must be the sameclass as the original collection');
        }

        $this->uncache();
        return new self($this->container, array_merge($this->results, $collection->getResults(), $this->formatter));
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

    protected function setResults(array $results)
    {
        $this->results = $results;

        if(count($this->results) == 0) {
            throw new ZeroResultsException();

        } elseif(count($this->results) == 1) {
            return $this->getOne(0);
        }

        return $this;
    }

    protected function uncache()
    {
        $this->formatters = array();
        $this->length = null;
    }

}