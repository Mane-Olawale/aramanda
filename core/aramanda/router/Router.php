<?php

namespace Aramanda\Router;

use Aramanda\Router\RouteCollector\RouteCollector;
use Aramanda\Router\RouteGroup\GroupCollector;

class Router {



  /**
   * Adds a route to the collection.
   *
   * The syntax used in the $route string depends on the used route parser.
   *
   * @param string $method
   * @param string $route
   * @param mixed  $handler
   * @param array  $options
   */
   public static function addRoute( $method, $route, $handler, $option = []){

     $route = RouteCollector::addRoute( $method, $route, $handler, $option);

     return $route;

   }


   /**
    * Adds a route to the collection with the get method.
    *
    * The syntax used in the $route string depends on the used route parser.
    *
    * @param string $route
    * @param mixed  $handler
    * @param array  $options
    */
    public static function get( $route, $handler, $option = []){

      $route = static::addRoute( ['GET'], $route, $handler, $option);

      return $route;

    }


   /**
    * Adds a route to the collection with the POST method.
    *
    * The syntax used in the $route string depends on the used route parser.
    *
    * @param string $route
    * @param mixed  $handler
    * @param array  $options
    */
    public static function post( $route, $handler, $option = []){

      $route = static::addRoute( ['POST'], $route, $handler, $option);

      return $route;

    }



   /**
    * Adds a route to the collection with the PUT method.
    *
    * The syntax used in the $route string depends on the used route parser.
    *
    * @param string $route
    * @param mixed  $handler
    * @param array  $options
    */
    public static function put( $route, $handler, $option = []){

      $route = static::addRoute( ['PUT'], $route, $handler, $option);

      return $route;

    }



    /**
    * Adds a route to the collection with the PATCH method.
    *
    * The syntax used in the $route string depends on the used route parser.
    *
    * @param string $route
    * @param mixed  $handler
    * @param array  $options
    */
    public static function patch( $route, $handler, $option = []){

      $route = static::addRoute( ['PATCH'], $route, $handler, $option);

      return $route;

    }



    /**
    * Adds a route to the collection with the OPTIONS method.
    *
    * The syntax used in the $route string depends on the used route parser.
    *
    * @param string $route
    * @param mixed  $handler
    * @param array  $options
    */
    public static function options( $route, $handler, $option = []){

      $route = static::addRoute( ['OPTIONS'], $route, $handler, $option);

      return $route;

    }




    /**
    * Adds a route to the collection with the DELETE method.
    *
    * The syntax used in the $route string depends on the used route parser.
    *
    * @param string $route
    * @param mixed  $handler
    * @param array  $options
    */
    public static function delete( $route, $handler, $option = []){

      $route = static::addRoute( ['DELETE'], $route, $handler, $option);

      return $route;

    }




    /**
    * Adds a route to the collection with the HEAD method.
    *
    * The syntax used in the $route string depends on the used route parser.
    *
    * @param string $route
    * @param mixed  $handler
    * @param array  $options
    */
    public static function head( $route, $handler, $option = []){

      $route = static::addRoute( ['HEAD'], $route, $handler, $option);

      return $route;

    }



    /**
    * Adds a route to the collection with the GET and POST method.
    *
    * The syntax used in the $route string depends on the used route parser.
    *
    * @param string $route
    * @param mixed  $handler
    * @param array  $options
    */
    public static function form( $route, $handler, $option = []){

      $route = static::addRoute( ['GET', 'POST'], $route, $handler, $option);

      return $route;

    }




    /**
    * Adds a route to the collection with any method.
    *
    * The syntax used in the $route string depends on the used route parser.
    *
    * @param string $route
    * @param mixed  $handler
    * @param array  $options
    */
    public static function any( $route, $handler, $option = []){

      $route = static::addRoute( RouterCollector::ACCEPTED_HTTP_METHODS, $route, $handler, $option);

      return $route;

    }




    /**
    * Adds a group to the group collection.
    *
    *
    * @param string $name
    * @param string  $prefix
    * @param array  $options
    */
    public static function group( $name, $prefix, $option = []){

      $route = GroupCollector::addGroup(  $name, $prefix, $option);

      return $route;

    }




}
