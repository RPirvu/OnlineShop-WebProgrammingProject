<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;


$app->get('/helo', function (Request $request, Response $reponse) {
    echo 'home user working';
});

<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;


$app->get('/hello', function (Request $request, Response $reponse) {
    echo 'home user working';
});

$app->post('/addCart', function(Request $request, Response $response){

	$userid = 		$request->getParam('id');
	$quantity = 	$request->getParam('quantity');
	$product_id = 	$request->getParam('product_id');

	$db = new Database();
    $conn = $db->open();

	$sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($userid, $product_id, $quantity)";

	$stmt = $conn->query($sql);

	$response = "success";

	return $response;

	});

$app->post("/foo", function ($request, $response) {
    $data = $request->getParams('product_id');
    print_r($data);
});
	




<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app->get('/friend/all', function(Request $request, Response $response) {
    $sql = "SELECT * FROM category";

    try {
        $db = new Database();
        $conn = $db->open();

        $stmt = $conn->query($sql);
        $friends = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db->close();
        $response->getBody()->write(json_encode($friends));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200); 
    } catch (PDOException $e){
        $error = array(
            "message" => $e->getMessage()
        );
        
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
    
});


$app->get('/friend/{id}', function(Request $request, Response $response, array $args) {
    
    $id = $args['id'];
    $sql = "SELECT * FROM category WHERE id = $id";

    try {
        $db = new Database();
        $conn = $db->open();

        $stmt = $conn->query($sql);
        $friends = $stmt->fetch(PDO::FETCH_OBJ);

        $db->close();
        $response->getBody()->write(json_encode($friends));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200); 
    } catch (PDOException $e){
        $error = array(
            "message" => $e->getMessage()
        );
        
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
    
});

	