<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../config/conn.php';

$app = new \Slim\App;

require '../routes/testroute.php';
require '../routes/test1.php';
require '../routes/cartroutes.php';

$app->run();



