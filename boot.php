<?php



define( 'DS', DIRECTORY_SEPARATOR );
define( 'ROOT_PATH', dirname(__FILE__) );

define( 'PUBLIC_PATH', $_SERVER['DOCUMENT_ROOT'] );

include ROOT_PATH . DS . 'core/init.php';

use Aramanda\Environment as Env;

Env::load_env_file( ROOT_PATH . DS . 'env.ini');

echo Env::get( 'app.name');

?>

<?php

use Aramanda\Router\Router;

/*
echo '<pre>' . json_encode (Router::any(
  '/content/{id}/{id}/{slug}',
  'controller::class',
  ['defaultRegex' => '[\w+]'])->where([
    'id' => '[0-9]+',
    'slug' => '[a-zA-Z0-9_-]+',
    'username' => '[a-zA-Z0-9_-]+'
  ])->name('content')->group('admin')) . '</pre>';
*/



Router::group('api',
  '/api', ['namespace' => 'Ext\\Andronix\\Affiliate',
  'middleware' => ['SDK:token']
]);

$group = Router::group('api_admin',
  '/admin', ['namespace' => 'Ext\\Andronix\\Affiliate',
  'middleware' => ['Auth:user','CSRF:token']
])->group('api')->getMiddleware();

$route = Router::any(
  '/content/{id}/{id}/{slug}',
  'controller::class',
  ['defaultRegex' => '[\w+]'])->where([
    'id' => '[0-9]+',
    'slug' => '[a-zA-Z0-9_-]+',
    'username' => '[a-zA-Z0-9_-]+'
  ])->name('content')->group('api_admin')->getMiddleware();


echo "<pre>";
//var_dump (Aramanda\Router\RouteGroup\GroupCollection::$groupStack);
var_dump ($route);
echo "</pre>";




 ?>

<?php //echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>
