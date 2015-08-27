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
			} else {
				Redirect::to('../index.php');
			}
		}
	}
?>

<div id="wrapper"> 
		
	<section>
		<article>
			<?php
			if(Session::exists('edit_video_entry')){
				echo '<p class="phpnotif">' . Session::flash('edit_video_entry') . '</p>';
			}
			?>
		</article>
		<h1>Edit Video Details</h1>
		<form id="editvideoentry" action="edit_video_entry_post.php?id=<?php echo $video_entry_index; ?>" method="POST">
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
				<article>
					<?php
						if(Session::exists('video_id')){
							echo '<p class="error">' . Session::flash('video_id') . '</p>';
						}
					?>
				</article>				
			</div>
			<div class="field">
				<label for="video_title"><p>Video Title:</p></label>
				<input type="text" id="video_title" name="video_title" form="editvideoentry" value="<?php echo escape($video_entry_data->video_title); ?>" />
			</div>
			<div class="field">
				<label for="video_desc"><p>Video Description:</p></label>
				<textarea id="video_desc" name="video_desc" cols="50" rows="8"><?php echo escape($video_entry_data->video_desc); ?></textarea>
				<article>
					<?php
						if(Session::exists('video_desc')){
							echo '<p class="error">' . Session::flash('video_desc') . '</p>';
						}
					?>
				</article>
			</div>
			<div class="field">
				<label for="video_uploader"><p>Video Uploaded By:</p></label>
				<input type="text" id="video_uploader" name="video_uploader" form="editvideoentry" value="<?php echo escape($video_entry_data->video_uploader); ?>" />
				<article>
					<?php
						if(Session::exists('video_uploader')){
							echo '<p class="error">' . Session::flash('video_uploader') . '</p>';
						}
					?>
				</article>				
			</div>
			<div class="field">
				<label for="tag"><p>Tag:</p></label>
				<select name="tag" form="editvideoentry">
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
	</section>
</div>