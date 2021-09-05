<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

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

$app->delete('/deleteCart', function(Request $request, Response $response){

    $userid = 		$request->getParam('id');
	$quantity = 	$request->getParam('quantity');
	$product_id = 	$request->getParam('product_id');

	$sql = "DELETE FROM cart WHERE user_id=$userid AND product_id=$product_id";

	try {
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
        
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
    
});

$app->get('/detailsCart', function(Request $request, Response $response){

	$userid = $request->getParam('id');

	$sql = "SELECT product_id FROM cart WHERE user_id=$userid";

	try {
        $db = new Database();
        $conn = $db->open();

        $stmt = $conn->query($sql);
		$cartdetails = $stmt->fetchAll(PDO::FETCH_OBJ);
        $response->getBody()->write(json_encode($cartdetails));

		// foreach($aux as $details) {
		// 	$stmt = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id=cart.product_id AND products.id=$details WHERE user_id=:user");
		// 	$stmt->execute(['user'=>$userid]);

		// 	$produs = $stmt->fetch(PDO::FETCHOBJ);

		// 	$response->getBody()->write(json_encode($produs));
			
		// }
    

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

// $app->get('/allCart', function(Request $request, Response $response){
	// $sql = "SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id LEFT JOIN category ON category.id=products.category_id WHERE user_id=:$userid";
// });

$app->get('/totalCart', function(Request $request, Response $response){ 

	$userid = $request->getParam('id');

	$sql = "SELECT * FROM cart LEFT JOIN products on products.id=cart.product_id WHERE user_id=$userid";
	
	try {
        $db = new Database();
        $conn = $db->open();

        $stmt = $conn->query($sql);
		$allcart = $stmt->fetchAll(PDO::FETCH_OBJ);
        $response->getBody()->write(json_encode($allcart));

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




$app->put('/updateCart', function(Request $request, Response $response){


	$userid = $request->getParam('id');
	$quantity = $request->getParam('quantity');


	try {
        $db = new Database();
        $conn = $db->open();

		$stmt = $conn->prepare("UPDATE cart SET quantity=:quantity WHERE id=:id");
		$stmt->execute(['quantity'=>$quantity, 'id'=>$userid]);
		
        $response = "success";

        return $response;
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





	





	