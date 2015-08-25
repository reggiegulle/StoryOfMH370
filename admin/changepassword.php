<?php

require_once '../includes/init.php';

$user = new User();

//if $user not logged in,
//back to index.php	
if (!$user->isLoggedIn()){
	Redirect::to('../index.php');
} else {
	
	if(!$user_id = Input::get('user_id')){
		Redirect::to('../index.php');
	} else {
		//assign variable $user to the User Object
		$user = new User($user_id);
		//check if $user exists in database
		if(!$user->exists()){
			//if $user is not in database,
			//back to index.php
			Redirect::to('../index.php');
		} else {
			$data = $user->data();	
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
			} else{
				//echo 'OK!';
				$salt = Hash::salt(32);
				$user->update([
					'password' => Hash::make(Input::get('password_new'), $salt),
					'salt' => $salt
				], $data->id);
				
				Session::flash('edit_user_pwd_success', 'Your password has been changed.');
			}
		
		} else {
			foreach($validation->errors() as $error){
				echo '<p class="error">' . $error . '</p><br />';
			}
		}
	}
}

?>
		
	<div id="wrapper">

		<p>Hello <a href="profile.php?user_id=<?php echo escape($data->id); ?>"><?php echo escape($data->username); ?>!</a></p>
		
		<?php
			if(Session::exists('edit_user_pwd_success')){
				echo '<p>' . Session::flash('edit_user_pwd_success') . '</p>';
			}
		?>
		
		<p>To change your password, fill-in your current password in the field provided below.  Type and re-type your new password in each of the fields provided and click "Submit".</p>

		<form action="" method="POST">
			
			<div class="field">
				<article>
					<?php
						if(Session::exists('password_current')){
							echo '<p class="error">' . Session::flash('password_current') . '</p>';
						}
					?>
				</article>
				<article>
					<?php
						if(Session::exists('edit_user_current_pwd_error')){
							echo '<p class="error">' . Session::flash('edit_user_current_pwd_error') . '</p>';
						}
					?>
				</article>
				<label for="password_current">Current password</label>
				<input type="password" name="password_current" id="password_current" />
			</div>
			<div class="field">
				<article>
					<?php
						if(Session::exists('password_new')){
							echo '<p class="error">' . Session::flash('password_new') . '</p>';
						}
					?>
				</article>
				<label for="password_new">New password</label>
				<input type="password" name="password_new" id="password_new" />
			</div>
			<div class="field">
				<article>
					<?php
						if(Session::exists('password_new_again')){
							echo '<p class="error">' . Session::flash('password_new_again') . '</p>';
						}
					?>
				</article>
				<label for="password_new_again">Re-type your new password</label>
				<input type="password" name="password_new_again" id="password_new_again" />
			</div>
			<div class="field">	
				<input type="submit" value="Change" />
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
			</div>

		</form>
	</div>