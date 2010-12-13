GMapBundle : The GMap webservices made easy for your Symfony2 applications
==========================================================================

**In progress** : This bundle is under active developpement, new features will be regularly appended.

**It works** : This bundle is under Test Driven Developpement control, so every features mentioned below will really work.

**Current implementation** : Only the geocoder webservice.


First steps
===========

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
        phpunit --configuration app/phpunit.xml.dist src/Bundle/GMapBundle/Tests/GeocoderTests.php
        
   
How to use
==========

This bundle offers a new service accessible from your controller. To access the service, simply use the following code :

    $gmap = $this->get('gmap');
    
These services are subject to a query limit of 2,500 geolocation requests per day (for each service, is suppose).
    
The geocoder webservice
-----------------------

This service is used to get latitude / longitude point from an address and vice-versa.
It can also be used to normalize and parse addresses. For more informations, look at the
[Google webservice documentation](http://code.google.com/apis/maps/documentation/geocoding/).

Simple to use, here are the examples :

    // get the geocode object from an address (wich is really dirty)
    $geocode = $gmap->geocode('12 rU hipOLYte lBAs 75009 fR');
    
    // get the geocode object from a latitude / longitude array
    $geocode = $gmap->geocode(array(48.8772535, 2.3397612));
    
    // get the geocode object from a latitude / longitude string
    $geocode = $gmap->geocode('48.8772535, 2.3397612');
    
As second parameter, you can provide an associative array of options :

-  bounds : The bounding box of the viewport within which to bias geocode results more prominently.
-  region : The region code, specified as a ccTLD ("top-level domain") two-character value.
-  language : The language in which to return results.
-  sensor (default to false) : Indicates whether or not the geocoding request comes from a device with a location sensor.

More explanations on these options on
[Google's documentation](http://code.google.com/apis/maps/documentation/geocoding/#GeocodingRequests).
    
The `geocode` method retors a `Geocode` object wich comes with several methods to get the data you want.
See what you can do with geocoder :

**Get the position of an address :**

    $geocode = $this->get('gmap')->geocode('12 Rue Hippolyte Lebas 75009 France');

    // get the latitude
    $lat = $geocode->getLat(); // 48.8772535
    
    // get the longitude
    $lat = $geocode->getLng(); // 2.3397612
    
    // get both as string
    $str = $geocode->getLatLng(); // '48.8772535, 2.3397612'
    
    // get both as an array
    $arr = $geocode->getLatLng(true); // array(48.8772535, 2.3397612)
    
**Get an address from a position :**

    $geocode = $this->get('gmap')->geocode('48.8772535, 2.3397612');
    
    // get the *normalized* address as string
    $str = $geocode->getAddress(); // 12 Rue Hippolyte Lebas, 75009 Paris, France
    
**Normalize an address :**
    
    // a dirty address is inputed by a user
    $geocode = $this->get('gmap')->geocode('12 rU hipOLYte lBAs 75009 fR');
    
    // get the *normalized* address
    $str = $geocode->getAddress(); // 12 Rue Hippolyte Lebas, 75009 Paris, France
    
**Address components :**

    $geocode = $this->get('gmap')->geocode('12 Rue Hippolyte Lebas 75009 France');
    
    // get the number
    $str = $geocode->getAddressComponent('street_number'); // '12'
    
    // get the city
    $str = $geocode->getAddressComponent('locality'); // 'Paris'
    
    // get the region (for France)
    $str = $geocode->getAddressComponent('administrative_area_level_1'); // 'Ile-de-France'
    
    // get the zip code
    $str = $geocode->getAddressComponent('postal_code'); // '75009'
    
    // get a sublocality
    $str = $geocode->getAddressComponent('sublocality'); // '9ème Arrondissement Paris'
    
And so on ... full list of components available on
[Google's documentation](http://code.google.com/apis/maps/documentation/geocoding/#Types).
If a component has several values, it returns an array.

In addition, `getAddressComponent` method take a 2nd boolean argument, wich setted to `true`
get you the short name. For example :

    // get the country short name
    $str = $geocode->getAddressComponent('country', true); // 'FR'
    
    // get the region (for France) short name
    $str = $geocode->getAddressComponent('administrative_area_level_1', true); // 'IDF'
    
**Seeting up your config :**

You want some options in your app/config file dont you ? OK, here is the full example (in YML format of course) :

    gmap.options:
        geocoder:
            url: http://maps.googleapis.com/maps/api/geocode # dont need to change
            format: json # just for the LOL, XML is not implemented yet
            bounds : ~ # default bounds option for each requests (see below)
            region : ~ # default region option for each requests (see below)
            language : ~ # default language option for each requests (see below)
            sensor : ~ # default sensor option for each requests (see below)
            
