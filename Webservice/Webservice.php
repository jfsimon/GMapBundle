<?php

namespace GMapBundle\Webservice;

use Symfony\Component\DependencyInjection\ContainerInterface;
use GMapBundle\Webservice\Request;
use GMapBundle\Webservice\Response;
use GMapBundle\Webservice\Exception;
use GMapBundle\Exception\InvalidRequestException;
use GMapBundle\Exception\OverQueryLimitException;
use GMapBundle\Exception\RequestDeniedException;
use GMapBundle\Exception\ZeroResultsException;

abstract class Webservice
{

    protected
        $container,
        $baseUrl,
        $responseFormat,
        $formatterClass,
        $collectionClass,
        $defaultParameters,
        $request;

    public function __construct(ContainerInterface $container, array $options)
    {
        $this->container = $container;

        $this->baseUrl = $options['url'];
        $this->responseFormat = $options['format'];
        $this->formatterClass = $options['formatter'];
        $this->collectionClass = $options['collection'];

        unset($options['url'], $options['format'], $options['formatter'], $options['collection']);

        $this->defaultParameters = $options;
        $this->request = new Request($this->baseUrl, $this->responseFormat);
    }

    protected function call(array $parameters)
    {
        $this->request->setParameters(array_merge($this->defaultParameters, $parameters));
        $response = new Response($this->request->send(), $this->responseFormat);

        if(! $response->isOk()) {
            switch($response->getStatus()) {
                case Response::INVALID_REQUEST: throw new InvalidRequestException();
                case Response::OVER_QUERY_LIMIT: throw new OverQueryLimitException();
                case Response::REQUEST_DENIED: throw new RequestDeniedException();
                case Response::ZERO_RESULTS: throw new ZeroResultsException();
            }
        }

        if($response->isCollection()) {
            return new $this->collectionClass($this->container, $response->getResult(), $this->formatterClass);
        }
        return new $this->formatterClass($this->container, $response->getResult(0));
    }

    protected function getService($id)
    {
        return $this->container->get('gmap.'.$id);
    }

    protected function encodePolyline(array $polyline)
    {
        // TODO: get a better way to do this !
        $encoding = $this->getService('polyline_encoder')->encode($polyline);
        return 'enc:'.$encoding['points'];
    }

}