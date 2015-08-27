<?php

	require_once '../includes/init.php';

	$user = new User();

	//if $user not logged in,
	//back to index.php	
	if (!$user->isLoggedIn()){
		Redirect::to('../index.php');
	} else {
		foreach($_GET as $key => $value){
			if ($value === ""){
				Redirect::to('../index.php');
			}
		}
		
		if(!$user_id = Input::get('user_id')){
			Redirect::to('../index.php');
		} else {
			//assign variable $user to the User Object
			$user_to_edit = new User($user_id);
			//check if $user exists in database
			if(!$user_to_edit->exists()){
				//if $user is not in database,
				//back to index.php
				Redirect::to('../index.php');
			} else {
				$user_to_edit_data = $user_to_edit->data();	
			}
		}
	}

	if(Input::exists('post')){
		if(Token::check(Input::get('token'))){
			//echo 'OK!';
			$validate = new Validate();
			$validation = $validate->check($_POST, [
				'username' =>[
					'required' => true,
					'min' => 2,
					'max' => 50,
					'unique'	=> 'users'
				],
				'name' =>[
					'required' => true,
					'min' => 2,
					'max' => 50
				]
			]);
			
			if($validation->passed()){
				if(Hash::make(Input::get('password'), $user_to_edit_data->salt) !== $user_to_edit_data->password){
					Session::flash('edit_user_pwd_error', 'Password is blank/incorrect.');
				} else{
					//update
					try{
						$user_to_edit->update([
							'username'	=>	Input::get('username'),
							'name' => Input::get('name')
						], $user_to_edit_data->id);
						
						Session::flash('edit_user_success', 'Your details have been updated.');
						
						Redirect::to('edit_user_details.php?user_id=' . $user_to_edit_data->id);
						
					} catch(Exception $e){
						die($e->getMessage());
					}
				}
			
			} else {
				Redirect::to('edit_user_details.php?user_id=' . $user_to_edit_data->id);
			}
		}
	}
?>