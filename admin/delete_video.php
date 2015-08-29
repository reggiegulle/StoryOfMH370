<?php

	require_once "../includes/init.php";
	
	$user = new User();
	
	//if $user not logged in,
	//back to index.php	
	if (!$user->exists()){
		Redirect::to('../index.php');
	} else {
		if(!$user->isLoggedIn() || !$user->hasPermission('admin')){
			Redirect::to('../index.php');
		} else {
			
			foreach($_GET as $key => $value){
				if ($value == ""){
					Redirect::to('../index.php');
				}
			}
				
			if (Input::exists('get')){
				$video_entry = new Video();
				$video_entry_id = $video_entry->safe_string(Input::get('id'));
				$video_entry->find($video_entry_id);
			
				if (!$video_entry->exists()){
					Redirect::to('../index.php');
				} else {
					$video_entry_title = $video_entry->data()->video_title;
					try{
						$video_entry->delete([
							'id', '=' , Input::get('id')
						]);
						
						Session::flash('delete', 'Video for entry "' . $video_entry_title . '" has been deleted from the database.');
						Redirect::to('../index.php');
					} catch (Exception $e){
						die($e->getMessage());
					}
				}
			} else {
				Redirect::to('../index.php');
			}
		}
	}
	
	

?>
