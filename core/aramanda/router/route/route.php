<?php
namespace Aramanda\Router\Route;

//use Aramanda\Router\Route\Implement\Route as _interface;
use Aramanda\Router\DataParser\RouteParser;
use Aramanda\Router\RouteGroup\GroupCollection;
use Aramanda\Router\RouteCollection\RouteCollection;


 /**
 * class of of individial route
 *
 * @package route
 */
class Route //implements _interface
{
	/**
	* Route name if it is related to named route index.
	*
	* @since 1.0
	* @var string
	*/
  public $name;

	/**
	* The request method the route is to listen to.
	*
	* @since 1.0
	* @var string
	*/
  public $httpMethod = [];

	/**
	* The request method the route is to listen to.
	*
	* @since 1.0
	* @var array
	*/
  public $routeDatas = [];

	/**
	* The unproccessed route string.
	*
	* @since 1.0
	* @var string
	*/
  public $rawRoute = null;

	/**
	* The proccessed route string.
	*
	* @since 1.0
	* @var array
	*/
  public $routeRegexes = [];


	/**
	* The associate array containing the Regular expression constaints of the parameter.
	*
	* @since 1.0
	* @var array
	*/
  public $matches = [];

	/**
	* The associate array containing the Regular expression constaints of the parameter.
	*
	* @since 1.0
	* @var array
	*/
  public $defaultRegex = '[\w]+';

	/**
	* The route handler.
	*
	* @since 1.0
	* @var string
	*/
  public $handler = null;

	/**
	* Namespace used by the router to instantiate your controler class, it overwrites the group namespace.
	*
	* @since 1.0
	* @var string
	*/
  public $namespace = null;

  /**
  * Array of middleware gets merged with the parent group.
  *
  * @since 1.0
  * @var array
  */
  public $middleware = [];

  /**
  * Route Subdomain string.
  *
  * @since 1.0
  * @var string
  */
  public $subdomain = null;

  /**
  * Route Subdomain proccessed strings.
  *
  * @since 1.0
  * @var array
  */
  public $subdomainRegexes = [];

  /**
  * Route Subdomain data.
  *
  * @since 1.0
  * @var array
  */
  public $subdomainDatas = [];

	/**
	* This stores group name for future reference.
	*
	* @since 1.0
	* @var object
	*/
  public $groupName = null;

	/**
	* This stores group object for future reference.
	*
	* @since 1.0
	* @var object
	*/
  public $groupObject = null;


  /**
 * Initial route loader
 *
 * @since 1.0
 *
 * @param array              $httpMethod http method to subscribe to.
 * @param string               $route    Route path and regex data.
 * @param mixed               $handler      properties.
 */
  function __construct(array $httpMethod, string $route, $handler)
  {
    $this->setHttpMethod($httpMethod);

    $this->setRoute($route);

    $this->setHandler($handler);

    $this->register();

    return $this;

  }




  /**
   * This add to the Regular expression constaints for a parameter
   *
   * @since 1.0
   *
   */
   protected function register()
   {
     RouteCollection::stack($this);
   }




  /**
   * This add to the Regular expression constaints for a parameter
   *
   * @since 1.0
   *
   * @param string|array  $var    variable name.
   * @param string        $regex  variable regex.
   */
    function where($var, string $regex = '')
    {
      if (is_string($var) && is_string($regex) && !empty($regex)){
          $this->matches[$var] = $regex;
      } else {

          foreach ($var as $key => $value) {
            $this->matches[$key] = $value;
          }

      }

      $this->UpdateRouteDataRegex();

      $this->UpdateSubdomainDataRegex();

      return $this;
    }




    /**
    * This updates the regex in the route data for the coresponding constraints
    *
    * @since 1.0
    *
    */
    protected function UpdateRouteDataRegex()
    {

      if ($this->routeDatas){

        foreach ($this->routeDatas as $key => $routeData) {

          $segmentIndex = $key;

          foreach ($routeData as $key => $part) {
            $segmentPartIndex = $key;

            if (is_array($part)){

              if (!isset($this->matches[$part[0]])) {
                continue;
              }

              $this->routeDatas[$segmentIndex][$segmentPartIndex][1] = $this->matches[$part[0]];

            }else{
              continue;
            }

          }

        }

      }

      $this->routeRegexes = [];

      $this->buildRegexForRouteDatas();

    }




    /**
    * This updates the regex in the subdomain data for the coresponding constraints
    *
    * @since 1.0
    *
    */
    protected function UpdateSubdomainDataRegex()
    {

      if ($this->subdomainDatas){

        foreach ($this->subdomainDatas as $key => $subdomainData) {

          $segmentIndex = $key;

          foreach ($subdomainData as $key => $part) {
            $segmentPartIndex = $key;

            if (is_array($part)){

              if (!isset($this->matches[$part[0]])) {
                continue;
              }

              $this->subdomainDatas[$segmentIndex][$segmentPartIndex][1] = $this->matches[$part[0]];

            }else{
              continue;
            }

          }

        }

      }


      $this->buildRegexForSubdomainDatas();

    }





    /**
    * This sets the name of a route for reuable purpose.
    *
    * @since 1.0
    *
    * @param string        $name  route name.
    */
    function name($name)
    {
      $this->name = strtolower($name);

      return $this;
    }



    /**
    * This sets the name of a route for reuable purpose.
    *
    * @since 1.0
    *
    * @param string        $name  route name.
    */
    protected function setHttpMethod($httpMethod)
    {
      $this->httpMethod = array_values( array_unique( array_merge( $this->httpMethod, $httpMethod ) ) );
      return $this;
    }



    /**
    * This sets the rawRoute string and array data of a route.
    *
    * @since 1.0
    *
    * @param string        $route  route string.
    */
    protected function setRoute($route)
    {
      $this->rawRoute = $route;

      $this->routeDatas = RouteParser::parse($this->rawRoute, $this->defaultRegex);

      $this->UpdateRouteDataRegex();
      return $this;

    }



    /**
    * This sets the rawRoute string and array data of a route.
    *
    * @since 1.0
    *
    * @param mixed        $handler  Route handler.
    */
    protected function setHandler($handler)
    {
      $this->handler = $handler;
      return $this;

    }



    /**
    * This sets the rawRoute string and array data of a route.
    *
    * @since 1.0
    *
    * @param mixed        $options  Route options.
    */
    public function setOptions($options)
    {

      return $this;

    }


    /**
    * Alias of setMiddleware
    *
    * @since 1.0
    *
    */
    public function middleware( $middleware )
    {
      return $this->setMiddleware( $middleware );
    }


    /**
    * This set the middleware for a particular route, merges with the parent
    *
    * @since 1.0
    *
    * @param string|array  $middleware variable name.
    *
    */
    protected function setMiddleware( $middleware )
    {
      $this->middleware[] = $middleware;

      return $this;
    }




    /**
    * Alias of setMiddleware
    *
    * @since 1.0
    *
    */
    public function namespace( $namespace )
    {
      return $this->setNamespace( $namespace );
    }


    /**
    * This set the middleware for a particular route, merges with the parent
    *
    * @since 1.0
    *
    * @param string|array  $middleware variable name.
    *
    */
    protected function setNamespace( $namespace )
    {
      $this->namespace = $namespace;

      return $this;
    }


    /**
    * This sets the domain regex and generates domain data, overrides parent domains
    *
    * @since 1.0
    *
    * @param string   $subDomain  domain data.
    */
    function subdomain($subdomain)
    {
      $this->subdomain = $subdomain;
      $this->subdomainDatas = RouteParser::parse($this->subdomain, $this->defaultRegex);

      $this->UpdateSubdomainDataRegex();

      return $this;
    }


    /**
     * This get the Regular expression constaints for a parameter
     *
     * @since 1.0
     *
	   * @return array fully merged array of Regular expression constaints for a parameter.
     */
      public function getWhere()
      {
        return $this->matches;
      }


     /**
     * This get the Regular expression constaints for a parameter
     *
     * @since 1.0
     *
	   * @return array fully merged array of Regular expression constaints for a parameter.
     */
      public function getHttpMethod()
      {
        return $this->httpMethod;
      }



      /**
      * This gets the name of a group for reuable purpose.
      *
      * @since 1.0
      *
 	    * @return string Name accociated with the group.
      */
      public function getName()
      {
        return strtolower($this->name);
      }



      /**
      * This gets the RawRoute of a Route for reuable purpose.
      *
      * @since 1.0
      *
 	    * @return string Raw Route string.
      */
      public function getRawRoute()
      {
        return $this->rawRoute;
      }



      /**
      * This gets the RawRoute of a Route for reuable purpose.
      *
      * @since 1.0
      *
 	    * @return string Raw Route string.
      */
      public function getRouteDatas()
      {
        return $this->routeDatas;
      }


      /**
      * This gets the middleware for a particular route, merges with the parent
      *
      * @since 1.0
      *
 	    * @return array Name accociated with the route.
      *
      */
      function getMiddleware()
      {
        $middleware = [];
        if (!is_null($this->getGroupObject()) && is_array($this->getGroupObject()->getMiddleware())){
          $middleware = array_merge( $this->getGroupObject()->getMiddleware(), $middleware );
        }

        $middleware = array_merge( $middleware, $this->middleware );
        return $middleware;
      }


      /**
      * This gets the prefix for a particular route, merges with the parent
      *
      * @since 1.0
      *
 	    * @return string prefix accociated with the group.
      *
      */
      public function getPrefix()
      {
        $prefix = '';
        if (!is_null($this->getGroupName())){
          $prefix =  $this->getGroupObject()->getPrefix();
        }
        return $prefix;
      }


      /**
      * This gets the namespace for a particular route, if set overrides the parent
      *
      * @since 1.0
      *
 	    * @return string prefix accociated with the group.
      *
      */
      public function getNamespace()
      {
        $namespace = '';

        if (!is_null($this->getGroupObject())) $namespace = $this->getGroupObject()->getNamespace();

        if (!is_null($this->namespace)) $namespace =  $this->namespace;

        return $namespace;
      }





      /**
      * This gets the domain regex , if route dont have inherit from parent group
      *
      * @since 1.0
      *
      * @return string subdomain pattern.
      */
      public function getSubdomain()
      {

        if (is_null($this->subdomain) && !is_null($this->getGroupObject()) ){
          return $this->getGroupObject()->getSubdomain();
        }

        return $this->subdomain;
      }


      /**
      * This gets the domain regex and generates domain data, overrides parent domains
      *
      * @since 1.0
      *
 	    * @return string subdomain pattern data.
      */
      function getSubdomainDatas()
      {
          return $this->subdomainDatas;
      }


      /**
      * This gets the domain regex and generates domain data, overrides parent domains.
      *
      * @since 1.0
      *
 	    * @return string subdomain pattern data.
      */
      function getSubdomainRegexes()
      {
          return $this->subdomainRegexes;
      }


      /**
      * This gets the route group name
      *
      * @since 1.0
      *
 	    * @return string groupname.
      */
      function getGroupName()
      {
        return $this->groupName;
      }


      /**
      * This gets the route group Object
      *
      * @since 1.0
      *
 	    * @return string group Object.
      */
      function getGroupObject()
      {
        return $this->groupObject;
      }






      /**
      * Alias of setGroup
      *
      * @since 1.0
      *
      */
      public function group( string $name )
      {
        return $this->setGroup( $name );
      }


      /**
      * This gets the instance of a group from the $groupStack
      *
      * @since 1.0
      *
      * @param string  $name group name.
      *
      */
      protected function setGroup( string $name )
      {

        $group = GroupCollection::get($name);

        if ($group === false){
          die("Group not found");
        }

        $this->groupName = $group->getName();
        $this->groupObject = $group;

        $newroute = $this->getGroupObject()->getPrefix().$this->rawRoute;
        $this->setRoute($newroute);
        if ($this->getSubdomain() == null){

          $this->subdomain( $this->getGroupObject()->getSubdomain() );

        }

        return $this;
      }



      private function buildRegexForRouteDatas()
      {

        foreach ($this->getRouteDatas() as $routeData) {
          $this->routeRegexes[] = $this->buildRegexForRoute($routeData);
        }
      }



      protected function buildRegexForRoute($routeData)
      {
          $regex = '';
          $variables = [];
          foreach ($routeData as $part) {
              if (is_string($part)) {
                  $regex .= preg_quote($part, '~');
                  continue;
              }

              list($varName, $regexPart) = $part;

              if (isset($variables[$varName])) {
                  die("Cannot use the same placeholder '$varName' twice");
              }
          /*
              if ($this->regexHasCapturingGroups($regexPart)) {
                  die("Regex '$regexPart' for parameter '$varName' contains a capturing group");
              }

          */

          $variables[$varName] = $varName;
          $regex .= '(' . $regexPart . ')';

          }

          return [$regex, $variables];
      }




      public function hasHttpMethod(string $httpMethod)
      {
        if (in_array( $httpMethod, $this->getHttpMethod())){
          return true;
        }

        return false;
      }









      private function buildRegexForSubdomainDatas()
      {

        foreach ($this->getSubdomainDatas() as $subdomainData) {
          $this->subdomainRegexes[] = $this->buildRegexForSubdomainData($subdomainData);
        }
      }



      protected function buildRegexForSubdomainData($subdomainData)
      {
          $regex = '';
          $variables = [];
          foreach ($subdomainData as $part) {
              if (is_string($part)) {
                  $regex .= preg_quote($part, '~');
                  continue;
              }

              list($varName, $regexPart) = $part;

              if (isset($variables[$varName])) {
                  die("Cannot use the same placeholder '$varName' twice");
              }
          /*
              if ($this->regexHasCapturingGroups($regexPart)) {
                  die("Regex '$regexPart' for parameter '$varName' contains a capturing group");
              }

          */

          $variables[$varName] = $varName;
          $regex .= '(' . $regexPart . ')';

          }

          return [$regex, $variables];
      }




      public function matchRoute(string $path)
      {

        foreach ($this->routeRegexes as $regex) {
          if ($this->isStatic($regex)){

            if ($path == $regex[0]){

              return [
                "status" => true,
                "routeParameters" => []
              ];

            }

          } else if ( !$this->isStatic($regex) ) {

            if (!preg_match('~^'.$regex[0].'$~', $path, $matches)) {
                continue;
            }

            $vars = [];
            $i = 0;
            foreach ($regex[1] as $varName) {
                $vars[$varName] = $matches[++$i];
            }

            return [
              "status" => true,
              "routeParameters" => $vars
            ];

          }
        }

        return false;
      }


      public function isStatic($regex)
      {

        if ( count($regex[1]) == 0) {
            return true;
        }

        return false;
      }


      public function matchSubdomain(string $hostName)
      {

        foreach ($this->subdomainRegexes as $regex) {
          if ($this->isStatic($regex)){

            if ($hostName == $regex[0]){

              return [
                "status" => true,
                "subdomainParameters" => []
              ];

            }

          } else if ( !$this->isStatic($regex) ) {

            if (!preg_match('~^'.$regex[0].'$~', $hostName, $matches)) {
                continue;
            }

            $vars = [];
            $i = 0;
            foreach ($regex[1] as $varName) {
                $vars[$varName] = $matches[++$i];
            }

            return [
              "status" => true,
              "subdomainParameters" => $vars
            ];

          }
        }

        return false;
      }




}
