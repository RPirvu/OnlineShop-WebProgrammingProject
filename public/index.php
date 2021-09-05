<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../config/conn.php';

$app = new \Slim\App;

// require '../routes/testroute.php';
// require '../routes/auth.php';
require '../routes/cart.php';
// require '../routes/category.php';
// require '../routes/password.php';
// require '../routes/product.php';

$app->run();



