<?php
	require_once "../includes/init.php";
	
	foreach($_GET as $key => $value){
		if ($value === ""){
			Redirect::to('../index.php');
		}
	}
	
	if (Input::exists('get')){
		
		$video_entry = new Video();
		$video_entry_index = $video_entry->safe_string(Input::get('id'));
		//You can also use the video->exists method!!!
		if(!$video_entry->find($video_entry_index)){
			echo "Data not found!";
		} else {
			$video_entry_data = $video_entry->data();
			$video_entry_date_published = $video_entry_data->date_published;
			$video_entry_date_exp = explode("-", $video_entry_date_published);
			$video_entry_date_m = $video_entry_date_exp[1];
			$video_entry_date_d = $video_entry_date_exp[2];
			$video_entry_date_y = $video_entry_date_exp[0];
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
					], $video_entry_data->id);
					//Session::flash('add_video', 'You have added a new video entry!');
					echo 'You have updated the video details!';
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
	} else {
		Redirect::to('../index.php');
	}

?>

<div id="wrapper"> 
		
	
		<article>
			<?php
			if(Session::exists('edit_video_entry')){
				echo '<p>' . Session::flash('edit_video_entry') . '</p>';
			}
			?>
		</article>
		<h1>Edit Video Details</h1>
		<form id="editvideoentry" action="" method="POST">
			<div class="field">
				<label for="date_published"><p>Date Published:</p></label>
				<span>Month</span>
				<select name="date_month" form="editvideoentry">
					<?php
						for($m = 1; $m < 13; $m++){
							if($m == $video_entry_date_m){
								if($m < 10){
									$option_month = '<option value="0' . $m . '" selected>';
									$video_entry_date_m_numeric = new DateTime('2000-' . $m . '-01');
									$video_entry_date_m_full_text=$video_entry_date_m_numeric->format('F');
									$option_month .= $video_entry_date_m_full_text . ' </option>';
									echo $option_month;
								} elseif($m >= 10){
									$option_month = '<option value="' . $m . '" selected>';
									$video_entry_date_m_numeric = new DateTime('2000-' . $m . '-01');
									$video_entry_date_m_full_text=$video_entry_date_m_numeric->format('F');
									$option_month .= $video_entry_date_m_full_text . ' </option>';
									echo $option_month;
								}	
							} else {
								if($m < 10){
									$option_month = '<option value="0' . $m . '">';
									$video_entry_date_m_numeric = new DateTime('2000-' . $m . '-01');
									$video_entry_date_m_full_text=$video_entry_date_m_numeric->format('F');
									$option_month .= $video_entry_date_m_full_text . ' </option>';
									echo $option_month;
								} elseif($m >= 10){
									$option_month = '<option value="' . $m . '">';
									$video_entry_date_m_numeric = new DateTime('2000-' . $m . '-01');
									$video_entry_date_m_full_text=$video_entry_date_m_numeric->format('F');
									$option_month .= $video_entry_date_m_full_text . ' </option>';
									echo $option_month;
								}
							}
						}
					?>
				</select>
				<span>Day</span>
				<select name="date_day" form="editvideoentry">
					<?php
						for($d = 1; $d < 31; $d++){
							if($d == $video_entry_date_d){
								if($d < 10){
									$option_day = '<option value="0' . $d . '" selected>';
									$video_entry_date_d_template = new DateTime('2000-01-' . $d);
									$video_entry_date_d_numeric=$video_entry_date_d_template->format('j');
									$option_day .= $video_entry_date_d_numeric . ' </option>';
									echo $option_day;
								} elseif($d >= 10){
									$option_day = '<option value="' . $d . '" selected>';
									$video_entry_date_d_template = new DateTime('2000-01-' . $d);
									$video_entry_date_d_numeric=$video_entry_date_d_template->format('j');
									$option_day .= $video_entry_date_d_numeric . ' </option>';
									echo $option_day;
								}
							} else {
								if($d < 10){
									$option_day = '<option value="0' . $d . '"                  >';
									$video_entry_date_d_template = new DateTime('2000-01-' . $d);
									$video_entry_date_d_numeric=$video_entry_date_d_template->format('j');
									$option_day .= $video_entry_date_d_numeric . ' </option>';
									echo $option_day;
								} elseif($d >= 10){
									$option_day = '<option value="' . $d . '"                  >';
									$video_entry_date_d_template = new DateTime('2000-01-' . $d);
									$video_entry_date_d_numeric=$video_entry_date_d_template->format('j');
									$option_day .= $video_entry_date_d_numeric . ' </option>';
									echo $option_day;
								}
							}
						}
					?>
				</select>
				<span>Year</span>
				<select name="date_year" form="editvideoentry">
					<?php
						for($y = 2014; $y < 2016; $y++){
							if($y == $video_entry_date_y){
								$option_year = '<option value="' . $y . '" selected>';
								$video_entry_date_y_template = new DateTime($y . '-01-01');
								$video_entry_date_y_numeric=$video_entry_date_y_template->format('Y');
								$option_year .= $video_entry_date_y_numeric . ' </option>';
								echo $option_year;
							} else {
								$option_year = '<option value="' . $y . '">';
								$video_entry_date_y_template = new DateTime($y . '-01-01');
								$video_entry_date_y_numeric=$video_entry_date_y_template->format('Y');
								$option_year .= $video_entry_date_y_numeric . ' </option>';
								echo $option_year;
							}
						}
					?>
				</select>
			</div>
			<div class="field">
				<label for="video_id"><p>Video Id:</p></label>
				<input type="text" id="video_id" name="video_id" form="editvideoentry" value="<?php echo escape($video_entry_data->video_id); ?>" />	
			</div>
			<div class="field">
				<label for="video_title"><p>Video Title:</p></label>
				<input type="text" id="video_title" name="video_title" form="editvideoentry" value="<?php echo escape($video_entry_data->video_title); ?>" />
			</div>
			<div class="field">
				<label for="video_desc"><p>Video Description:</p></label>
				<textarea id="video_desc" name="video_desc" cols="50" rows="8"><?php echo escape($video_entry_data->video_desc); ?></textarea>
			</div>
			<div class="field">
				<label for="video_uploader"><p>Video Uploaded By:</p></label>
				<input type="text" id="video_uploader" name="video_uploader" form="editvideoentry" value="<?php echo escape($video_entry_data->video_uploader); ?>" />	
			</div>
			<div class="field">
				<label for="tag"><p>Tag:</p></label>
				<select name="tag" form="addnewvideo">
					<option value="Breaking News" <?php if(escape($video_entry_data->tag) === "Breaking News"){ echo "selected"; }; ?>>Breaking News</option>
					<option value="Headline News" <?php if(escape($video_entry_data->tag) === "Headline News"){ echo "selected"; }; ?>>Headline News</option>
					<option value="Press Conference" <?php if(escape($video_entry_data->tag) === "Press Conference"){ echo "selected"; }; ?>>Press Conference</option>
					<option value="News Feature" <?php if(escape($video_entry_data->tag) === "News Feature"){ echo "selected"; }; ?>>News Feature</option>
					<option value="News Analysis" <?php if(escape($video_entry_data->tag) === "News Analysis"){ echo "selected"; }; ?>>News Analysis</option>
					<option value="Official Communication" <?php if(escape($video_entry_data->tag) === "Official Communication"){ echo "selected"; }; ?>>Official Communication</option>
					<option value="Tribute" <?php if(escape($video_entry_data->tag) === "Tribute"){ echo "selected"; }; ?>>Tribute</option>
				</select>
			</div>
			<input type="submit" value="Edit Entry" />
		</form>
		<div id="cancel"><a href="../index.php">Cancel</a></div>
</div>