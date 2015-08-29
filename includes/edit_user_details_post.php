<?php

	require_once 'init.php';

	$user = new User();

	//if $user not logged in,
	//back to index.php	
	if (!$user->isLoggedIn()){
		Redirect::to(HTTP . 'index.php');
	} else {
		foreach($_GET as $key => $value){
			if ($value == ""){
				Redirect::to(HTTP . 'index.php');
			}
		}
		//check if $user exists in database
		if(!$user->exists()){
			//if $user is not in database,
			//back to index.php
			Redirect::to(HTTP . 'index.php');
		} else {
			$data = $user->data();
			if(Input::get('user_id') != $data->id){
				Redirect::to(HTTP . 'index.php');
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
				],
				'password' => [
					'required' => true
				]
			]);
			
			if($validation->passed()){
				if(Hash::make(Input::get('password'), $data->salt) !== $data->password){
					Session::flash('edit_user_pwd_error', 'Password is incorrect.');
					Redirect::to(HTTP . 'admin/edit_user_details.php?user_id=' . $data->id);
				} else{
					//update
					try{
						$user->update([
							'username'	=>	Input::get('username'),
							'name' => Input::get('name')
						], $data->id);
						
						Session::flash('edit_user_success', 'Your details have been updated.');
						
						Redirect::to(HTTP . 'admin/edit_user_details.php?user_id=' . $data->id);
						
					} catch(Exception $e){
						die($e->getMessage());
					}
				}
			
			} else {
				Redirect::to(HTTP . 'admin/edit_user_details.php?user_id=' . $data->id);
			}
		}
	}
?>