<?php

namespace Aramanda\Router\RouteGroup;
namespace Aramanda\Router\RouteGroup\GroupCollection;


class GroupCollector {

   /**
    * Adds a group to the collection.
    *
    * @param string $name
    * @param string  $prefix
    * @param array  $options
    */

    public static function addGroup(string $name, string $prefix = '', array $options = []){

        $group = new RouteGroup( $name, $prefix)->setOptions( $options );

        GroupCollection::stack($route);

        return $group;
    }

}

 ?>
