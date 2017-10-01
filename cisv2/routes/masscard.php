<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../core/initv2.php';
require '../vendor/autoload.php';
//header("Content-type: application/json");

$app = new \Slim\App;

// Get All masscard list
$app->get('/masscard/lists', function(Request $request, Response $response){	
	//echo 'OK';
		
		$lists = DB::getInstance()->query("SELECT * from mass_card");

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

// Get Single masscard list record
$app->get('/masscard/list/{id}', function(Request $request, Response $response){	
		$id = $request->getAttribute('id');
		
		$lists = DB::getInstance()->get('mass_card', array('id', '=', $id));

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

// Add masscard List
$app->post('/masscard/lists/add', function(Request $request, Response $response){
	$names = $request->getParam('names');
	$schedule = $request->getParam('schedule');
	$date = $request->getParam('date');
		
		try{
			DB::getInstance()->insert('mass_card', array(
			'names' => $names,
			'schedule' => $schedule,
			'date' => $date	
		));
			echo '{"notice": {"text":"New Record Added"}}';
			return $response->withHeader('Content-type', 'application/json');
		} catch(PDOException $e){
			echo '{"error": {"text": '.$e->getMessage().' }';
			'{"error": {"text": '.DB::getInstance()->error().' }';
		}		
});


// Update masscard List Record
$app->put('/masscard/lists/update/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$names = $request->getParam('names');
	$schedule = $request->getParam('schedule');
	$date = $request->getParam('date');

		try{
			DB::getInstance()->update('mass_card', $id, array(
			'names' => $names,
			'schedule' => $schedule,
			'date' => $date	
		));
			echo '{"notice": {"text":"Record Updated"}}';
			return $response->withHeader('Content-type', 'application/json');

		} catch(PDOException $e){
			echo '{"error": {"text": '.$e->getMessage().' }';
		}		
});

//Deleting masscard Record
$app->delete('/masscard/lists/delete/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	try{
		DB::getInstance()->delete('mass_card', array('id', '=', $id));
		
		echo '{"notice": {"text":"Record Deleted"}}';
		return $response->withHeader('Content-type', 'application/json');
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().' }';
	}
});


$app->run();

