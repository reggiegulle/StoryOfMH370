<?php

require_once '../includes/init.php';

$user = new User();

	//if $user not logged in,
	//back to index.php	
	if (!$user->exists()){
		Redirect::to('../index.php');
	} else {
		if(!$user->isLoggedIn() && !$user->hasPermission('admin')){
			Redirect::to('../index.php');
		} else {
			if(Input::exists('get')){
				$user_id = $_GET['id'];
				$user_to_be_edited = new User($user_id);
				$user_data = $user_to_be_edited->data();
			}
			if(Input::exists('post')){
				//echo 'OK!';
				$validate = new Validate();
				$validation = $validate->check($_POST, [
					'username'	=> [
						'required'	=> true,
						'min'		=> 2,
						'max' 		=> 20,
						'unique'	=> 'users'
					],
					'name' => [
						'required'	=> true,
						'min'		=> 2,
						'max'		=> 50
					],
					'password'	=> [
						'required'	=> true,
						'min'		=> 6
					]
				]);
				
				if($validation->passed()){
					$salt = Hash::salt(32);
					//update
					try{
						$user_to_be_edited->update([
							'username'	=>	Input::get('username'),
							'name' => Input::get('name'),
							'password' => Hash::make(Input::get('password'), $salt),
							'salt' => $salt	
						], $user_data->id);
						
					} catch(Exception $e){
						die($e->getMessage());
					}
				} else {
					Redirect::to('edit_user.php?id=' . $user_id);
				}
				$username = $user_to_be_edited->data()->username;
						
				Session::flash('edit_user_success', 'User details have been updated.');
				
				Redirect::to('edit_user.php?id=' . $user_id);
			}
		}
	}
		

	
?>