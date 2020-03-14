<?php

namespace Aramanda\Router\Url;

use Aramanda\Router\RouteCollection\RouteCollection;
use Aramanda\Router\DataParser\RouteParser;

/**
 * This class bulds a url from the path.
 */
class RouteUrl
{
	/**
	* Raw Route string for proccessing url path
	*
	* @since 1.0
	* @var string
	*/
  protected $rawRoute;



	/**
	* Path parameters used for proccessing url path
	*
	* @since 1.0
	* @var array
	*/
  protected $parameters = [];



	/**
	* proccessed url path
	*
	* @since 1.0
	* @var string
	*/
  protected $url;



	/**
	* Parameters used for proccessing url parameters
	*
	* @since 1.0
	* @var array
	*/
  public $urlParams = [];




  /**
  * Constructor function
  *
  *
  * @param string $routeName
  * @param array  $parameters
  */
  public function url(string $routeName, array $parameters)
  {
    return new static( $routeName, $parameters);
  }




  /**
  * Constructor function
  *
  *
  * @param string $routeName
  * @param array  $parameters
  */
  protected function __construct(string $routeName, array $parameters)
  {
    $route = RouteCollection::get($routeName);
    if($route == false){
      die("unknown Route");
    }

    $this->setRawRoute( $route->getRawRoute() );

    $this->setParameters( $parameters );

    $this->setRawRoute( $route->getRawRoute() );

  }




  /**
  * set parameters
  *
  *
  * @param array $parameters
  */
  public function setParameters( array $parameters)
  {
    $this->parameters = $parameters;

    $this->bindParametersToRawRoute();
  }




  /**
  * get parameters array
  *
  *
  * @param string $parameters
  */
  public function getParameters()
  {
    return $this->parameters;
  }




  /**
  * set url
  *
  *
  * @param string $url
  */
  public function setUrl( string $url)
  {
    $this->url = $url;
  }




  /**
  * get parameters array
  *
  *
  * @param string $parameters
  */
  public function getUrl()
  {
    return $this->url;
  }





  /**
  * Bind parameters with raw route
  *
  *
  */
  public function bindParametersToRawRoute()
  {
    $this->setUrl( $this->getRawRoute() );

    foreach ($this->getParameters() as $key => $value) {

      $this->setUrl( str_replace('{'.$key.'}', $value, $this->getUrl() ) );

    }

    $this->setUrl( preg_replace( '~' . RouteParser::VARIABLE_REGEX . '~x', '', $this->getUrl() ) );

    $this->setUrl( rtrim( $this->getUrl(), '/') );

  }




  /**
  * set a raw unproccessed route
  *
  *
  * @param string $rawRoute
  */
  public function setRawRoute( string $rawRoute)
  {
    $this->rawRoute = $rawRoute;

    $this->removeOptionRawRoute();

  }




  /**
  * set a raw unproccessed route
  *
  *
  * @param string $rawRoute
  */
  public function getRawRoute()
  {
    return $this->rawRoute;
  }




  /**
  * Remove optional tags
  *
  *
  * @param string $rawRoute
  */
  public function removeOptionRawRoute()
  {
    $this->rawRoute = str_replace( '[', '', $this->getRawRoute() );
    $this->rawRoute = str_replace( ']', '', $this->getRawRoute() );
  }




  /**
  * Set url parameters
  *
  *
  * @param string parameter array
  * @param string|array parameter array
  *
  */
  public function param($var, string $val = '')
  {
    if (is_string($var) && is_string($val) && !empty($val)){
        $this->urlParams[$var] = $val;
    } else {

        foreach ($var as $key => $value) {
          $this->urlParams[$key] = $value;
        }

    }

    return $this;
  }




  /**
  * get the url parameters
  *
  *
  * @return array parameters array
  *
  */
  public function getUrlParams()
  {
    return $this->urlParams;
  }




  /**
  * Render fully proccessed url
  *
  *
  * @return string $url fully proccessed url
  *
  */
  public function get()
  {
    return $this->buildUrl();
  }




  /**
  * Build url fully
  *
  *
  * @return string $url fully proccessed url
  *
  */
  public function buildUrl()
  {
    $url = $this->getUrl();
    $queryString = '';

    foreach ($this->getUrlParams() as $key => $value) {

      $queryString .= $key . '=' . $value . '&';

    }

    $queryString = rtrim( $queryString, '&');

    $fullUrl = ( count($this->getUrlParams()) ) ? $url . '?' . $queryString : $url;

    return $fullUrl;

  }






}
