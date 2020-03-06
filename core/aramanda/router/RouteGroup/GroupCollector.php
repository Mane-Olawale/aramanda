<?php

namespace Aramanda\Router\RouteGroup;


class GroupCollector {

   /**
    * Adds a group to the collection.
    *
    * @param string $name
    * @param string  $prefix
    * @param array  $options
    */

    public static function addGroup(string $name, string $prefix = '', array $options = []){

        $group = (new Group( $name, $prefix))->setOptions( $options );

        GroupCollection::stack($group);

        return $group;
    }

}

 ?>
