<?php
	require_once "../includes/init.php";

	
	if(Input::exists('post')){
		
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
				'exactly'		=> 11,
				'unique'	=> 'videos'
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
				'required'	=> true
			]
		]);
		
		if($validate->passed()){
			$video = new Video();
			
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
				$video->create([
					'date_published'	=> $date_input_query,
					'string_date_pub'	=> $string_date_pub,
					'week_number'		=> $weeks,
					'video_id'			=> (Input::get('video_id')),
					'video_title'		=> (Input::get('video_title')),
					'video_desc'		=> (Input::get('video_desc')),
					'video_uploader'	=> (Input::get('video_uploader')),
					'tag'				=> (Input::get('tag'))	
				]);
				//Session::flash('add_video', 'You have added a new video entry!');
				echo 'You have added a new video entry!';
			} catch (Exception $e){
				die($e->getMessage());
			}
			
		} else {
			$form_errors = $validate->errors();
			foreach($form_errors as $error){
				echo "<p> {$error} </p>";
			}
		}
	}
?>

		
		<article>

			<h1>Add New Video</h1>
			<form id="addnewvideo" action="" method="POST">
				<div class="field">
					<label for="date_published"><p>Date Published:</p></label>
						<span>Month</span>
						<select name="date_month" form="addnewvideo">
							<option value="01">January</option>
							<option value="02">February</option>
							<option value="03">March</option>
							<option value="04">April</option>
							<option value="05">May</option>
							<option value="06">June</option>
							<option value="07">July</option>
							<option value="08">August</option>
							<option value="09">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
						<span>Day</span>
						<select name="date_day" form="addnewvideo">
							<option value="01">01</option>
							<option value="02">02</option>
							<option value="03">03</option>
							<option value="04">04</option>
							<option value="05">05</option>
							<option value="06">06</option>
							<option value="07">07</option>
							<option value="08">08</option>
							<option value="09">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
							<option value="25">25</option>
							<option value="26">26</option>
							<option value="27">27</option>
							<option value="28">28</option>
							<option value="29">29</option>
							<option value="30">30</option>
							<option value="31">31</option>
						</select>
						<span>Year</span>
						<select name="date_year" form="addnewvideo">
							<option value="2014">2014</option>
							<option value="2015">2015</option>
						</select>
				</div>
				<div class="field">
					<label for="video_id"><p>Video Id:</p></label>
					<input type="text" id="video_id" name="video_id" form="addnewvideo" value="" />	
				</div>
				<div class="field">
					<label for="video_title"><p>Video Title:</p></label>
					<input type="text" id="video_title" name="video_title" form="addnewvideo" value="" />	
				</div>
				<div class="field">
					<label for="video_desc"><p>Video Description:</p></label>
					<textarea id="video_desc" name="video_desc" cols="50" rows="8"></textarea>
				</div>
				<div class="field">
					<label for="video_uploader"><p>Video Uploaded By:</p></label>
					<input type="text" id="video_uploader" name="video_uploader" form="addnewvideo" value="" />	
				</div>
				<div class="field">
					<label for="tag"><p>Tag:</p></label>
					<select name="tag" form="addnewvideo">
						<option value="Breaking News">Breaking News</option>
						<option value="Headline News">Headline News</option>
						<option value="Press Conference">Press Conference</option>
						<option value="News Feature">News Feature</option>
						<option value="News Analysis">News Analysis</option>
						<option value="Official Communication">Official Communication</option>
						<option value="Tribute">Tribute</option>
					</select>
				</div>
				<input type="submit" value="Create Entry" />
			</form>
			<div id="cancel"><a href="../index.php">Cancel</a></div>
			
		</article>