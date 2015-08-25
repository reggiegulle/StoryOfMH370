<?php

	class Video_Search_Obj{
		private $_db,
				$_search_data,
				$_rowCount,
				$_limit;
				
		public function __construct(){
			$this->_db = DB::getInstance();
		}
		
		public function search_query_limit($pg_num, $res_per_pg){
			$limit_str = 'LIMIT ' .($pg_num - 1) * $res_per_pg .',' .$res_per_pg;
			$this->_limit = $limit_str;
		}
		
		public function limit_query_by(){
			return $this->_limit;
		}
		
		public function search_by($order, $string, $pg_param = '', $tags=[]){
			$sql = 'SELECT * FROM videos WHERE string_date_pub LIKE "%' . $string . '%"';
			if(count($tags) === 1){
				$sql .= ' AND tag = "' . $tags[0] . '"';
			}
			if(count($tags) > 1){
				$sql .= ' AND (';
				$sql .= 'tag = "' . $tags[0] . '"';
				for($t = 1, $tlen = count($tags); $t < $tlen; $t++){
					$sql .= ' OR tag = "' . $tags[$t] .'"';
				}
				$sql .= ')';
			}
			$sql .= ' UNION ';
			$sql .= 'SELECT * FROM videos WHERE video_title LIKE "%' . $string . '%"';
			if(count($tags) === 1){
				$sql .= ' AND tag = "' . $tags[0] . '"';
			}
			if(count($tags) > 1){
				$sql .= ' AND (';
				$sql .= 'tag = "' . $tags[0] . '"';
				for($t = 1, $tlen = count($tags); $t < $tlen; $t++){
					$sql .= ' OR tag = "' . $tags[$t] .'"';
				}
				$sql .= ')';
			}
			$sql .= ' UNION ';
			$sql .= 'SELECT * FROM videos WHERE video_desc LIKE "%' . $string . '%"';
			if(count($tags) === 1){
				$sql .= ' AND tag = "' . $tags[0] . '"';
			}
			if(count($tags) > 1){
				$sql .= ' AND (';
				$sql .= 'tag = "' . $tags[0] . '"';
				for($t = 1, $tlen = count($tags); $t < $tlen; $t++){
					$sql .= ' OR tag = "' . $tags[$t] .'"';
				}
				$sql .= ')';
			}
			$sql .= ' UNION ';
			$sql .= 'SELECT * FROM videos WHERE video_uploader LIKE "%' . $string . '%"';
			if(count($tags) === 1){
				$sql .= ' AND tag = "' . $tags[0] . '"';
			}
			if(count($tags) > 1){
				$sql .= ' AND (';
				$sql .= 'tag = "' . $tags[0] . '"';
				for($t = 1, $tlen = count($tags); $t < $tlen; $t++){
					$sql .= ' OR tag = "' . $tags[$t] .'"';
				}
				$sql .= ')';
			}
			$sql .= ' ORDER BY date_published ' . $order;
			
			if(!$this->_db->query($sql)->error()){
				$this->_rowCount = $this->_db->count();
			}
			
			//put limit here
			if(!empty($pg_param)){
				$sql .= ' ' . $pg_param;
			}
			
			if(!$this->_db->query($sql)->error()){
				$this->_search_data = $this->_db->results();
				return true;
			}
			return false;
		}
		
		
		public function search_data(){
			return $this->_search_data;
		}
		
		public function display_row_count(){
			return $this->_rowCount;
		}
	}
	
?>