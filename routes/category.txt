$app->get('/category', function(Request $request, Response $response) {
	$category = $request->getParam('category');
	$sql = "SELECT * FROM category";
	

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
	
	$response->getBody()->write(json_encode($error));
	return $response
		->withHeader('content-type', 'application/json')
		->withStatus(500);
}
});

