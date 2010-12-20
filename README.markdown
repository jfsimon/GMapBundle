GMapBundle : The GMap webservices made easy for your Symfony2 applications
--------------------------------------------------------------------------

**In progress** : This bundle is under active developpement, new features will be regularly appended.

**It works** : This bundle is under Test Driven Developpement control, so every features mentioned below will really work.

**Current implementation** : Just include (for now) the following services :

-  The geocoder webservice
-  The elevation webservice
-  The polyline encocing

**Current branch** : Full refactoring with a better approach.


The basics
==========

Before to use the bundle, you have to install it, and optionaly test it (dont forget to post issues on github !).


Intall the bundle
-----------------

1.  Add the sources to your Bundle directory - from the root directory of your project, paste the following command :

        git submodule add git@github.com:jfsimon/GMapBundle.git src/Bundle/
        
2.  Register the bundle in your `AppKernel` class

3.  Register the bundle config in your app config file - for example, add the following minimalist code in your `app/config/config.yml` file :
    
        gmap.config: ~

You're done !


Run the tests
-------------

1.  Register the routing - for example, add the following code in your `app/config/routing.yml` file :
    
        _Tests_GMapBundle:
            resource: GMapBundle/Resources/config/routing.yml
            
2.  Run the tests with phpunit, the following tests are available :
    
        phpunit --configuration app/phpunit.xml.dist src/Bundle/GMapBundle/Tests/ServiceTests.php
        phpunit --configuration app/phpunit.xml.dist src/Bundle/GMapBundle/Tests/PolylineEncoderTests.php
        phpunit --configuration app/phpunit.xml.dist src/Bundle/GMapBundle/Tests/GeocoderTests.php
        phpunit --configuration app/phpunit.xml.dist src/Bundle/GMapBundle/Tests/ElevationTests.php
        
   
How to use
----------

This bundle offers a new service accessible from your controller. To access the service, simply use the following code :

    $gmap = $this->get('gmap');
    
These services are subject to a query limit of 2,500 geolocation requests per day (for each service, is suppose).


The webservices
===============


Configuration
-------------

**Will be written tomorrow**


The response
------------

-  If a request is denied or malformed, it raises an Exception
-  If a request returns no result it raises an Exception
-  If a request returns one result, you get a `Formatter` object
-  If a request returns more tha one result, you get a `Collection` object
-  `Collection` objects are Iterable and, for convenience, `Formatter` objects are Iterable too.
-  Iterate over a `Collection` object give you `Formatter` objects.
-  Each webservice returns his own `Formatter` and `Collection` objects with convenient methods.


**To be continued**