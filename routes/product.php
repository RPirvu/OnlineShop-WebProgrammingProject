<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$app->get('/getProduct', function(Request $request, Response $response, array $args) {
    $id = $request->getParam('id');
    $sql = "SELECT *, products.name AS prodname, category.name AS catname, products.id AS prodid FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id = :id";
    
    $log = new Logger('ProductRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('GET product request');

    
    try {
            $db = new Database();
            $conn = $db->open();
        
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id' => $id ]);

            $allcart = $stmt->fetchAll(PDO::FETCH_OBJ);
            $response->getBody()->write(json_encode($allcart));
        
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200); 
        } catch (PDOException $e){
            $error = array(
                "message" => $e->getMessage()
            );
            $log->error('ERROR: getProduct/{id}');
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
   
});

