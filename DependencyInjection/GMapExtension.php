<?php

namespace Bundle\GMapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class GMapExtension implements ExtensionInterface
{

    public function load(array $config, ContainerBuilder $container)
    {
        // load definition
        if (!$container->hasDefinition('g_map')) {
            $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
            $loader->load('gmap.xml');
        }

        // override configuration
        foreach(array('polyline_encoder', 'geocoder', 'elevation') as $service) {
            if(isset($config[$service]) && is_array($config[$service])) {
                $container->setParameter(
                    'g_map.'.$service.'.options',
                    array_replace($container->getParameter('g_map.'.$service.'.options'), $config[$service])
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
        return 'g_map';
    }
}
