<?php
	require_once 'init.php';
	
	$user = new User();
	
	if ($user->isLoggedIn()){
		Session::flash('user_logged_out', 'Hope to see you again soon, ' . $user->data()->username);
		$user->logout();
		
		Redirect::to(HTTP . 'index.php');
	} else {
		Redirect::to(HTTP . 'index.php');
	}
?>