<?php



define( 'DS', DIRECTORY_SEPARATOR );
define( 'ROOT_PATH', dirname(__FILE__) );

define( 'PUBLIC_PATH', $_SERVER['DOCUMENT_ROOT'] );

include ROOT_PATH . DS . 'core/init.php';

use Aramanda\Environment as Env;

Env::load_env_file( ROOT_PATH . DS . 'env.ini');

?>
