<?php

namespace Aramanda\Config;

/*
The Environment Driver
Partern: Singleton
*/
class Environment {

  protected static $env_array = null;

  protected static $env_file_array = null;

  protected function __construct (){
    //Silence is golden
  }

  public static function load_env_file (string $file){

    //Check if a configuration has been loaded
    if (static::$env_array){
      return;
    }

    //Lets parse the ini file to array
    if (file_exists( $file )){

      static::$env_array = parse_ini_file( $file, TRUE);

    }

  }

  public static function get (string $segment = "APP", string $key = null){
    //If configuration is not loaded
    if (!isset(static::$env_array)) return;

    $segment = strtoupper( $segment );
    //die(json_encode(static::$env_array));
    if (isset($key)){

      $key = strtoupper( $key );
      if (isset(static::$env_array[$segment][$key])){
        return static::$env_array[$segment][$key];

      }
    } else {

      if (isset(static::$env_array[$segment])){
        return static::$env_array[$segment];
      }

    }
  }


}
 ?>
