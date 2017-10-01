<?php

require_once 'core/init.php';

$username = new User();

//echo $username->data()->username;
//echo Input::get('user');
if(!$username = Input::get('user')){
	
	//echo $username;
	//echo Input::get('user');
	//Redirect::to('index.php');
}  else {
	$username = new User();
	//echo $username->data()->username;
	$user = new User($username->data()->username);
	if(!$username->exists()){
		echo 'Not exist';
		Redirect::to(404);
	} else {
		echo '<h1>Hi! Welcome</h1>';
		$data = $username->data();
	}
	?>


	<h3><?php echo escape($data->username); ?></h3>
	<p>First Name: <?php echo escape($data->fname); ?></p>
	<p>Last Name: <?php echo escape($data->lname); ?></p>


	<?php
}


