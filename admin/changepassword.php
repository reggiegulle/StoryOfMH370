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

	if(Input::exists('post')){
		if(Token::check(Input::get('token'))){
			//echo 'OK!';
			$validate = new Validate();
			$validation = $validate->check($_POST, [
				'password_current' => [
					'required' => true,
					'min' => 6
				],
				'password_new' => [
					'required' => true,
					'min' => 6
				],
				'password_new_again' => [
					'required' => true,
					'min' => 6,
					'matches' => 'password_new'
				]
			]);
			
			//if the validation passes
			if($validation->passed()){
				//change of password
				if(Hash::make(Input::get('password_current'), $data->salt) !== $data->password){
					Session::flash('edit_user_current_pwd_error', 'The current password you provided is incorrect.');
				} else {
					//echo 'OK!';
					$salt = Hash::salt(32);
					$user->update([
						'password' => Hash::make(Input::get('password_new'), $salt),
						'salt' => $salt
					], $data->id);
					
					Session::flash('edit_user_pwd_success', 'Your password has been changed.');
				}
			
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
					<a href="profile.php?user_id=<?php echo escape($data->id); ?>">
						<?php echo escape($data->username); ?>!
					</a>
			</p>
			
			<article>
				<?php
					if(Session::exists('edit_user_pwd_success')){
						echo '<p class="phpnotif">' . Session::flash('edit_user_pwd_success') . '</p>';
					}
				?>
			</article>
			
			<p>
				To change your password, fill-in your current password in the field provided below.  Type and re-type your new password in each of the fields provided and click "Change".
			</p>

			<form action="" method="POST">
				
				<div class="field">
					<label for="password_current">Current password</label>
					<input type="password" name="password_current" id="password_current" />
					<article>
						<?php
							if(Session::exists('password_current')){
								echo '<p class="phpnotif">' . Session::flash('password_current') . '</p>';
							}
							if(Session::exists('edit_user_current_pwd_error')){
								echo '<p class="phpnotif">' . Session::flash('edit_user_current_pwd_error') . '</p>';
							}
						?>
					</article>
				</div>
				<div class="field">
					<label for="password_new">New password</label>
					<input type="password" name="password_new" id="password_new" />
					<article>
						<?php
							if(Session::exists('password_new')){
								echo '<p class="phpnotif">' . Session::flash('password_new') . '</p>';
							}
						?>
					</article>
				</div>
				<div class="field">
					<label for="password_new_again">Re-type your new password</label>
					<input type="password" name="password_new_again" id="password_new_again" />
					<article>
						<?php
							if(Session::exists('password_new_again')){
								echo '<p class="phpnotif">' . Session::flash('password_new_again') . '</p>';
							}
						?>
					</article>
				</div>
				<div class="field">	
					<input type="submit" class="submit" value="Change" />
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
				</div>

			</form>
			
			<article id="cancel">
				<a href="<?php print HTTP . 'index.php'; ?>">Cancel</a>
			</article>
		
		</section>
		
		<section id="constraint" class="col-xs-0 col-sm-4"></section>
		
	</section>
<!--include reg_user_footer.php-->
<?php include '../includes/layout/reg_user_footer.php'; ?>