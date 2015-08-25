<?php

	class Week{
		private $_db,
				$_data;
				
		public function __construct(){
			$this->_db = DB::getInstance();
		}
		
		public function get_latest($table, $column){
			$sql = 'SELECT * FROM ' . $table . ' ORDER BY ' . $column . ' DESC';
			if(!$this->_db->query($sql)->error()){
				$this->_data = $this->_db->results();
				return $this;
			}
			return false;
		}
		
		public function data(){
			return $this->_data;
		}
		
		public function latest_week(){
			return $this->data()[0]->week_number;
		}
	}
	
	

?>