GMapBundle : The GMap webservices made easy for your Symfony2 applications
--------------------------------------------------------------------------

**In progress** : This bundle is under active developement, new features will be regularly appended.

**It works** : This bundle is under Test Driven Developement control, so every features mentioned below will really work.

**Current implementation** : Just include (for now) the following services :

-  *2 webservices* :
   -  The geocoder webservice
   -  The elevation webservice
-  *1 tool service* :
   -  The polyline encoder

**Current branch** : Full refactoring with a better approach.


The basics
==========

In order to use this bundle you have to install it, and then optionally test it ([dont forget to post issues on github!](https://github.com/jfsimon/GMapBundle/issues)).


Intall the bundle
-----------------

1.  Add the sources to your bundles directory - from the root directory of your project, paste the following command :

        git submodule add git@github.com:alephnullplex/GMapBundle.git vendor/bundles/GMapBundle

        
2.  Register the bundle in your with the auto loader and AppKernel:

        // app/autoload.php in registerNamespaces()
        'GMapBundle'       => __DIR__.'/../vendor/bundles',

        // app/AppKernel.php in registerBundles()
        new GMapBundle\GMapBundle(),

3.  Register the bundle config in your app config file - for example, add the following minimalist code in your `app/config/config.yml` file :
    
        gmap:
          config: ~

You're done !


Run the tests
-------------

1.  Register the routing. Add the following code in your `app/config/routing_dev.yml` file - this will
register the routes in your dev region only :
    
        _Tests_GMapBundle:
            resource: "@GMapBundle/Resources/config/routing.yml"
            
2.  Run the tests with phpunit, the following tests are available :
    
        phpunit --c app/ vendor/bundles/GMapBundle/Tests/ServiceTests.php
        phpunit --c app/ vendor/bundles/GMapBundle/Tests/PolylineEncoderTests.php
        phpunit --c app/ vendor/bundles/GMapBundle/Tests/GeocoderTests.php
        phpunit --c app/ vendor/bundles/GMapBundle/Tests/ElevationTests.php
        
   
How to use
----------

This bundle offers a new service accessible from your controller. To access the service, simply use the following code :

    $gmap = $this->get('gmap');
    
These services are subject to a query limit of 2,500 geolocation requests per day (for each service, I suppose).


The webservices
===============


Configuration
-------------

Each webservice takes these 4 common parameters (cant be overrided by request) :

    url : ~ // the webservice URL
    format : 'json' // the internal response format, for now only 'json' is implemented
    formatter : ~ // the result formatter class for one result
    collection : ~ // the collection result fomatter class
    
Each webservice also comes with his own set of parameters wich can be setted :
-  in the config (the defaults values) ;
-  for each request (as an associative array).


The response
------------

-  If a request is denied, malformed or over the limit (2500 requests per day), it raises an appropriate exception
-  If a request returns no result it raises a ZeroResultsException
-  If a request returns one result, you get a `Formatter` object
-  If a request returns more tha one result, you get a `Collection` object
-  `Collection` objects are Iterable and, for convenience, `Formatter` objects are Iterable too.
-  Iterate over a `Collection` object give you `Formatter` objects.
-  Each webservice returns his own `Formatter` and `Collection` objects with appropriate methods.


The geocoder webservice
-----------------------

This service is used to get latitude / longitude point from an address and vice-versa.
It can also be used to normalize and parse addresses. For more informations, look at the
[Google webservice documentation](http://code.google.com/apis/maps/documentation/geocoding/#GeocodingRequests).


###Get the formatter

Simple to use, here are the examples :

    // get the geocode object from an address (wich is really dirty)
    $home = $gmap->geocode('12 rU hipOLYte lBAs 75009 fR');
    
    // get the geocode object from a latitude / longitude array
    $home = $gmap->geocode(array(48.8772535, 2.3397612));
    
    // get the geocode object from a latitude / longitude string
    $home = $gmap->geocode('48.8772535, 2.3397612');
    
As second parameter, you can provide an associative array of options :

-  bounds : The bounding box of the viewport within which to bias geocode results more prominently.
-  region : The region code, specified as a ccTLD ("top-level domain") two-character value.
-  language : The language in which to return results.
-  sensor (default to false) : Indicates whether or not the geocoding request comes from a device with a location sensor.

More explanations of these options in
[Google's documentation](http://code.google.com/apis/maps/documentation/geocoding/#Types).

Many requests get you a collection, you can filter the address by type :

    // get the 'street_address' type (the more precise)
    // just one address of this type, you get a `Formatter` object
    $home = $home->filter('street_address');

The geocode method returns a Geocode object wich comes with several methods to get the data you want.


###See what you can do with geocoder

*Get the position of an address*

    $home = $this->get('gmap')->geocode('12 Rue Hippolyte Lebas 75009 France')->filter('street_address');
    
    // get the latitude
    $lat = $home->getLat(); // 48.8772535
    
    // get the longitude
    $lng = $home->getLng(); // 2.3397612
    
    // get both as string
    $str = $home->getLatLng(); // '48.8772535, 2.3397612'
    
    // get both as an array
    $arr = $home->getLatLng(true); // array(48.8772535, 2.3397612)

*Get an address from a position*

    $home = $this->get('gmap')->geocode('48.8772535, 2.3397612')->filter('street_address');
    
    // get the *normalized* address as string
    $str = $home->getAddress(); // 12 Rue Hippolyte Lebas, 75009 Paris, France

*Normalize an address*

    // a dirty address is inputed by a user
    $home = $this->get('gmap')->geocode('12 rU hipOLYte lBAs 75009 fR')->filter('street_address');
    
    // get the *normalized* address
    $str = $home->getAddress(); // 12 Rue Hippolyte Lebas, 75009 Paris, France

*Address components*

    $home = $this->get('gmap')->geocode('12 Rue Hippolyte Lebas 75009 France')->filter('street_address');
    
    // get the number
    $str = $home->getAddressComponent('street_number'); // '12'
    
    // get the city
    $str = $home->getAddressComponent('locality'); // 'Paris'
    
    // get the region (for France)
    $str = $home->getAddressComponent('administrative_area_level_1'); // 'Ile-de-France'
    
    // get the zip code
    $str = $home->getAddressComponent('postal_code'); // '75009'
    
    // get a sublocality
    $str = $home->getAddressComponent('sublocality'); // '9ème Arrondissement Paris'

And so on ... full list of components available in
[Google's documentation](http://code.google.com/apis/maps/documentation/geocoding/#Types).
If a component has several values, it returns an array.

In addition, getAddressComponent method take a 2nd boolean argument, wich setted to true get you the short name.
For example :

    // get the country short name
    $str = $home->getAddressComponent('country', true); // 'FR'
    
    // get the region (for France) short name
    $str = $home->getAddressComponent('administrative_area_level_1', true); // 'IDF'


###Setting up your config :

3 more options come with this webservice, an example in YAML format :

    gmap.options:
        geocoder:
            // the 4 common parameters
            bounds : ~ # default bounds option for each requests (see above)
            region : ~ # default region option for each requests (see above)
            language : ~ # default language option for each requests (see above)
            sensor : false // whether the browser has GPS functionalities

            
The elevation webservice
------------------------

This service is used to get the elevations from a list of pointd (lat/lng).
The `Formatter` result object has 4 methods :

-  `getLat()` : returns the latitude
-  `getLng()` : returns the longitude
-  `getLatLng()` : returns an array
-  `getElevation()` : returns the elevation (float)

    $elevations = $this->get('gmap')->elevation($points);

There is just one parameter :

    gmap.options:
        elevation:
            // the 4 common parameters
            sensor : false // whether the browser has GPS functionalities


The tool service
================


The polyline encoder
--------------------


This service is used in background by other services to compress a list of lat/lng points.
It's accessible in the controller with th following method :

    $encoded = $this->get('gmap')->encodePolyline($polyline);

Where $polyline is an array of points, each points is an array of 2 values : lat and lng ;
and $encoded is an associative array with 2 keys : 'points' (the encoded points) and 'levels' (the encoded levels).
Setting up your config :

Some options are available, here is an exemple with the YML format :

    gmap.options:
        polyline_encoder:
            accuracy: 5 # should not be changed !
            levels: 4 # the levels number (called numLevels in the Google's documentation)
            zoom: 3 # the zoom factor
            endpoints: true # indicate if endpoints should be forced

You can read more about in this stuff in 
[Google's documentation](http://code.google.com/apis/maps/documentation/utilities/polylinealgorithm.html).

