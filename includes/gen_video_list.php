<?php
	header("Content-type: application/json; charset = UTF-8");
	
	require_once "init.php";
	
	$videos = new Video();
	
	if(!Input::exists()){
		$videos_list = $videos->display_weeks_by(1,4,'ASC');
	
		$videos_list_results = $videos->data();
		
		if(count($videos_list_results)){
			echo json_encode($videos_list_results); 
		}
	} else {
		if(isset($_POST['week_start']) && isset($_POST['week_end']) && isset($_POST['week_order'])){
			$wk_st = escape((int)$_POST['week_start']);
			$wk_end = escape((int)$_POST['week_end']);
			$ordering = escape((string)$_POST['week_order']);
			$videos_list = $videos->display_weeks_by($wk_st,$wk_end,$ordering);
		
			$videos_list_results = $videos->data();
			
			if(count($videos_list_results)){
				echo json_encode($videos_list_results); 
			}
		}
	}
	
?>