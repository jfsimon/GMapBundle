<?php

namespace Bundle\GMapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GMapExtension extends Extension
{

    public function configLoad($config, ContainerBuilder $container)
    {
        // load definition
        if (!$container->hasDefinition('gmap')) {
            $loader = new XmlFileLoader($container, __DIR__.'/../Resources/config');
            $loader->load('gmap.xml');
        }

        // override configuration
        foreach(array('polyline_encoder', 'geocoder', 'elevation') as $service) {
            if(isset($config[$service]) && is_array($config[$service])) {
                $container->setParameter(
                    'gmap.'.$service.'.options',
                    array_replace($container->getParameter('gmap.'.$service.'.options'), $config[$service])
                );
            }
        }
    }

    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    public function getNamespace()
    {
        return null;
    }

    public function getAlias()
    {
        return 'gmap';
    }
}
