<?php
	require_once 'init.php';
	
	$user = new User();
	
	//if $user not logged in,
	//back to index.php	
	if (!$user->exists()){
		Redirect::to(HTTP . 'index.php');
	} else {
		if(!$user->isLoggedIn() || !$user->hasPermission('admin')){
			Redirect::to(HTTP . 'index.php');
		} else {
			//assign variable $user to the User Object
			$user_to_delete = new User(escape(Input::get('id')));
			$user_to_delete_data = $user_to_delete->data();
			$username = $user_to_delete_data->username;
			//$username = $karaoke_user_data->username;
			//check if $user exists in database
			if(!$user_to_delete->exists()){
				//if $user is not in database,
				//back to index.php
				Redirect::to('../index.php');
			} else {
				try{
					$user_to_delete->delete([
						'id', '=' , Input::get('id')
					]);
					
					Session::flash('delete_user', 'User "' . $username . '" has been deleted from the database.');
					Redirect::to(HTTP . 'admin/manage_users.php');
				} catch (Exception $e){
					die($e->getMessage());
				}	
			}
		}
	}	
?>