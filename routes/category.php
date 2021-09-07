<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * @OA\Info(title="Proiect PW", version="1.0")
 */

/**
 * @OA\Get(
 *     path="/category", tags={"TEST"},
 *      description="Category",
 *     @OA\Response(response="200", description="Success"), 
 *     @OA\Response(response="404", description="Not Found")
 * )
 */
$app->get('/cat', function(Request $request, Response $response) {
	$category = $request->getParam('category');
	$sql = "SELECT * FROM category";
	$log = new Logger('CategoryRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('GET Category request');

	try{
		$db = new Database();
    	$conn = $db->open();

		$stmt = $conn->query($sql);

		$cat = $stmt->fetchAll();
	

		$response->getBody()->write(json_encode($cat));
		return $response
			->withHeader('content-type', 'application/json')
			->withStatus(200); 
} catch (PDOException $e){
	$error = array(
		"message" => $e->getMessage()
	);
	$log->error('ERROR: GET Category');
	$response->getBody()->write(json_encode($error));
	return $response
		->withHeader('content-type', 'application/json')
		->withStatus(500);
}
});

