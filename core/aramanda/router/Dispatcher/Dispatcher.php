<?php
namespace Aramanda\Router\Dispatcher;

use Aramanda\Router\RouteCollection\RouteCollection;
use Aramanda\Router\RouteCollector\RouteCollector;


/**
 * This is the class that handles dispatsion of routes.
 */
class Dispatcher
{

  const NOT_FOUND = 0;

  const FOUND = 1;

  const METHOD_NOT_SUPPORTED = 2;

  function __construct()
  {

  }

  public static function dispatch(string $httpMethod, string $path, string $hostName = null){

    foreach (RouteCollection::$routeStack as $route ) {
      if ($route->hasHttpMethod($httpMethod) == false){
        continue;
      }


      if ( !is_null($route->getSubdomain())  && !is_null($hostName) ){
        $matchSubdomain = $route->matchSubdomain($hostName);
        echo "got here " . $route->subdomainRegexes[0][0];
        if (  $matchSubdomain != false ){
          $result['subdomainParameters'] = $matchSubdomain['subdomainParameters'];
        } else {
          continue;
        }
      }



      if ($route->matchRoute($path) == false){
        continue;
      }


      $match = $route->matchRoute($path);

      $result['status'] = static::FOUND;
      //$result['route'] = $route;
      $result['routeParameters'] = $match['routeParameters'];

      return $result;


    }

    return [
      "status" => static::NOT_FOUND,
      "route" => null
    ];

  }


}
