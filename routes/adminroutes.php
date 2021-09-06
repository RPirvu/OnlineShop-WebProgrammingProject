<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$app->post('/addCategory/{name}', function(Request $request, Response $response, array $args){
	
    $log = new Logger('AdminCategoryRoute');
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

    $log = new Logger('AdminCategoryRoute');
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

    $log = new Logger('AdminCategoryRoute');
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



$app->post('/addProduct/{name}', function(Request $request, Response $response, array $args){
    $log = new Logger('AdminProductRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('ADD Product request' . $args['name']);

    $db = new Database();
    $conn = $db->open();

    try{
		$db = new Database();
    	$conn = $db->open();

        $stmt = $conn->prepare("INSERT INTO products 
			   (category_id, name, description, slug, price, photo) 
		VALUES (:category, :name, :description, :slug, :price, :photo)");
        $stmt->execute(['name'=>$args['name']]);

        $response = "success";
		
		return $response;
		
} catch (PDOException $e){
	$error = array(
		"message" => $e->getMessage()
	);
	$log->error('ERROR: ADD Product');
	$response->getBody()->write(json_encode($error));
	return $response
		->withHeader('content-type', 'application/json')
		->withStatus(500);
}
});


$app->delete('/deleteProduct/{productID}', function(Request $request, Response $response, array $args){ 
    $log = new Logger('AdminProductRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('DELETE Product request' . $args['productID']);

    $db = new Database();
    $conn = $db->open();

    $id = $args['productID'];

    $sql = "DELETE FROM products WHERE id=$id";
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

$app->put('/updateProduct/{productID}{name}', function(Request $request, Response $response, array $args){
    
 
    $log = new Logger('AdminProductRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('UPDATE Product request' . $args['productID'] . 'TO' . $args['name']);

	$name = $args['name'];
	$id = $args['productID'];

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


$app->get('/getProducts', function(Request $request, Response $response){
    $log = new Logger('AdminProductRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('GET Products request');

    $sql = "SELECT * FROM products";
    try{
		$db = new Database();
    	$conn = $db->open();

        $stmt = $conn->query($sql);
    
		$cat = $stmt->fetchAll();
		$db->close();

		$response->getBody()->write(json_encode($cat));
		return $response
			->withHeader('content-type', 'application/json')
			->withStatus(200);
		
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




$app->put('/validateUser/{id}', function(Request $request, Response $response, array $args){
    $log = new Logger('AdminUserControlRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('Validate User' . $args['id'] . 'Request' );

	$id = $args['id'];
	$status = 1;

    $sql = "UPDATE users SET status=$status WHERE id=:id";

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
	$log->error('ERROR: Validating User' . $args['id'] );
	$response->getBody()->write(json_encode($error));
	return $response
		->withHeader('content-type', 'application/json')
		->withStatus(500);
}
});

// $stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, address, contact_info, photo, status, created_on) VALUES (:email, :password, :firstname, :lastname, :address, :contact, :photo, :status, :created_on)");
			
$app->post('/addUser', function(Request $request, Response $response){

	$email = $request->getParam('email'); 
	$password = $request->getParam('password'); 
	$firstname = $request->getParam('firstname'); 
	$lastname = $request->getParam('lastname'); 
	$address = $request->getParam('address'); 
	$contact_info = $request->getParam('contact_info'); 
	$photo = $request->getParam('photo'); 
	$status = $request->getParam('status'); 
	$created_on = $request->getParam('created_on'); 

    $log = new Logger('AdminUserControlRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('ADD User ' . $email . ' request' );

    $db = new Database();
    $conn = $db->open();

    try{
		$db = new Database();
    	$conn = $db->open();

        $stmt = $conn->prepare("INSERT INTO products 
			   (category_id, name, description, slug, price, photo) 
		VALUES ($category, $name, $description, $slug, $price, $photo)");

        $response = "success";
		
		return $response;
		
} catch (PDOException $e){
	$error = array(
		"message" => $e->getMessage()
	);
	$log->error('ERROR: ADD Product');
	$response->getBody()->write(json_encode($error));
	return $response
		->withHeader('content-type', 'application/json')
		->withStatus(500);
}
});

$app->post('/updateUser', function(Request $request, Response $response){
	$id = $request->getParam('id');
	$email = $request->getParam('email'); 
	$password = $request->getParam('password'); 
	$firstname = $request->getParam('firstname'); 
	$lastname = $request->getParam('lastname'); 
	$address = $request->getParam('address'); 
	$contact_info = $request->getParam('contact_info'); 
	$photo = $request->getParam('photo'); 
	$status = $request->getParam('status'); 
	$created_on = $request->getParam('created_on'); 

    $log = new Logger('AdminUserControlRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('UPDATE User ' . $email . ' request' );

    $db = new Database();
    $conn = $db->open();

    try{
		$db = new Database();
    	$conn = $db->open();

        $stmt = $conn->prepare("UPDATE users 
		SET email=$email, password=$password, firstname=$firstname, lastname=$lastname, address=$address, contact_info=$contact 
		WHERE id=$id");

        $response = "success";
		
		return $response;
		
} catch (PDOException $e){
	$error = array(
		"message" => $e->getMessage()
	);
	$log->error('ERROR: ADD Product');
	$response->getBody()->write(json_encode($error));
	return $response
		->withHeader('content-type', 'application/json')
		->withStatus(500);
}
});


$app->delete('/deleteUser', function(Request $request, Response $response){
    $id = $args['id'];
	
	$log = new Logger('AdminUserControlRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('DELETE User ' . $args['id'] .' request' );

    $db = new Database();
    $conn = $db->open();

    $sql = "DELETE FROM users WHERE id=:id";
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
	$log->error('ERROR: Delete User ' . $id);
	$response->getBody()->write(json_encode($error));
	return $response
		->withHeader('content-type', 'application/json')
		->withStatus(500);
}
});









