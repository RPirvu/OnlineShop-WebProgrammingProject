<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$app->post('/addCategory/{name}', function(Request $request, Response $response, array $args){
	
    $log = new Logger('AdminRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('ADD Category request' . $args['name']);

    $db = new Database();
    $conn = $db->open();

    try{
		$db = new Database();
    	$conn = $db->open();

        $stmt = $conn->prepare("INSERT INTO category (name) VALUES (:name)");
        $stmt->execute(['name'=>$args['name']]);

        $response = "success";
		
		return $response;
		
} catch (PDOException $e){
	$error = array(
		"message" => $e->getMessage()
	);
	$log->error('ERROR: ADD Category');
	$response->getBody()->write(json_encode($error));
	return $response
		->withHeader('content-type', 'application/json')
		->withStatus(500);
}
});


$app->delete('/deleteCategory/{categoryID}', function(Request $request, Response $response, array $args){

    $log = new Logger('AdminRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('DELETE Category request' . $args['categoryID']);

    $db = new Database();
    $conn = $db->open();

    $id = $args['categoryID'];

    $sql = "DELETE FROM category WHERE id=$id";
    try{
		$db = new Database();
    	$conn = $db->open();

        $stmt = $conn->query($sql);
    
        $db->close();
        $response = "success";
		
		return $response;
		
} catch (PDOException $e){
	$error = array(
		"message" => $e->getMessage()
	);
	$log->error('ERROR: ADD Category');
	$response->getBody()->write(json_encode($error));
	return $response
		->withHeader('content-type', 'application/json')
		->withStatus(500);
}
});

$app->put('/updateCategory', function(Request $request, Response $response){
    $id = $request->getParam('categoryID'); 
    $name = $request->getParam('name'); 

    $log = new Logger('AdminRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('UPDATE Category request' . $id . 'TO' . $name);

    $sql = "UPDATE category SET name=$name WHERE id=$id";
    try{
		$db = new Database();
    	$conn = $db->open();

        $stmt = $conn->query($sql);
    
        $db->close();
        $response = "success";
		
		return $response;
		
} catch (PDOException $e){
	$error = array(
		"message" => $e->getMessage()
	);
	$log->error('ERROR: ADD Category');
	$response->getBody()->write(json_encode($error));
	return $response
		->withHeader('content-type', 'application/json')
		->withStatus(500);
}
});



// $app->post('/addProduct', function(Request $request, Response $response){

//     $db = new Database();
//     $conn = $db->open();

// $app->post('/deleteProduct/{productID}', function(Request $request, Response $response){ 

//     $db = new Database();
//     $conn = $db->open();   

// $app->post('/updateProduct/{productID}', function(Request $request, Response $response){

//     $db = new Database();
//     $conn = $db->open();

// $app->post('/getProducts', function(Request $request, Response $response){

//     $db = new Database();
//     $conn = $db->open();



// $app->post('/validateUser', function(Request $request, Response $response){

//     $db = new Database();
//     $conn = $db->open();

// $app->post('/addUser', function(Request $request, Response $response){

//     $db = new Database();
//     $conn = $db->open();

// $app->post('/updateUser', function(Request $request, Response $response){

//     $db = new Database();
//     $conn = $db->open();

// $app->post('/updatePhoto', function(Request $request, Response $response){

//     $db = new Database();
//     $conn = $db->open();









