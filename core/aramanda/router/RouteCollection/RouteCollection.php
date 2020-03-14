<?php

namespace Aramanda\Router\RouteCollection;

use Aramanda\Router\Route\Route;

class RouteCollection
{

  /**
  * Index array that store routes.
  *
  * @since 1.0
  * @var array
  */
  public static $routeStack = [];


  /**
  * Adds a route to the route collection.
  *
  *
  * @param string Group name
  */
  public static function stack( Route $route ){

    static::$routeStack[] = $route;

    return $route;

  }




    /**
    * Gets a route from the route collection.
    *
    *
    * @param string route name
    */
    public static function get( string $name ){

      foreach (static::$routeStack as $route) {
        if ( $route->getName() == $name ){
          return $route;
        }
      }

      return false;

    }



}
