<?php

namespace Bundle\GMapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GMapExtension extends Extension
{

    public function configLoad($config, ContainerBuilder $container)
    {
        if (!$container->hasDefinition('gmap')) {
            $loader = new XmlFileLoader($container, __DIR__.'/../Resources/config');
            $loader->load('gmap.xml');
        }


        if(isset($config['geocoder'])) {
            $container->setParameter('gmap.geocoder.options', array_replace($container->getParameter('gmap.geocoder.options'), $config['geocoder']));
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
