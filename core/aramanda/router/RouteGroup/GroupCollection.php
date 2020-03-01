<?php

namespace Aramanda\Router\RouteGroup;

class GroupCollection
{

  /**
  * Index array that store route Groups.
  *
  * @since 1.0
  * @var array
  */
  public static $groupStack = [];


  /**
  * Adds a group to the group collection.
  *
  *
  * @param RouteGroup $route
  */
  public static function stack( RouteGroup $group ){

    static::$groupStack[] = $group;

    return $group;

  }






}
?>
