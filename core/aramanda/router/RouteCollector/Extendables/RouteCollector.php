<?php

namespace Aramanda\Router\RouteCollector\Extendables;

use Aramanda\Router\Route\Route as Route;

abstract class RouteCollector {

    const ACCEPTED_HTTP_METHODS = [
      'GET',
      'POST',
      'PUT',
      'PATCH',
      'OPTIONS',
      'DELETE',
      'HEAD'
    ];
   /**
    * Adds a route to the collection.
    *
    * The syntax used in the $route string depends on the used route parser.
    *
    * @param string|array $httpMethod
    * @param string $route
    * @param mixed  $handler
    * @param array  $options
    */

    public static function addRoute( array $httpMethod, string $route, $handler, $options = []){

        $route = (new Route( $httpMethod, $route, $handler))->setOptions( $options );

        return $route;
    }

}
