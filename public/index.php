<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use function OpenApi\scan;

/**
 * @OA\Info(title="Proiect PW", version="1.0")
*/

require '../vendor/autoload.php';
require '../config/conn.php';

$app = new \Slim\App;

/***********************************************************************************************************************/
/*                                                  OpenAPI & Test                                                     */
/***********************************************************************************************************************/

/**
    * @OA\Get(
    *     path="/ProiectPW/public/index.php/openapi",
    *     tags={"OpenAPI - Documentation"},
    *     summary="OpenAPI JSON File that describes the API",
    *     @OA\Response(response="200", description="OpenAPI Description File"),
    * )
    */
$app->get('/openapi', function ($request, $response, $args) {
   $swagger = scan('../public');
   $response->getBody()->write(json_encode($swagger));
   return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Get(
 *     path="/ProiectPW/public/index.php/", tags={"Test - Route"},
 *     description="Home page",
 *     summary="First Route - Test Route",
 *     @OA\Response(response="default", description="Welcome page")
 * )
 */
$app->get('/', function(Request $request, Response $response) {
	echo "Hi";
    $response = "Home Page";
	return $response;
});

/***********************************************************************************************************************/
/*                                                     USER ROUTES                                                     */
/***********************************************************************************************************************/
 
/**
 * @OA\Get( path="/ProiectPW/public/index.php/getProducts", tags={"User - Routes"},
    *      description="Get all products",
    *     @OA\Response(response="200", description="Success"), 
    *     @OA\Response(response="404", description="Not Found")
    * )
 */
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
		// $db->close();

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

/**
 * @OA\Get( path="/ProiectPW/public/index.php/getProduct", tags={"User - Routes"},
    *      description="Get a Product's informations",
    *     @OA\Parameter(
    *         description="Product ID",
    *         in="query",
    *         name="ProductID",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         ),
    *         @OA\Examples(example="int", value="31", summary="Laptop - Acer Nitro"),
    *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */
$app->get('/getProduct', function(Request $request, Response $response, array $args) {
    $id = $request->getParam('ProductID');
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

/**
 * @OA\Post( path="/ProiectPW/public/index.php/addCart", tags={"User - Routes"},
    *      description="Add Product to Cart",
    *     @OA\Parameter(
    *         description="User ID",
    *         in="query",
    *         name="UserID",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         ),
    *         @OA\Examples(example="int", value="14", summary="Test User"),
    *     ),
    *     @OA\Parameter(
    *         description="Product ID",
    *         in="query",
    *         name="ProductID",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         ),
    *         @OA\Examples(example="int", value="31", summary="Laptop - Acer Nitro"),
    *     ),
    *     @OA\Parameter(
    *         description="Quantity",
    *         in="query",
    *         name="quantity",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         ),
    *         @OA\Examples(example="int", value="5", summary="int val"),
    *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */
$app->post('/addCart', function(Request $request, Response $response){
    $log = new Logger('CartRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('POST AddCart request');

	$userid = 		$request->getParam('UserID');
	$quantity = 	$request->getParam('quantity');
	$product_id = 	$request->getParam('ProductID');

	$sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($userid, $product_id, $quantity)";

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
        $log->error('ERROR: AddCart');
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }

});

/**
 * @OA\Delete( path="/ProiectPW/public/index.php/deleteCart", tags={"User - Routes"},
    *      description="Delete Product from Cart",
    *     @OA\Parameter(
    *         description="User ID",
    *         in="query",
    *         name="UserID",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         ),
    *         @OA\Examples(example="int", value="14", summary="Test User"),
    *     ),
    *     @OA\Parameter(
    *         description="Product ID",
    *         in="query",
    *         name="ProductID",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         ),
    *         @OA\Examples(example="int", value="31", summary="Laptop - Acer Nitro"),
    *     ),
    *     @OA\Parameter(
    *         description="Quantity",
    *         in="query",
    *         name="quantity",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         ),
    *         @OA\Examples(example="int", value="1", summary="Decrease by 1"),
    *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */
$app->delete('/deleteCart', function(Request $request, Response $response){
    $log = new Logger('CartRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('DELETE DeleteCart request');

    $userid = 		$request->getParam('UserID');
	$quantity = 	$request->getParam('quantity');
	$product_id = 	$request->getParam('ProductID');

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
        $log->error('ERROR: DeleteCart');
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
    
});

/**
 * @OA\Put( path="/ProiectPW/public/index.php/updateCart", tags={"User - Routes"},
    *      description="Update Quantity of a Product",
    *     @OA\Parameter(
    *         description="Cart ID",
    *         in="query",
    *         name="CartID",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         ),
    *         @OA\Examples(example="int", value="1000", summary="Test Cart "),
    *     ),
    *     @OA\Parameter(
    *         description="Quantity",
    *         in="query",
    *         name="quantity",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         ),
    *         @OA\Examples(example="int", value="50", summary="int value"),
    *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */
$app->put('/updateCart', function(Request $request, Response $response){
    $log = new Logger('CartRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('UPDATE UpdateCart request');


	$cartid = $request->getParam('CartID');
	$quantity = $request->getParam('quantity');


	try {
        $db = new Database();
        $conn = $db->open();

		$stmt = $conn->prepare("UPDATE cart SET quantity=:quantity WHERE id=:id");
		$stmt->execute(['quantity'=>$quantity, 'id'=>$cartid]);
		
        $response = "success";

        return $response;
    } catch (PDOException $e){
        $error = array(
            "message" => $e->getMessage()
        );
        $log->error('ERROR: UpdateCart');
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
    
});

/**
 * @OA\Get( path="/ProiectPW/public/index.php/totalCart", tags={"User - Routes"},
    *      description="All Products in a User's Cart",
    *     @OA\Parameter(
    *         description="User ID",
    *         in="query",
    *         name="id",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         ),
    *        @OA\Examples(example="int", value="14", summary="Test User"),
    *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */
$app->get('/totalCart', function(Request $request, Response $response){ 
    $log = new Logger('CartRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('GET TotalCart request');

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
        $log->error('ERROR: TotalCart');
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
    
});

/**
 * @OA\Get( path="/ProiectPW/public/index.php/category", tags={"User - Routes"},
    *      description="Get All Categories",
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */
$app->get('/category', function(Request $request, Response $response) {
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


/***********************************************************************************************************************/
/*                                                    ADMIN ROUTES                                                     */
/***********************************************************************************************************************/

                //CATEGORY MANAGEMENT
/**
 * @OA\Post( path="/ProiectPW/public/index.php/addCategory", tags={"Admin - Routes[Category Management]"},
    *      description="Add a new Category",
    *     @OA\Parameter(
    *         description="Category Name",
    *         in="query",
    *         name="name",
    *         required=true,
    *         @OA\Schema(
    *           type="string",
    *         ),
    *        @OA\Examples(example="string", value="Test Category", summary="Dummy Category"),
    *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */
$app->post('/addCategory', function(Request $request, Response $response){
	
    $name = $request->getParam('name');

    $log = new Logger('AdminCategoryRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('ADD Category request' . $name);

    try{
        $db = new Database();
        $conn = $db->open();

        $stmt = $conn->prepare("INSERT INTO category (name) VALUES (:name)");
        $stmt->execute(['name'=>$name]);

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

/**
 * @OA\Delete( path="/ProiectPW/public/index.php/deleteCategory", tags={"Admin - Routes[Category Management]"},
    *      description="Delete Category",
    *     @OA\Parameter(
    *         description="Category ID",
    *         in="query",
    *         name="id",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         ),
    *        @OA\Examples(example="string", value="13", summary="Dummy Category"),
    *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */
$app->delete('/deleteCategory', function(Request $request, Response $response){
    $id = $request->getParam('id');

    $log = new Logger('AdminCategoryRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('DELETE Category request' . $id);

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

/**
 * @OA\Put( path="/ProiectPW/public/index.php/updateCategory", tags={"Admin - Routes[Category Management]"},
    *      description="Rename a Category",
    *     @OA\Parameter(
    *         description="Category ID",
    *         in="query",
    *         name="CategoryID",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *         ),
    *        @OA\Examples(example="string", value="14", summary="Dummy Category"),
    *     ),
    *     @OA\Parameter(
    *         description="Category Name",
    *         in="query",
    *         name="CategoryNAME",
    *         required=true,
    *         @OA\Schema(
    *           type="string",
    *         ),
    *        @OA\Examples(example="string", value="Test", summary="Dummy Category"),
    *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */
$app->put('/updateCategory', function(Request $request, Response $response){

    $id = $request->getParam('CategoryID'); 
    $name = $request->getParam('CategoryNAME'); 

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

                //PRODUCT MANAGEMENT

/**
 * @OA\Post( path="/ProiectPW/public/index.php/addProduct", tags={"Admin - Routes[Product Management]"},
    *      description="Add a new Product",
    *     @OA\Parameter(
        *         description="Category ID",
        *         in="query",
        *         name="CategoryID",
        *         required=true,
        *         @OA\Schema(
        *           type="integer",
        *         ),
        *        @OA\Examples(example="integer", value="2", summary="Desktop / Dummy Category"),
        *    ),
    *     @OA\Parameter(
        *         description="Product Name",
        *         in="query",
        *         name="ProductNAME",
        *         required=true,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="TestProduct", summary="Dummy Product Name"),
        *     ),
    *     @OA\Parameter(
        *         description="Product Description",
        *         in="query",
        *         name="ProductDESCRIPTION",
        *         required=true,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="A DUMMY DESCRIPTION FOR A DUMMY PRODUCT", summary="Dummy Product Description"),
        *     ),
    *     @OA\Parameter(
        *         description="Product Slug[lowercase and replace white spaces with '-' ]",
        *         in="query",
        *         name="ProductSLUG",
        *         required=true,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="dummy-product", summary="slug for faster searching"),
        *     ),
    *      @OA\Parameter(
        *         description="Product Price",
        *         in="query",
        *         name="ProductPRICE",
        *         required=true,
        *         @OA\Schema(
        *           type="integer",
        *         ),
        *        @OA\Examples(example="integer", value="10", summary="Dummy Price"),
        *     ),
    *      @OA\Parameter(
        *         description="Product Photo [Thumbnail]",
        *         in="query",
        *         name="ProductPHOTO",
        *         required=true,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="noimage.jpg", summary="Dummy Photo"),
    *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */
$app->post('/addProduct', function(Request $request, Response $response){

    $catID = $request->getParam('CategoryID'); 
    $name = $request->getParam('ProductNAME'); 
    $description = $request->getParam('ProductDESCRIPTION'); 
    $slug = $request->getParam('ProductSLUG');
    $price = $request->getParam('ProductPRICE');  
    $photo = $request->getParam('ProductPHOTO'); 

    $log = new Logger('AdminProductRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('ADD Product ' . $name ." into Category " .$catID);

    try{
		$db = new Database();
    	$conn = $db->open();

        $stmt = $conn->prepare("INSERT INTO products 
			   (category_id, name, description, slug, price, photo) 
		VALUES (:catID, :name, :description, :slug, :price, :photo)");

        $stmt->execute(['catID'=>$catID,'name'=>$name,'description'=>$description,'slug'=>$slug,'price'=>$price,'photo'=>$photo,]);
    
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

/**
 * @OA\Delete( path="/ProiectPW/public/index.php/deleteProduct", tags={"Admin - Routes[Product Management]"},
    *      description="Delete Product",
    *     @OA\Parameter(
    *         description="Product ID",
    *         in="query",
    *         name="ProductID",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         ),
    *        @OA\Examples(example="string", value="51", summary="Dummy Product ID"),
    *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */
$app->delete('/deleteProduct', function(Request $request, Response $response){ 
    $productID = $request->getParam('ProductID');
    
    $log = new Logger('AdminProductRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('DELETE Product request' . $productID);

    $sql = "DELETE FROM products WHERE id=$productID";
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

/**
 * @OA\Put( path="/ProiectPW/public/index.php/updateProduct", tags={"Admin - Routes[Product Management]"},
    *      description="Update a product's name",
    *     @OA\Parameter(
    *         description="Product ID",
    *         in="query",
    *         name="ProductID",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *         ),
    *        @OA\Examples(example="string", value="50", summary="Dummy Product ID"),
    *     ),
    *     @OA\Parameter(
    *         description="Product Name",
    *         in="query",
    *         name="ProductNAME",
    *         required=true,
    *         @OA\Schema(
    *           type="string",
    *         ),
    *        @OA\Examples(example="string", value="Toscido 11", summary="Dummy Product new Name"),
    *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */
$app->put('/updateProduct', function(Request $request, Response $response){

    $id = $request->getParam('ProductID'); 
    $name = $request->getParam('ProductNAME'); 

    $log = new Logger('AdminCategoryRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('UPDATE Category request' . $id . 'TO' . $name);

    $sql = "UPDATE products SET name=$name WHERE id=$id";
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

                //USER MANAGEMENT

/**
 * @OA\Put( path="/ProiectPW/public/index.php/validateUser", tags={"Admin - Routes[User Management]"},
    *      description="Force-Validate a User",
    *     @OA\Parameter(
    *         description="User ID",
    *         in="query",
    *         name="UserID",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *         ),
    *        @OA\Examples(example="string", value="15", summary="User"),
    *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 */                
$app->put('/validateUser', function(Request $request, Response $response){
    $id = $request->getParam('UserID');
    
    $log = new Logger('AdminUserControlRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('Validate User' . $id . 'Request' );

	$status = 1;

    $sql = "UPDATE users SET status=$status WHERE id=:id";

    try{
		$db = new Database();
    	$conn = $db->open();

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
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
/**
 * @OA\Post( path="/ProiectPW/public/index.php/addUser", tags={"Admin - Routes[User Management]"},
    *      description="Add New User",
    *     @OA\Parameter(
        *         description="Email",
        *         in="query",
        *         name="UserEmail",
        *         required=true,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="test.test@test.com", summary="Dummy Email"),
        *    ),
    *     @OA\Parameter(
        *         description="Type [0 - Normal/ 1 - Admin]",
        *         in="query",
        *         name="UserType",
        *         required=true,
        *         @OA\Schema(
        *           type="integer",
        *         ),
        *        @OA\Examples(example="integer", value="0", summary="Normal User")
        *     ),
    *     @OA\Parameter(
        *         description="Password",
        *         in="query",
        *         name="UserPassword",
        *         required=true,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="password", summary="Dummy Password"),
        *     ),
    *     @OA\Parameter(
        *         description="User First Name",
        *         in="query",
        *         name="UserFName",
        *         required=true,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="Test", value="Test", summary="Dummy's First Name"),
        *     ),
    *     @OA\Parameter(
        *         description="User First Name",
        *         in="query",
        *         name="UserLName",
        *         required=true,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="Test", value="Dummy", summary="Dummy's Last Name"),
        *     ),
    *     @OA\Parameter(
        *         description="Adress[City, Country, Street...",
        *         in="query",
        *         name="UserAdress",
        *         required=true,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="integer", value="Test City, Dummy Country, Street 12", summary="Dummy Adress"),
        *     ),
    *     @OA\Parameter(
        *         description="User's Phone Number",
        *         in="query",
        *         name="UserContact",
        *         required=true,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="021345678", summary="Dummy Phone Number"),
        *     ),
    *     @OA\Parameter(
        *         description="User's Photo",
        *         in="query",
        *         name="UserPhoto",
        *         required=false,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="noimage.jpg", summary=""),
        *     ),
    *     @OA\Parameter(
        *         description="User's Status [0 - Not Verified | 1 - Verified]",
        *         in="query",
        *         name="UserStatus",
        *         required=true,
        *         @OA\Schema(
        *           type="integer",
        *         ),
        *        @OA\Examples(example="integer", value="0", summary="Not Verified User"),
        *     ),
    *     @OA\Parameter(
        *         description="Product Photo",
        *         in="query",
        *         name="UserCreatedON",
        *         required=true,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="2021-01-01", summary="Dummy Category"),
        *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
**/
$app->post('/addUser', function(Request $request, Response $response){

	$email = $request->getParam('UserEmail'); 
	$password = $request->getParam('UserPassword'); 
    $type = $request->getParam('UserType'); 
	$firstname = $request->getParam('UserFName'); 
	$lastname = $request->getParam('UserLName'); 
	$address = $request->getParam('UserAdress'); 
	$contact_info = $request->getParam('UserContact'); 
	$photo = $request->getParam('UserPhoto'); 
	$status = $request->getParam('UserStatus'); 
    // $activate_code = $request->getParam('UserActivateCode'); 
    // $reset_code = $request->getParam('UserResetCode'); 
	$created_on = $request->getParam('UserCreatedON'); 

    $log = new Logger('AdminUserControlRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('ADD User ' . $email . ' request' );

    $db = new Database();
    $conn = $db->open();

    try{
		$db = new Database();
    	$conn = $db->open();

        $stmt = $conn->prepare("INSERT INTO users 
			   (email, password, type, firstname, lastname, address, contact_info, photo, status, created_on) 
		VALUES (:email, :password, :type, :firstname, :lastname, :address, :contact_info, :photo, :status, :created_on)");


        $stmt->execute(['email'=>$email,'password'=>$password,'type'=>$type,'firstname'=>$firstname,'lastname'=>$lastname,'address'=>$address,'contact_info'=>$contact_info,'photo'=>$photo,'status'=>$status,'created_on'=>$created_on,]);
        
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

/**
 * @OA\Put( path="/ProiectPW/public/index.php/updateUser", tags={"Admin - Routes[User Management]"},
    *      description="Update User's Details",
    *     @OA\Parameter(
        *         description="User's ID",
        *         in="query",
        *         name="UserID",
        *         required=true,
        *         @OA\Schema(
        *           type="integer",
        *         ),
        *        @OA\Examples(example="integer", value="12", summary="Test ID"),
        *    ),
    *     @OA\Parameter(
        *         description="New Email",
        *         in="query",
        *         name="UserEmail",
        *         required=false,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="testtest@gmail.com", summary="Dummy Data"),
        *    ),
    *     @OA\Parameter(
        *         description="New User's Type",
        *         in="query",
        *         name="UserType",
        *         required=false,
        *         @OA\Schema(
        *           type="integer",
        *         ),
        *        @OA\Examples(example="integer", value="1", summary="Dummy Data"),
        *     ),
    *     @OA\Parameter(
        *         description="Password",
        *         in="query",
        *         name="UserPassword",
        *         required=false,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="password", summary="Dummy Data"),
        *     ),
    *     @OA\Parameter(
        *         description="New User First Name",
        *         in="query",
        *         name="UserFName",
        *         required=false,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="Test", value="NewUser", summary="Dummy Data"),
        *     ),
    *     @OA\Parameter(
        *         description="New User Last Name",
        *         in="query",
        *         name="UserLName",
        *         required=false,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="Test", value="Test", summary="Dummy Data"),
        *     ),
    *     @OA\Parameter(
        *         description="New User Address",
        *         in="query",
        *         name="UserAdress",
        *         required=false,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="New Street", summary="Dummy Data"),
        *     ),
    *     @OA\Parameter(
        *         description="New Phone Number",
        *         in="query",
        *         name="UserContact",
        *         required=false,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="1234567890", summary="Dummy Data"),
        *     ),
    *     @OA\Parameter(
        *         description="New Photo",
        *         in="query",
        *         name="UserPhoto",
        *         required=false,
        *         @OA\Schema(
        *           type="string",
        *         ),
        *        @OA\Examples(example="string", value="noimage.jpg", summary="Dummy Category"),
        *     ),
    *     @OA\Parameter(
        *         description="New Status [0 - Not Verified | 1 - Verified]",
        *         in="query",
        *         name="UserStatus",
        *         required=true,
        *         @OA\Schema(
        *           type="integer",
        *         ),
        *        @OA\Examples(example="integer", value="1", summary="Dummy Data"),
        *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
 **/
$app->put('/updateUser', function(Request $request, Response $response){
    $id = $request->getParam('UserID'); 
	$email = $request->getParam('UserEmail'); 
	$password = $request->getParam('UserPassword'); 
    $type = $request->getParam('UserType'); 
	$firstname = $request->getParam('UserFName'); 
	$lastname = $request->getParam('UserLName'); 
	$address = $request->getParam('UserAdress'); 
	$contact_info = $request->getParam('UserContact'); 
	$photo = $request->getParam('UserPhoto'); 
	$status = $request->getParam('UserStatus'); 

    $log = new Logger('AdminUserControlRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('UPDATE User ' . $email . ' request' );

    $db = new Database();
    $conn = $db->open();

    try{
		$db = new Database();
    	$conn = $db->open();

        $stmt = $conn->prepare("UPDATE users 
		SET email=:email, password=:password, firstname=:firstname, lastname=:lastname, address=:address, contact_info=:contact_info, photo=:photo, type=:type, status=:status
		WHERE id=:id");

        $stmt->execute(['email'=>$email,'password'=>$password,'type'=>$type,'firstname'=>$firstname,'lastname'=>$lastname,'address'=>$address,'contact_info'=>$contact_info,'photo'=>$photo,'status'=>$status, 'id'=>$id]);
        
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

/**
* @OA\Delete( path="/ProiectPW/public/index.php/deleteUser", tags={"Admin - Routes[User Management]"},
    *      description="Delete User",
    *     @OA\Parameter(
        *         description="User ID",
        *         in="query",
        *         name="UserID",
        *         required=true,
        *         @OA\Schema(
        *           type="integer",
        *           format="int64"
        *         ),
        *        @OA\Examples(example="string", value="51", summary="Dummy Data"),
        *     ),
    *@OA\Response(response="200", description="Success"), 
    *@OA\Response(response="404", description="Not Found")
    * )
*/
$app->delete('/deleteUser', function(Request $request, Response $response){
    $id = $request->getParam('UserID');
	
	$log = new Logger('AdminUserControlRoute');
    $log->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));
    $log->info('DELETE User ' . $id .' request' );

    $db = new Database();
    $conn = $db->open();

    $sql = "DELETE FROM users WHERE id=$id";
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
$app->run();





