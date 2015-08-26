<?php

	class Video{
		private $_db,
				$_data;
		
		public function __construct(){
			$this->_db = DB::getInstance();
		}
		
		public function safe_string($string) {
			$this->_db->quote($string);
			return $string;
		}
		
		public function create($fields = []){
			if(!$this->_db->insert('videos', $fields)){
				throw new Exception('There was a problem creating a video entry.');
			}
		}
		
		public function update($fields = [], $id = null){
			if(!$this->_db->update('videos', $id, $fields)){
				throw new Exception('There was a problem updating.');
			}
		}
		
		public function delete($fields = []){
			if(!$this->_db->delete('videos', $fields)){
				throw new Exception('There was a problem deleting a video entry.');
			}
		}
		
		public function find($video_id = null){
			if($video_id){
				$field = (is_numeric($video_id)) ? 'id' : 'video_id';
				$data = $this->_db->get('videos', [$field, '=', $video_id]);
				
				if($data->count()){
					$this->_data = $data->first();
					return true;
				}
			}
			return false;
		}
		
		public function display_weeks_by($start, $end, $order){
			$sql = 'SELECT * FROM videos WHERE week_number >= ? AND week_number <= ? ORDER BY date_published ' . $order;
			$sql_array = [$start,$end];
			if(!$this->_db->query($sql, $sql_array)->error()){
				$this->_data = $this->_db->results();
				return true;
			} 
			return false;
		}

		//public function exists
		public function exists(){
			return(!empty($this->_data)) ? true : false;
		}

		public function data(){
			return $this->_data;
		}
		

	}

?>