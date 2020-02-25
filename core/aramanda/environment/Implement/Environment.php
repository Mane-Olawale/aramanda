<?php

namespace Aramanda\Environment\Implement;


/*
* The Environment inter
* Partern: Singleton
*/
interface Environment
{

  public static function load_env_file (string $file);


    public static function get (string $segment);

    public static function if_loaded ();


}
