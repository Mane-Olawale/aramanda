<?php



define( 'DS', DIRECTORY_SEPARATOR );
define( 'ROOT_PATH', dirname(__FILE__) );

define( 'PUBLIC_PATH', ROOT_PATH . DS . 'public' );

include ROOT_PATH . DS . 'core/vendor/autoload.php';

use Aramanda\Config\Environment as Env;

Env::load_env_file(ROOT_PATH . DS . 'env.ini');

echo Env::get('app', 'name');
