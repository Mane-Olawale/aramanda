<?php

/**
 *
 */
class ClassName implements _interface
{
	/**
	* The request method the route is to listen to.
	*
	* @since 1.0
	* @var string
	*/
  public $method;

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
	* This stores group name for future reference.
	*
	* @since 1.0
	* @var string
	*/
  public $groupname;

	/**
	* This stores group name for future reference.
	*
	* @since 1.0
	* @var string
	*/
  public $groupObject;


  /**
 * Initial route loader
 *
 * @since 1.0
 *
 * @param string       $output Shortcode output.
 * @param string       $tag    Shortcode name.
 * @param array|string $attr   Shortcode attributes array or empty string.
 * @param array        $m      Regular expression match array.
 */
  function __construct(get)
  {
    // code...
  }
}
