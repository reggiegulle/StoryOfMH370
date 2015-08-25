<?php
	header("Content-type: application/json; charset = UTF-8");
	
	require_once "init.php";
	
	/* 	if(!Input::exists()){
		Redirect::to('../index.php');
	} */
	
	$videos_search = new Video_Search_Obj();
	
	$curr_pg;
	
	$rpp = 10;
	
	if(isset($_POST['curr_pg'])){
		$curr_pg = preg_replace('#[^0-9]#', '', $_POST['curr_pg']);
	}
	
	$videos_search->search_query_limit($curr_pg, $rpp);
	
	$search_limit = $videos_search->limit_query_by();
	
 	if(isset($_POST['keywords']) && !isset($_POST['filter_array'])){
		$safe_keywords = escape($_POST['keywords']);
		$videos_search_query = $videos_search->search_by('DESC', $safe_keywords, $search_limit);
		$videos_search_return_data = $videos_search->search_data();
	} else if(isset($_POST['keywords']) && isset($_POST['filter_array'])){
		$safe_keywords = escape($_POST['keywords']);
		$filter_array = array_map('escape', $_POST['filter_array']);
		$videos_search_query = $videos_search->search_by('DESC', $safe_keywords, $search_limit, $filter_array);
		$videos_search_return_data = $videos_search->search_data();
	}
	
	//$videos_search->search_by('DESC', 'Obama');
	
	$videos_search_return_data = $videos_search->search_data();
	
	$numOfRows = $videos_search->display_row_count();
	
	$last_page = ceil($numOfRows/$rpp);
	
	if($last_page < 1){
		$last_page = 1;
	}
	
	$response_arr = [];
	
	$response_arr[0]['total_count'] = $numOfRows;
	
	$response_arr[0]['current_page'] = (int)$curr_pg;
	
	$response_arr[0]['last_page'] = $last_page;
	
	$response_arr[1]['results'] = $videos_search_return_data;
	
	echo json_encode($response_arr);
	
	/* $videos_search->search_query_limit(1, 10);
	
	echo $videos_search->limit_query_by();
	
	$search_limit = $videos_search->limit_query_by();
	
	$videos_search->search_by('DESC', 'Malaysia', $search_limit);
	
	$videos_search_data = $videos_search->search_data();
	
	echo json_encode($videos_search_data); */
	
?>