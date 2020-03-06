<?php
namespace Aramanda\Router\RouteGroup;


use Aramanda\Router\DataParser\RouteParser;

 /**
 * class of of individial route
 *
 * @package route
 */
class Group
{

  /**
  * The request method the route is to listen to.
  *
  * @since 1.0
  * @var string
  */
  public static $validOptions = [
    "defaultRegex",
    "namespace",
    "middleware",
    "groupName",
    "subdomain"
  ];


	/**
	* Route name if it is related to named route index.
	*
	* @since 1.0
	* @var string
	*/
  public $name = null;


	/**
	* The associate array containing the Regular expression constaints of the parameter.
	*
	* @since 1.0
	* @var array
	*/
  public $defaultRegex = '[\w]+';

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
 * @param array        $name          name of the group.
 * @param string       $prefix        prefix Route path and regex data.
 * @param mixed        $options       properties.
 */
  function __construct(string $name, string $prefix = "", $options = [])
  {
    $this->setName( $name );

    $this->setPrefix( $prefix );

    $this->setOptions( $options );

    //$this->register();

    return $this;

  }

    /**
    * This sets the name of a group.
    *
    * @since 1.0
    *
    * @param string        $name  Group name.
    */
    protected function setName($name)
    {
      $this->name = strtolower($name);

      return $this;
    }



    /**
    * This sets the rawRoute string and array data of a route.
    *
    * @since 1.0
    *
    * @param array        $options  Route options.
    */
    public function setOptions(array $options = [])
    {
      foreach ($options as $key => $value) {
        if (!in_array($key, Group::$validOptions)){
          echo "Invalid Route Group option";
          break;
        }




        $this->{'set'.ucwords($key)}($value);

      }

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
    * @param string|array  $middleware middleware array.
    *
    */
    protected function setMiddleware( $middleware )
    {
      if (is_array($middleware)){
        foreach ($middleware as $value) {
          $this->middleware[] = $value;
        }
      }else{
        $this->middleware[] = $middleware;
      }


      return $this;
    }





    /**
    * Alias of setNamespace
    *
    * @since 1.0
    *
    */
    public function namespace( $namespace )
    {
      return $this->setNamespace( $namespace );
    }


    /**
    * This set the namespace for a particular group, merges with the parent
    *
    * @since 1.0
    *
    * @param string  $namespace variable name.
    *
    */
    protected function setNamespace( $namespace )
    {
      $this->namespace = $namespace;

      return $this;
    }


    /**
    * Alias of setPrefix
    *
    * @since 1.0
    *
    * @param string  $prefix variable name.
    *
    */
    public function prefix( $prefix )
    {
      $this->setPrefix( $prefix );

      return $this;
    }


    /**
    * This set the middleware for a particular route, merges with the parent
    *
    * @since 1.0
    *
    * @param string  $prefix variable name.
    *
    */
    protected function setPrefix( $prefix )
    {
      $this->prefix = $prefix;

      return $this;
    }


    /**
    * This sets the domain regex and generates domain data, overrides parent domains
    *
    * @since 1.0
    *
    * @param string   $subDomain  domain data.
    */
    public function subdomain($subdomain)
    {
      $this->setSubdomain($subdomain);

      return $this;
    }


    /**
    * This sets the domain regex and generates domain data, overrides parent domains
    *
    * @since 1.0
    *
    * @param string   $subDomain  domain data.
    */
    protected function setSubdomain($subdomain)
    {
      $this->subdomain = $subdomain;

      return $this;
    }


    /**
    * This sets the default regex, overrides parent
    *
    * @since 1.0
    *
    * @param string   $subDomain  domain data.
    */
    protected function setDefaultRegex($regex)
    {
      $this->defaultRegex = $regex;

      return $this;
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
        if (!is_null($this->groupObject) && !is_array($this->groupObject->getMiddleware())){
          $middleware = array_merge( $this->groupObject->getMiddleware(), $middleware );
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
        if (!is_null($this->groupName)){
          $prefix =  $prefix . $this->groupObject->getPrefix();
        }

        if (substr( $this->prefix, 0, 1) === "$"){
          $prefix = '';
        }

        $prefix = $prefix . $this->prefix;
        return $prefix;
      }

      /**
      * This gets the domain regex , if group dont have inherit from parent group
      *
      * @since 1.0
      *
 	    * @return string subdomain pattern.
      */
      public function getSubdomain()
      {

        if (is_null($this->subdomain)){
          return $this->groupObject->getSubdomain();
        }

        return $this->subdomain;
      }


      /**
      * This gets the parent group name
      *
      * @since 1.0
      *
 	    * @return string groupname.
      */
      public function getGroupName()
      {
        return $this->groupName;
      }


      /**
      * This gets the parent group Object
      *
      * @since 1.0
      *
 	    * @return string group Object.
      */
      public function getGroupObject()
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

        return $this;
      }







}
