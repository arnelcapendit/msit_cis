<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../core/initv2.php';
require '../vendor/autoload.php';
//header("Content-type: application/json");

$app = new \Slim\App;

// Get All Baptism list
$app->get('/baptism/lists', function(Request $request, Response $response){	
	//echo 'OK';
		
		$lists = DB::getInstance()->query("SELECT * from bapt_tbl");

		if(!$lists->error()){
			$jsonresponse = array();
			$jsonresponse['Success'] = true;
			$jsonresponse['Message'] = "Completed";

			try {
				$listrecords = array();
				$count = 0;

				if($lists->count()){
					foreach ($lists->results() as $list) {
						$listrecords[$count] = $list;
						$count = $count + 1;
					}
				}		
				
				$jsonresponse['Total'] = $count;
				$jsonresponse['Data'] = $listrecords;

				$json = json_encode($jsonresponse);
				echo $json;
				return $response->withHeader('Content-type', 'application/json');

			} catch (PDOException $e) {
				echo '{"error": {"text": '.$e->getMessage().' }';
			}
		} else {
			$jsonresponse['Success'] = false;
			$jsonresponse['Message'] = "Error Found";
			$jsonresponse['Total'] = 0;
			$jsonresponse['Data'] = "undefined";
			$json = json_encode($jsonresponse);
			echo $json;
			return $response->withHeader('Content-type', 'application/json');
		}


});

// Get Single Baptism list record
$app->get('/baptism/list/{id}', function(Request $request, Response $response){	
		$id = $request->getAttribute('id');
		
		$lists = DB::getInstance()->get('bapt_tbl', array('id', '=', $id));

		if(!$lists->error()){
			$jsonresponse = array();
			$jsonresponse['Success'] = true;
			$jsonresponse['Message'] = "Completed";

			try {
				$listrecords = array();
				$count = 0;

				if($lists->count()){
					foreach ($lists->results() as $list) {
						$listrecords[$count] = $list;
						$count = $count + 1;
					}
				}		
				
				$jsonresponse['Total'] = $count;
				$jsonresponse['Data'] = $listrecords;

				$json = json_encode($jsonresponse);
				echo $json;
				return $response->withHeader('Content-type', 'application/json');

			} catch (PDOException $e) {
				echo '{"error": {"text": '.$e->getMessage().' }';
			}
		} else {
			$jsonresponse['Success'] = false;
			$jsonresponse['Message'] = "Error Found";
			$jsonresponse['Total'] = 0;
			$jsonresponse['Data'] = "undefined";
			$json = json_encode($jsonresponse);
			echo $json;
			return $response->withHeader('Content-type', 'application/json');
		}


});

// Add Baptism List
$app->post('/baptism/lists/add', function(Request $request, Response $response){
	$date_of_baptismal = $request->getParam('date_of_baptismal');
	$name = $request->getParam('name');
	$parents = $request->getParam('parents');
	$date_of_birth = $request->getParam('date_of_birth');
	$birth_place = $request->getParam('birth_place');
	$sponsors = $request->getParam('sponsors');
	$name_of_minister = $request->getParam('name_of_minister');
	
		try{
			DB::getInstance()->insert('bapt_tbl', array(
			'date_of_baptismal' => $date_of_baptismal,
			'name' => $name,
			'parents' => $parents,
			'date_of_birth' => $date_of_birth,
			'birth_place' => $birth_place,
			'sponsors' => $sponsors,
			'name_of_minister' => $name_of_minister	
		));


			echo '{"notice": {"text":"New Record Added"}}';
			return $response->withHeader('Content-type', 'application/json');
		} catch(PDOException $e){
			echo '{"error": {"text": '.$e->getMessage().' }';
		}		
});


// Update Baptism List Record
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

//Deleting Record
$app->delete('/baptism/lists/delete/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	try{
		DB::getInstance()->delete('bapt_tbl', array('id', '=', $id));
		
		echo '{"notice": {"text":"Record Deleted"}}';
		return $response->withHeader('Content-type', 'application/json');
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().' }';
	}
});


$app->run();

