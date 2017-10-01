<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../core/initv2.php';
require '../vendor/autoload.php';
//header("Content-type: application/json");
require_once('db.php');


$app = new \Slim\App;

$app->get('/books', function(Request $request, Response $response){	
		
$sql = "select * from library order by book_id";

	try{
		//Get DB Objectcons
		$db = new db();
		//Connect
		$db = $db->connect();

		$stmt = $db->query($sql);
		$customers = $stmt->fetchAll(PDO::FETCH_OBJ);
		//print_r($customers);
		$db = null;
		echo json_encode($customers);

	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().' }';
	}




});



