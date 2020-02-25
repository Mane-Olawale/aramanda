<?php

namespace Aramanda\Environment;

use Aramanda\Environment\Implement\Environment as _interface;

/*
The Environment parent class
Partern: Singleton
*/
abstract class Environment implements  _interface{

  protected static $instance;

  protected $env_array;

  protected $env_file_array;


  protected function __construct (){

  }


  public static function load_env_file (string $file){

    //Check if a configuration has been loaded
    if (static::if_loaded()){

      return;

    }

    static :: $instance = new static();


    //Lets parse the ini file to array
    if (file_exists( $file )){

        static::$instance -> env_array = parse_ini_file( $file, TRUE, INI_SCANNER_TYPED);
        static::$instance -> env_file_array = file( $file );

    }

  }

  public static function get ( string $getter ){
    //If configuration is not loaded
    if ( !static::if_loaded () ) return;

    $getter = strtoupper( $getter );

    $getter_array = explode('.', $getter);

    $count = count( $getter_array );

    $result = static::$instance -> env_array;

    foreach ($getter_array as $n => $key) {

      if ( substr( $key, 0, 1) === "$") $key = (int) trim($key, '$');

      if ( isset( $result[$key] ) ) {
        $result = $result[$key];
      }else{
        $result = '';
        break;
      }

      if ( ($n + 1) === $count ) break;

    }

    return $result;

    /*
    if (isset($key)){

      $key = strtoupper( $key );
      if (isset(static::$instance -> env_array[$segment][$key])){
        return static::$instance -> env_array[$segment][$key];

      }
    } else {

      if (isset(static::$instance -> env_array[$segment])){
        return static::$instance -> env_array[$segment];
      }

    }
    */


  }


  public static function if_loaded (){

    if ( !is_null( static::$instance ) ){
      return TRUE;
    } else {
      return FALSE;
    }

  }

}
 ?>
