<?php
	require_once 'init.php';
	
	if(Input::exists('post')){
		if(Token::check(Input::get('token'))){
		
			$validate = new Validate();
			$validation = $validate->check($_POST, [
				'username'	=>	['required'	=> true],
				'password'	=>	['required'	=> true]
			]);
			
			if($validation->passed()){
				//log user in
				$user = new User();
				
				$remember = (Input::get('remember') === 'on') ? true : false;
				$login = $user->login(Input::get('username'), Input::get('password'), $remember);
				
				if($login){
					Redirect::to(HTTP . 'index.php');
				} else {
					Session::flash('login_error', 'Incorrect username or password');
					Redirect::to(HTTP . 'index.php');
				} 
			} else {
				Redirect::to(HTTP . 'index.php');
			}
		}
	}
?>