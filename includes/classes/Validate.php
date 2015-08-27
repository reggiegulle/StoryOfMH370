<?php
	class Validate {
		private		$_passed	= false,
					$_date_valid = false,
					$_errors	= [],
					$_db		= null;
		
		public function __construct(){
			$this->_db = DB::getInstance();
		}
		
		public function check($source, $items = []){
			foreach($items as $item => $rules){
				foreach($rules as $rule => $rule_value){
					
					$value = trim($source[$item]);
					//echo $value;
					
					$item = escape($item);
					
					if($rule === 'required' && empty($value)){
						$this->addError("{$item} cannot be blank.");
						Session::flash('' . $item . '', '' . $this->clean_item_output($item) . ' cannot be blank.');
					} else if(!empty($value)){
						switch($rule){
							case 'min':
								if(strlen($value) < $rule_value){
									$this->addError(ucfirst("{$item} must be at least {$rule_value} characters long."));
									Session::flash('' . $item . '', '' . $this->clean_item_output($item) . ' must be at least ' . $this->clean_item_output($rule_value) . ' characters long.');
								}
							break;
							case 'exactly':
								if(strlen($value) != $rule_value){
									$this->addError(ucfirst("{$item} must be exactly {$rule_value} characters long."));
									Session::flash('' . $item . '', '' . $this->clean_item_output($item) . ' must be exactly ' . $this->clean_item_output($rule_value) . ' characters long.');
								}
							break;
							case 'max':
								if(strlen($value) > $rule_value){
									$this->addError(ucfirst("{$item} can only be up to {$rule_value} characters long."));
									Session::flash('' . $item . '', '' . $this->clean_item_output($item) . ' can only be up to ' . $this->clean_item_output($rule_value) . ' characters long.');
								}
							break;
							case 'matches':
								if($value != $source[$rule_value]){
									$this->addError("{$rule_value} must exactly match {$item}");
									Session::flash('' . $item . '', '' . $this->clean_item_output($item) . ' must exactly match ' . $this->clean_item_output($rule_value) . '.');
								}
							break;
							case 'unique':
								$check = $this->_db->get($rule_value, [$item, '=', $value]);
								if($check->count()) {
									$this->addError("{$item} already exists.");
									Session::flash('' . $item . '', '' . $this->clean_item_output($item) . ' already exists.');
								}
							break;
						}
					}
				}
			}
			/* if(empty($this->_errors)){
				$this->_passed = true;
			} */
			return $this;
		}
		
		private function validateDate($date, $format = 'Y-m-d'){
			$d = DateTime::createFromFormat($format, $date);
			return $d && $d->format($format) == $date;
		}
		
		public function verify_date($year, $month, $day){
			$raw_date_array = [$year, $month, $day];
			$date_input = implode("-", $raw_date_array);
			$wrong_month_template = new DateTime('2000-' . $month . '-01');
			$wrong_month = $wrong_month_template->format('F');
			$wrong_day_template = new DateTime('2000-01-' . $day);
			$wrong_day = $wrong_day_template->format('j');
			$date_bool = $this->validateDate($date_input);
			$compare_date = new DateTime('2014-03-07');
			if($date_bool != 1){
				$this->addError("{$wrong_month} {$day}, {$year} is not a valid date.");
			} else if(new DateTime($date_input) < $compare_date) {
				$this->addError("The date \"{$wrong_month} {$wrong_day}, {$year}\" cannot be accepted as data.");
			}
			return $this;
		}
		
		private function clean_item_output($item){
			if (preg_match('/_/', $item)) {
				$item_raw = explode('_', $item);
				$output = '';
				$output .= strtoupper(implode(' ', $item_raw));
				return $output;
			}
			return strtoupper($item);
		}
		
		private function addError($error){
			$this->_errors[] = $error;
		}
		
		public function errors(){
			return $this->_errors;
		}
		
		public function passed(){
			if(empty($this->_errors)){
				$this->_passed = true;
			}
			return $this->_passed;
		}
	}
?>