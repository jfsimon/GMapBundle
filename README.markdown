GMapBundle : The GMap webservices made easy for your Symfony2 applications
==========================================================================

**In progress** : This bundle is under active developpement, new features will be regularly appended.

**It works** : This bundle is under Test Driven Developpement control, so every features mentioned below will really work.

**Summary** :

-  Installation
-  Run the tests
-  How to use


Installation
============

1.  Add the sources to your Bundle directory - from the root directory of your project, paste the following command :

        git submodule add git@github.com:jfsimon/GMapBundle.git src/Bundle/
        
2.  Register the bundle in your `AppKernel` class

3.  Register the bundle config in your app config file - for example, add the following minimalist code in your `app/config/config.yml` file :
    
        gmap.config: ~

You're done !


Run the tests
=============

1.  Register the routing - for example, add the following code in your `app/config/routing.yml` file :
    
        _Tests_GMapBundle:
            resource: GMapBundle/Resources/config/routing.yml
            
2.  Run the tests with phpunit, the following tests are available :
    
        phpunit --configuration app/phpunit.xml.dist src/Bundle/GMapBundle/Tests/ServiceTests.php
        phpunit --configuration app/phpunit.xml.dist src/Bundle/GMapBundle/Tests/GeocoderTests.php
        
   
How to use
==========

This bundle offers a new service accessible from your controller. To access the service, simply use the following code :

    $gmap = $this->get('gmap');
    
The geocoder webservice
-----------------------

This service is used to get latitude / longitude point from an address and vice-versa. For more informations,
look at the [Google webservice documentation](http://code.google.com/apis/maps/documentation/geocoding/).

Simple to use, here are the 2 examples :

    // get the geocode object from an address
    $geocode = $gmap->geocode('12 rue Hippolyte Lebas 75009 Paris France');
    
    // get the geocode object from a latitude / longitude point
    $geocode = $gmap->geocode(array(48.8772535, 2.3397612));
    
As second parameter, you can provide an associative array of options :

-  bounds : The bounding box of the viewport within which to bias geocode results more prominently.
-  region : The region code, specified as a ccTLD ("top-level domain") two-character value.
-  anguage : The language in which to return results.
-  sensor (default to false) : Indicates whether or not the geocoding request comes from a device with a location sensor.
    
With this method, you get a geocode object wich comes with the following methods :

    // get the latitude
    $lat = $geocode->getLat(); // 48.8772535
    
    // get the longitude
    $lat = $geocode->getLng(); // 2.3397612
    
    // get both as an array
    $arr = $geocode->getLatLng(); // array(48.8772535, 2.3397612)
    
    // get both as string
    $str = $geocode->getLatLng(false); // '48.8772535, 2.3397612'
    
    // get the *normalized* address
    $add = $geocode->getAddress(); // 12 Rue Hippolyte Lebas, 75009 Paris, France