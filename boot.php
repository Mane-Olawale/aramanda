<?php



define( 'DS', DIRECTORY_SEPARATOR );
define( 'ROOT_PATH', dirname(__FILE__) );

define( 'PUBLIC_PATH', $_SERVER['DOCUMENT_ROOT'] );

include ROOT_PATH . DS . 'core/init.php';

use Aramanda\Environment as Env;

Env::load_env_file( ROOT_PATH . DS . 'env.ini');

//echo Env::get( 'app.name');

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
  '/api/v1',
  [
    'namespace' => 'Ext\\Andronix\\Affiliate\\Admin',
    'middleware' => ['SDK:token']
  ]);

$group = Router::group('api_admin',
  '/admin', [
  'middleware' => ['Auth:user','CSRF:token']
])->group('api')->getMiddleware();

$route = Router::any(
  '/content/{id}/{page}[/{slug}]',
  'controller::class',
  ['defaultRegex' => '[\w+]'])->where([
    'id' => '[0-9]+',
    'page' => '[0-9]+',
    'slug' => '[a-zA-Z0-9_-]+',
    'username' => '[a-zA-Z0-9_-]+'
  ])->name('content')->group('api_admin');

  Router::any(
    '/page/{id}',
    'controller::class'
    )->where([
      'id' => '[0-9]+'
    ])->name('page')->subdomain('bola.localhost');

    Router::form(
      '/assets/{res_path}',
      'controller::class'
      )->where([
        'res_path' => '.+'
      ])->name('page');

    Router::any(
      '/about',
      'controller::class'
      )->name('about');

    Router::any(
      '/',
      'controller::class'
      )->name('home');



echo "<pre>";
var_dump( Router::url('content', [
      "id" => '47654',
      "page" => '6478'
    ])->param([
          "foo" => 'bar',
          "autoload" => 'true',
          "comment" => 'fvbsbeakbdabjd'
        ])->get() );
var_dump(Router::dispatch( $_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), "aramanda.localhost") );
//var_dump(Aramanda\Router\RouteCollection\RouteCollection::$routeStack);
//var_dump (Aramanda\Router\RouteGroup\GroupCollection::$groupStack);
//var_dump ($route);
//var_dump( parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) );
echo "</pre>";
