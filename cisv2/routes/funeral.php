<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../core/initv2.php';
require '../vendor/autoload.php';
//header("Content-type: application/json");

$app = new \Slim\App;

// Get All Funeral list
$app->get('/funeral/lists', function(Request $request, Response $response){	
	//echo 'OK';
		
		$lists = DB::getInstance()->query("SELECT * from funeral");

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

// Get Single Funeral list record
$app->get('/funeral/list/{id}', function(Request $request, Response $response){	
		$id = $request->getAttribute('id');
		
		$lists = DB::getInstance()->get('funeral', array('id', '=', $id));

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

// Add Funeral List
$app->post('/funeral/lists/add', function(Request $request, Response $response){
	$name_of_deceased = $request->getParam('name_of_deceased');
	$date_of_death = $request->getParam('date_of_death');
	$date_of_burial = $request->getParam('date_of_burial');
	$age = $request->getParam('age');
	$status = $request->getParam('status');
	$guardian = $request->getParam('guardian');
	$residence = $request->getParam('residence');
	$sacrament = $request->getParam('sacrament');
	$cause_of_death = $request->getParam('cause_of_death');
	$place_of_interment = $request->getParam('place_of_interment');
	$name_of_minister = $request->getParam('name_of_minister');
	
	
		try{
			DB::getInstance()->insert('funeral', array(
			'name_of_deceased' => $name_of_deceased,
			'date_of_death' => $date_of_death,
			'date_of_burial' => $date_of_burial,
			'age' => $age,
			'status' => $status,
			'guardian' => $guardian,
			'residence' => $residence,
			'sacrament' => $sacrament,
			'cause_of_death' => $cause_of_death,
			'place_of_interment' => $place_of_interment,
			'name_of_minister' => $name_of_minister	
		));
			echo '{"notice": {"text":"New Record Added"}}';
			return $response->withHeader('Content-type', 'application/json');
		} catch(PDOException $e){
			echo '{"error": {"text": '.$e->getMessage().' }';
		}		
});


// Update Funeral List Record
$app->put('/funeral/lists/update/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$name_of_deceased = $request->getParam('name_of_deceased');
	$date_of_death = $request->getParam('date_of_death');
	$date_of_burial = $request->getParam('date_of_burial');
	$age = $request->getParam('age');
	$status = $request->getParam('status');
	$guardian = $request->getParam('guardian');
	$residence = $request->getParam('residence');
	$sacrament = $request->getParam('sacrament');
	$cause_of_death = $request->getParam('cause_of_death');
	$place_of_interment = $request->getParam('place_of_interment');
	$name_of_minister = $request->getParam('name_of_minister');

		try{
			DB::getInstance()->update('funeral', $id, array(
			'name_of_deceased' => $name_of_deceased,
			'date_of_death' => $date_of_death,
			'date_of_burial' => $date_of_burial,
			'age' => $age,
			'status' => $status,
			'guardian' => $guardian,
			'residence' => $residence,
			'sacrament' => $sacrament,
			'cause_of_death' => $cause_of_death,
			'place_of_interment' => $place_of_interment,
			'name_of_minister' => $name_of_minister	
		));
			echo '{"notice": {"text":"Record Updated"}}';
			return $response->withHeader('Content-type', 'application/json');

		} catch(PDOException $e){
			echo '{"error": {"text": '.$e->getMessage().' }';
		}		
});

//Deleting Funeral Record
$app->delete('/funeral/lists/delete/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	try{
		DB::getInstance()->delete('funeral', array('id', '=', $id));
		
		echo '{"notice": {"text":"Record Deleted"}}';
		return $response->withHeader('Content-type', 'application/json');
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().' }';
	}
});


$app->run();

