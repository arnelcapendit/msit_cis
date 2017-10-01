<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../core/initv2.php';
require '../vendor/autoload.php';
//header("Content-type: application/json");

$app = new \Slim\App;

// Get All Confirmation list
$app->get('/confirmation/lists', function(Request $request, Response $response){	
	//echo 'OK';
		
		$lists = DB::getInstance()->query("SELECT * from conf_tbl");

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

// Get Single Confirmation list record
$app->get('/confirmation/list/{id}', function(Request $request, Response $response){	
		$id = $request->getAttribute('id');
		
		$lists = DB::getInstance()->get('conf_tbl', array('id', '=', $id));

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

// Add Confirmation List
$app->post('/confirmation/lists/add', function(Request $request, Response $response){
	$date_of_conf = $request->getParam('date_of_conf');
	$name = $request->getParam('name');
	$age = $request->getParam('age');
	$place_of_parish = $request->getParam('place_of_parish');
	$province = $request->getParam('province');
	$place_of_baptism = $request->getParam('place_of_baptism');
	$parents = $request->getParam('parents');
	$sponsors = $request->getParam('sponsors');
	$name_of_minister = $request->getParam('name_of_minister');
	
	
		try{
			DB::getInstance()->insert('conf_tbl', array(
			'date_of_conf' => $date_of_conf,
			'name' => $name,
			'age' => $age,
			'place_of_parish' => $place_of_parish,
			'province' => $province,
			'place_of_baptism' => $place_of_baptism,
			'parents' => $parents,
			'sponsors' => $sponsors,
			'name_of_minister' => $name_of_minister
		));
			echo '{"notice": {"text":"New Record Added"}}';
			return $response->withHeader('Content-type', 'application/json');
		} catch(PDOException $e){
			echo '{"error": {"text": '.$e->getMessage().' }';
		}		
});


// Update Confirmation List Record
$app->put('/confirmation/lists/update/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$date_of_conf = $request->getParam('date_of_conf');
	$name = $request->getParam('name');
	$age = $request->getParam('age');
	$place_of_parish = $request->getParam('place_of_parish');
	$province = $request->getParam('province');
	$place_of_baptism = $request->getParam('place_of_baptism');
	$parents = $request->getParam('parents');
	$sponsors = $request->getParam('sponsors');
	$name_of_minister = $request->getParam('name_of_minister');

		try{
			DB::getInstance()->update('conf_tbl', $id, array(
			'date_of_conf' => $date_of_conf,
			'name' => $name,
			'age' => $age,
			'place_of_parish' => $place_of_parish,
			'province' => $province,
			'place_of_baptism' => $place_of_baptism,
			'parents' => $parents,
			'sponsors' => $sponsors,
			'name_of_minister' => $name_of_minister
		));
			echo '{"notice": {"text":"Record Updated"}}';
			return $response->withHeader('Content-type', 'application/json');

		} catch(PDOException $e){
			echo '{"error": {"text": '.$e->getMessage().' }';
		}		
});

//Deleting Confirmation Record
$app->delete('/confirmation/lists/delete/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	try{
		DB::getInstance()->delete('conf_tbl', array('id', '=', $id));
		
		echo '{"notice": {"text":"Record Deleted"}}';
		return $response->withHeader('Content-type', 'application/json');
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().' }';
	}
});


$app->run();

