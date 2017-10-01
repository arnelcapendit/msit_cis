<?php
require_once 'core/init.php';

//var_dump(Token::check(Input::get('token')));

if(Input::exists()){
	//echo Input::get('username');
	if(Token::check(Input::get('token'))){
		//echo "running";
	$validate = new Validate();
	$validation = $validate->check($_POST, array(
		'username' => array(
			'required' => true,
			'min' => 2,
			'max' => 20,
			'unique' => 'users'
		),
		'fname' => array(
			'required' => true,
			'min' => 2,
			'max' => 20,
			),
		'lname' => array(
			'required' => true,
			'min' => 2,
			'max' => 20,
			),
		'password' => array(
			'required' => true,
			'min'=> 6
		),
		'password_again' => array(
			'required' => true,
			'matches' => 'password'
		)
		//'name' => array(
		//	'required' => true,
		//	'min' => 2,
		//	'max' => 50
		//)
		));

	if($validation->passed()){
		//echo 'Passed';
		//Session::flash('success', 'You registered successfully!');
		//header('Location: index.php');
		$user = new User();

		$salt = Hash::salt(32);

		try{ 
			$user->create(array(
				'username' => Input::get('username'),
				'password' => Hash::make(Input::get('password'), $salt),
				'salt' => $salt,
				'fname' => Input::get('fname'),
				'lname' => Input::get('lname'),
				//'name' => Input::get('name'),
				'datecreated' => date('Y-m-d H:i:s'),
				'group' => 1
			));

		Session::flash('home', 'You registered successfully!');
		Redirect::to('index.php');

		} catch (Exception $e){ 
			die($e->getMessage());
		}

	} else {
		foreach ($validation->errors() as $error) {
			echo $error, '<br>';	
		}
	}
}
}

?>

<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?> " autocomplete="off">		
	</div>

	<div class="field">
		<label for="fname">First Name</label>
		<input type="text" name="fname" id="fname">
	</div>

	<div class="field">
		<label for="lname">Last Name</label>
		<input type="text" name="lname" id="lname">
	</div>
	

	<div class="field">
		<label for="password">Choose a password</label>
		<input type="password" name="password" id="password">		
	</div>

	<div class="field">
		<label for="password_again">Enter your password again</label>
		<input type="password" name="password_again" id="password_again">		
	</div>
	<!--
	<div class="field">
		<label for="name">Enter your password again</label>
		<input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?> ">		
	</div>
	-->
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" value="Register">

</form>