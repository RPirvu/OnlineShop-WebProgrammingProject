<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require '../vendor/autoload.php';
require '../config/conn.php';

$app = new \Slim\App;

// use Monolog\Logger;
// use Monolog\Handler\StreamHandler;

// // create a log channel
// $log = new Logger('name');
// $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));

// // add records to the log
// $log->warning('AAA');
// $log->error('Bar');

require '../routes/adminroutes.php';
// require '../routes/testroute.php';
// require '../routes/auth.php';
require '../routes/cart.php';
require '../routes/category.php';
// require '../routes/password.php';
require '../routes/product.php';

$app->run();





