<?php
	require_once "../includes/init.php";
	
	$user = new User();
	
	//if $user not logged in,
	//back to index.php	
	if (!$user->exists()){
		Redirect::to('../index.php');
	} else {
		if(!$user->isLoggedIn()){
			Redirect::to('../index.php');
		} else {
			foreach($_GET as $key => $value){
				if ($value == ""){
					Redirect::to('../index.php');
				}
			}
			
			if (Input::exists('get')){
		
				$video_entry = new Video();
				$video_entry_index = $video_entry->safe_string(Input::get('id'));
				//You can also use the video->exists method!!!
				if(!$video_entry->find($video_entry_index)){
					Redirect::to('../index.php');
				}
			
				if (Input::exists('post')){
					$date_month = Input::get('date_month');
					$date_day	= Input::get('date_day');
					$date_year	= Input::get('date_year');
					
					$validate = new Validate();
					$validate->verify_date($date_year, $date_month, $date_day);
					
					$validate->check($_POST, [
						'date_month'	=> [
							'required'	=> true
						],
						'date_day'		=> [
							'required'	=> true
						],
						'date_year'		=> [
							'required'	=> true
						],
						'video_id'		=> [
							'required'	=> true,
							'exactly'		=> 11
						],
						'video_title'	=> [
							'required'	=> true,
							'min'		=> 3
						],
						'video_desc'	=> [
							'required'	=> true,
							'min'		=> 3
						],
						'video_uploader'=> [
							'required'	=> true,
							'min'		=> 3
						],
						'tag'=> [
							'required'	=> true,
							'min'		=> 3
						]
					]);
					
					if($validate->passed()){
						
						$raw_date_input = [$date_year, $date_month, $date_day];
						$date_input_query = implode("-", $raw_date_input);
						
						$date_week_start = new DateTime('2014-03-01');
						//declare the input date
						//which will stand for
						//the date to compare with
						//the start date
						$date_week_operand = new DateTime($date_input_query);
						//assign variable
						//that corresponds to a string
						//with a particular date format
						$string_date_pub = $date_week_operand->format('F j, Y');
						//get the difference of days
						//between the two dates using
						//the diff() DateTime object method
						$interval = $date_week_start->diff($date_week_operand);
						// Output the difference in days, and convert to int
						$days = (int) $interval->format('%a');
						// Get number of full weeks by dividing days by seven,
						// rounding it up with ceil function
						$weeks = ceil($days / 7);
				
						try{	
							$video_entry->update([
								'date_published'	=> $date_input_query,
								'string_date_pub'	=> $string_date_pub,
								'week_number'		=> $weeks,
								'video_id'			=> (Input::get('video_id')),
								'video_title'		=> (Input::get('video_title')),
								'video_desc'		=> (Input::get('video_desc')),
								'video_uploader'	=> (Input::get('video_uploader')),
								'tag'				=> (Input::get('tag'))	
							], $video_entry_index);
							Session::flash('edit_video_entry', 'You have updated the video details!');
							Redirect::to('edit_video_entry.php?id=' . $video_entry_index);
						} catch (Exception $e){
							die($e->getMessage());
						}
						
					} else {
						Redirect::to('edit_video_entry.php?id=' . $video_entry_index);
					}
				} else {
					Redirect::to('../index.php');
				}
			} else {
				Redirect::to('../index.php');
			}
		}
	}
?>