<?php

require_once 'core/init.php';
		
	try {
		$listrecords = array();
		$count = 0;
		$lists = DB::getInstance()->query("SELECT * from bapt_tbl");

		if($lists->count()){
			foreach ($lists->results() as $list) {
				$listrecords[$count] = $list;
				$count = $count + 1;
			}
		}		

		$jsonresponse = [];

		$jsonresponse['Success'] = true;
		$jsonresponse['Message'] = "Completed";
		$jsonresponse['Total'] = 0;
		$jsonresponse['Data'] = $listrecords;
		
		


		$json = json_encode($jsonresponse);
		echo $json;

		

	} catch (Exception $e) {
		die($e->getMessage());
	}


//});


