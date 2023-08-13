<?php

require __DIR__ . './vendor/autoload.php';

use Bramus\Router\Router;

$router = new Router();

$router->setNamespace('AdventureTime\Controllers');

// $router->before('GET|POST|PUT|DELETE', '/.*', function () {
//     var_dump($_SERVER);
// });
// $router->before('GET|POST|PUT|DELETE', '/.*', 'UserController@getProfile');

$router->get('/test', 'UserController@getProfile');
//
//$router->get('/api/qq', 'UserController@getProfile');

$router->set404('ErrorController@resourceNotFound');

$router->run();