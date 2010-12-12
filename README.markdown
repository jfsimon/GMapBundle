GMapBundle : The GMap webservices made easy for your Symfony2 applications
==========================================================================

**In progress** : This bundle is under active developpement, new features will be regularly appended.

**It works** : This bundle is under Test Driven Developpement control, so every features mentioned below will really work.

** Summary ** :
-  Installation
-  Run the tests
-  How to use


Installation
============

1.  Add the sources to your Bundle directory
    
    From the root directory of your project, paste the following command :

        git submodule add git@github.com:jfsimon/GMapBundle.git src/Bundle/
        
2.  Register the bundle in your `AppKernel` class

3.  Register the bundle config in your app config file

    For example, add the following minimalist code in your `app/config/config.yml` file :
    
        gmap.config: ~

You're done !


Run the tests
=============

1.  Register the routing in your

    For example, add the following code in your `app/config/routing.yml` file :
    
        _tests_gmapbundle:
            resource: GMapBundle/Resources/config/routing.yml
            
2.  Run the tests with phpunit

    The following tests are available :
    
        phpunit --configuration app/phpunit.xml.dist src/Bundle/GMapBundle/Tests/ServiceTests.php
        phpunit --configuration app/phpunit.xml.dist src/Bundle/GMapBundle/Tests/GeocoderTests.php
        
   
How to use
==========

*To be continued ...*
