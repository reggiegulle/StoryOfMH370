<?php

	require_once '../includes/init.php';

	$user = new User();

	//if $user not logged in,
	//back to index.php	
	if (!$user->isLoggedIn()){
		Redirect::to(HTTP . 'index.php');
	} else {
		foreach($_GET as $key => $value){
			if ($value == ""){
				Redirect::to(HTTP . 'index.php');
			}
		}
		//check if $user exists in database
		if(!$user->exists()){
			//if $user is not in database,
			//back to index.php
			Redirect::to(HTTP . 'index.php');
		} else {
			$data = $user->data();
			if(Input::get('user_id') != $data->id){
				Redirect::to(HTTP . 'index.php');
			}
		}
	}
?>

<!--include reg_user_header.php-->
<?php include '../includes/layout/reg_user_header.php'; ?>
	<section class="user_interface row">
	
		<section class="user_interface_panel col-xs-12 col-sm-8">
		
			<p>
				Hello 
					<a href="<?php print HTTP;?>admin/profile.php?user_id=<?php echo escape($data->id); ?>">
						<?php echo escape($data->username); ?>!
					</a>
			</p>
			
			<article>
				<?php
					if (Session::exists('edit_user_success')){
						echo '<p class="phpnotif">' . Session::flash('edit_user_success') . '</p>';
					}
				?>
			</article>

			<p>
				To modify your existing details, fill-in your new details in the fields below.  Then type your password in the field provided and click "Submit".
			</p>
			
			<form action="<?php print HTTP;?>includes/edit_user_details_post.php?user_id=<?php echo escape($data->id)?>" method="POST">
				<div class="field">
					<label for="name">Username</label>
					<input type="text" name="username" value="<?php echo escape($data->username); ?>" />
					<article>
						<?php
							if(Session::exists('username')){
								echo '<p class="phpnotif">' . Session::flash('username') . '</p>';
							}
						?>
					</article>
				</div>
				<div class="field">
					<label for="name">Full Name</label>
					<input type="text" name="name" value="<?php echo escape($data->name); ?>" />
					<article>
						<?php
							if(Session::exists('name')){
								echo '<p class="phpnotif">' . Session::flash('name') . '</p>';
							}
						?>
					</article>
				</div>
				<div class="field">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" autocomplete="off" value="" />
					<article>
						<?php
							if(Session::exists('password')){
								echo '<p class="phpnotif">' . Session::flash('password') . '</p>';
							}
							if(Session::exists('edit_user_pwd_error')){
								echo '<p class="phpnotif">' . Session::flash('edit_user_pwd_error') . '</p>';
							}
						?>
					</article>
				</div>
				<div class="field">	
					<input type="submit" class="submit" value="Submit" />
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
				</div>
			</form>
			
			<article id="cancel">
				<a href="<?php print HTTP . 'index.php'; ?>">Cancel</a>
			</article>

			<div>
				<div class="user_interface_btn">
					<a href="changepassword.php?user_id=<?php echo escape($user->data()->id); ?>">
						Click here
					</a>
				</div>
				if you want to change your password.
			</div>
		
		</section>
				
		<section id="constraint" class="col-xs-0 col-sm-4"></section>
		
	</section>
	
<!--include reg_user_footer.php-->
<?php include '../includes/layout/reg_user_footer.php'; ?>