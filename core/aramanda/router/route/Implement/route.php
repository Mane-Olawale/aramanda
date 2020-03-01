<?php
namespace Aramanda\Router\Route\Implement;


 /**
 * Interface of individial route
 *
 * @package route
 */
class Route implements _interface
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
  public $method;

	/**
	* The request method the route is to listen to.
	*
	* @since 1.0
	* @var array
	*/
  public $routeData = [];

	/**
	* The unproccessed route string.
	*
	* @since 1.0
	* @var string
	*/
  public $rawRoute;

	/**
	* The associate array containing the Regular expression constaints of the parameter.
	*
	* @since 1.0
	* @var array
	*/
  public $matches = [];

	/**
	* The associate array containing the options of a route.
	*
	* @since 1.0
	* @var array
	*/
  public $options = [];

	/**
	* The route handler.
	*
	* @since 1.0
	* @var string
	*/
  public $handler;

	/**
	* Namespace used by the router to instantiate your controler class, it overwrites the group namespace.
	*
	* @since 1.0
	* @var string
	*/
  public $namespace;

  /**
  * Array of middleware gets merged with the parent group.
  *
  * @since 1.0
  * @var array
  */
  public $middleWare;

  /**
  * Route Subdomain string.
  *
  * @since 1.0
  * @var string
  */
  public $subDomain;

  /**
  * Route Subdomain data.
  *
  * @since 1.0
  * @var string
  */
  public $subDomainData;

	/**
	* This stores group name for future reference.
	*
	* @since 1.0
	* @var string
	*/
  public $groupName;

	/**
	* This stores group name for future reference.
	*
	* @since 1.0
	* @var object
	*/
  public $groupObject;


  /**
 * Initial route loader
 *
 * @since 1.0
 *
 * @param string      $method http method to subscribe to.
 * @param array       $routeData    Route path and regex data.
 * @param string|object       $handler      Regular expression match array.
 */
  function __construct(string $method, array $routeData, $handler)
  {
    // code...
  }


  /**
   * This add to the Regular expression constaints for a parameter
   *
   * @since 1.0
   *
   * @param string|array  $var variable name.
   * @param string        $regex    variable regex.
   */
    function where(string $var, string $regex)
    {
      // code...
    }


    /**
    * This this filters the $matches property for duplicated constraints
    *
    * @since 1.0
    *
    */
    function filterMatches()
    {
      // code...
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
      // code...
    }


    /**
    * This set the middleware for a particular route, merges with the parent
    *
    * @since 1.0
    *
    * @param string|array  $middleware variable name.
    *
    */
    function setMiddleware( $middleware )
    {
      // code...
    }


    /**
    * This sets the domain regex and generates domain data, overrides parent domains
    *
    * @since 1.0
    *
    * @param string   $subDomain  domain data.
    */
    function subDomain($subDomain)
    {
      // code...
    }


    /**
     * This get the Regular expression constaints for a parameter
     *
     * @since 1.0
     *
	   * @return array fully merged array of Regular expression constaints for a parameter.
     */
      function getWhere(string $var, string $regex)
      {
        // code...
      }



      /**
      * This gets the name of a route for reuable purpose.
      *
      * @since 1.0
      *
 	    * @return string Name accociated with the route.
      */
      function getName()
      {
        // code...
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
        // code...
      }


      /**
      * This gets the domain regex and generates domain data, if route dont have inherit from group
      *
      * @since 1.0
      *
 	    * @return string subdomain pattern.
      */
      function getSubDomain()
      {
        // code...
      }


      /**
      * This gets the domain regex and generates domain data, overrides parent domains
      *
      * @since 1.0
      *
 	    * @return string subdomain pattern data.
      */
      function getSubDomainData()
      {
        // code...
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
        // code...
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
        // code...
      }






}
