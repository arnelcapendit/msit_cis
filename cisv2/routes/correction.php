<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../core/initv2.php';
require '../vendor/autoload.php';
//header("Content-type: application/json");

$app = new \Slim\App;

// Get All correction list
$app->get('/correction/lists', function(Request $request, Response $response){	
	//echo 'OK';
		
		$lists = DB::getInstance()->query("SELECT * from corr_tbl");

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
				
				//print_r($listrecords);

				$jsonresponse['Total'] = $count;
				$jsonresponse['Data'] = $listrecords;

				echo json_encode($jsonresponse);
			
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
			//echo $json;
			return $response->withHeader('Content-type', 'application/json');
		}


});

// Get Single correction list record
$app->get('/correction/list/{id}', function(Request $request, Response $response){	
		$id = $request->getAttribute('id');
		
		$lists = DB::getInstance()->get('corr_tbl', array('id', '=', $id));

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

// Add correction List
$app->post('/correction/lists/add', function(Request $request, Response $response){
	$kind = $request->getParam('kind');
	$reference = $request->getParam('reference');
	$discrepancy = $request->getParam('discrepancy');
	$orig_entries = $request->getParam('orig_entries');
	$approve_corr = $request->getParam('approve_corr');
	$approve_by = $request->getParam('approve_by');
	$title = $request->getParam('title');
	$place = $request->getParam('place');
	$ref_no = $request->getParam('ref_no');
	$date = $request->getParam('date');
	
	
		try{
			DB::getInstance()->insert('corr_tbl', array(
			'kind' => $kind,
			'reference' => $reference,
			'discrepancy' => $discrepancy,
			'orig_entries' => $orig_entries,
			'approve_corr' => $approve_corr,
			'approve_by' => $approve_by,
			'title' => $title,
			'place' => $place,
			'ref_no' => $ref_no,
			'date' => $date

		));
			echo '{"notice": {"text":"New Record Added"}}';
			return $response->withHeader('Content-type', 'application/json');
		} catch(PDOException $e){
			echo '{"error": {"text": '.$e->getMessage().' }';
			'{"error": {"text": '.DB::getInstance()->error().' }';
		}		
});


// Update correction List Record
$app->put('/correction/lists/update/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$kind = $request->getParam('kind');
	$reference = $request->getParam('reference');
	$discrepancy = $request->getParam('discrepancy');
	$orig_entries = $request->getParam('orig_entries');
	$approve_corr = $request->getParam('approve_corr');
	$approve_by = $request->getParam('approve_by');
	$title = $request->getParam('title');
	$place = $request->getParam('place');
	$ref_no = $request->getParam('ref_no');
	$date = $request->getParam('date');

		try{
			DB::getInstance()->update('corr_tbl', $id, array(
			'kind' => $kind,
			'reference' => $reference,
			'discrepancy' => $discrepancy,
			'orig_entries' => $orig_entries,
			'approve_corr' => $approve_corr,
			'approve_by' => $approve_by,
			'title' => $title,
			'place' => $place,
			'ref_no' => $ref_no,
			'date' => $date
		));
			echo '{"notice": {"text":"Record Updated"}}';
			return $response->withHeader('Content-type', 'application/json');

		} catch(PDOException $e){
			echo '{"error": {"text": '.$e->getMessage().' }';
		}		
});

//Deleting correction Record
$app->delete('/correction/lists/delete/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	try{
		DB::getInstance()->delete('corr_tbl', array('id', '=', $id));
		
		echo '{"notice": {"text":"Record Deleted"}}';
		return $response->withHeader('Content-type', 'application/json');
	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().' }';
	}
});


$app->run();

