<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use MonologLogger;
use MonologHandlerStreamHandler;
use MonologHandlerFirePHPHandler;

require '../vendor/autoload.php';
require '../config/conn.php';
require_once(DIR.'/vendor/autoload.php');

$app = new \Slim\App;

// require '../routes/testroute.php';
// require '../routes/auth.php';
require '../routes/cart.php';
// require '../routes/category.php';
// require '../routes/password.php';
// require '../routes/product.php';

$app->run();




$logger = new Logger('logger');
$logger->pushHandler(new StreamHandler(DIR.'/test_app.log', Logger::DEBUG));
$logger->pushHandler(new FirePHPHandler());
$logger->error('Logger is now Ready');

$logger->warning('Foo');
$logger->error('Bar');

