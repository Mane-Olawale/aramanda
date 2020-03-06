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
  * @param string Group name
  */
  public static function stack( Group $group ){

    if (isset(static::$groupStack[$group->getName()])){
      die('Group name already exists');
    }

    static::$groupStack[$group->getName()] = $group;

    return $group;

  }


  /**
  * Adds a group to the group collection.
  *
  *
  * @param Group $route
  */
  public static function get( string $name ){
    $name = strtolower($name);
    $found = false;
    $group = false;
    foreach (static::$groupStack as $key => $groupObject) {
      if ($name === $key){
        $found = true;
        $group = $groupObject;
        break;
      }
    }

    if ($found === false) {
      die('Group not found');
    }

    return $group;

  }






}
?>
