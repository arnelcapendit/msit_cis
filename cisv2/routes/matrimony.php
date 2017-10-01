<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../core/initv2.php';
require '../vendor/autoload.php';
//header("Content-type: application/json");

$app = new \Slim\App;

// Get All Matrimony list
$app->get('/matrimony/lists', function(Request $request, Response $response){	
	//echo 'OK';
		
		$lists = DB::getInstance()->query("SELECT * from matrimony");

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

// Get Single Matrimony list record
$app->get('/matrimony/list/{id}', function(Request $request, Response $response){	
		$id = $request->getAttribute('id');
		
		$lists = DB::getInstance()->get('matrimony', array('id', '=', $id));

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

// Add Matrimony List
$app->post('/matrimony/lists/add', function(Request $request, Response $response){
	$date_of_marr = $request->getParam('date_of_marr');
	$names = $request->getParam('names');
	$stat_before_marr = $request->getParam('stat_before_marr');
	$age = $request->getParam('age');
	$origin_residence = $request->getParam('origin_residence');
	$parents = $request->getParam('parents');
	$sponsors = $request->getParam('sponsors');
	$sponsors_residence = $request->getParam('sponsors_residence');
	$name_of_minister = $request->getParam('name_of_minister');
	
	
		try{
			DB::getInstance()->insert('matrimony', array(
			'date_of_marr' => $date_of_marr,
			'names' => $names,
			'stat_before_marr' => $stat_before_marr,
			'age' => $age,
			'origin_residence' => $origin_residence,
			'parents' => $parents,
			'sponsors' => $sponsors,
			'sponsors_residence' => $sponsors_residence,
			'name_of_minister' => $name_of_minister	
		));
			echo '{"notice": {"text":"New Record Added"}}';
			return $response->withHeader('Content-type', 'application/json');
		} catch(PDOException $e){
			echo '{"error": {"text": '.$e->getMessage().' }';
			'{"error": {"text": '.DB::getInstance()->error().' }';
		}		
});


// Update Matrimony List Record
$app->put('/matrimony/lists/update/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$date_of_marr = $request->getParam('date_of_marr');
	$names = $request->getParam('names');
	$stat_before_marr = $request->getParam('stat_before_marr');
	$age = $request->getParam('age');
	$origin_residence = $request->getParam('origin_residence');
	$parents = $request->getParam('parents');
	$sponsors = $request->getParam('sponsors');
	$sponsors_residence = $request->getParam('sponsors_residence');
	$name_of_minister = $request->getParam('name_of_minister');

		try{
			DB::getInstance()->update('matrimony', $id, array(
			'date_of_marr' => $date_of_marr,
			'names' => $names,
			'stat_before_marr' => $stat_before_marr,
			'age' => $age,
			'origin_residence' => $origin_residence,
			'parents' => $parents,
			'sponsors' => $sponsors,
			'sponsors_residence' => $sponsors_residence,
			'name_of_minister' => $name_of_minister	
		));
			echo '{"notice": {"text":"Record Updated"}}';
			return $response->withHeader('Content-type', 'application/json');

		} catch(PDOException $e){
			echo '{"error": {"text": '.$e->getMessage().' }';
		}		
});

//Deleting Matrimony Record
$app->delete('/matrimony/lists/delete/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	try{
		DB::getInstance()->delete('matrimony', array('id', '=', $id));
		
		echo '{"notice": {"text":"Record Deleted"}}';
		return $response->withHeader('Content-type', 'application/json');
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().' }';
	}
});


$app->run();

