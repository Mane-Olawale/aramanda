<?php



define( 'DS', DIRECTORY_SEPARATOR );
define( 'ROOT_PATH', dirname(__FILE__) );

define( 'PUBLIC_PATH', $_SERVER['DOCUMENT_ROOT'] );

include ROOT_PATH . DS . 'core/init.php';

use Aramanda\Environment as Env;

Env::load_env_file( ROOT_PATH . DS . 'env.ini');

?>

<?php

use Aramanda\Router\Router;


echo '<pre>' . json_encode (Router::get(
  '/content/{id}/{slug}',
  'controller::class',
  ['defaultRegex' => '[\w+]'])) . '</pre>';

 ?>

<?php //echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>

<?php echo $_SERVER['REQUEST_URI'];?>
