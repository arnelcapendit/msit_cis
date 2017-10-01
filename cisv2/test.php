<?php


//use \Psr\Http\Message\ServerRequestInterface as Request;
//use \Psr\Http\Message\ResponseInterface as Response;

//require 'vendor/autoload.php';

require_once 'core/init.php';

//$app = new \Slim\App;
//$app->get('/hello/{name}', function (Request $request, Response $response) {
  //  $name = $request->getAttribute('name');
    ///$response->getBody()->write("Hello, $name");

    //return $response;
//});

// Customer Routes
//require 'routes/baptism.php';

require 'vendor/autoload.php';

$app = new \Slim\App;

$app->put('/baptism/lists/update/{id}', function(Request $request, Response $response){ 
	$id = $request->getAttribute('id');
	$date_of_baptismal = $request->getParam('date_of_baptismal');
	$name = $request->getParam('name');
	$parents = $request->getParam('parents');
	$date_of_birth = $request->getParam('date_of_birth');
	$birth_place = $request->getParam('birth_place');
	$sponsors = $request->getParam('sponsors');
	$name_of_minister = $request->getParam('name_of_minister');
	
		try{
			DB::getInstance()->update('bapt_tbl', $id, array(
			'date_of_baptismal' => $date_of_baptismal,
			'name' => $name,
			'parents' => $parents,
			'date_of_birth' => $date_of_birth,
			'birth_place' => $birth_place,
			'sponsors' => $sponsors,
			'name_of_minister' => $name_of_minister	
		));

			echo '{"notice": {"text":"Record Updated"}}';
			return $response->withHeader('Content-type', 'application/json');

		} catch(PDOException $e){
			echo '{"error": {"text": '.$e->getMessage().' }';
		}		
});

$app->run();


	

?>