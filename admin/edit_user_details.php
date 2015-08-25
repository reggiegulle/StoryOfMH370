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

if(Input::exists()){
	if(Token::check(Input::get('token'))){
		//echo 'OK!';
		$validate = new Validate();
		$validation = $validate->check($_POST, [
			'username' =>[
				'required' => true,
				'min' => 2,
				'max' => 50,
				'editnotduplicate'	=> 'users'
			],
			'name' =>[
				'required' => true,
				'min' => 2,
				'max' => 50
			]
		]);
		
		if($validation->passed()){
			if(Hash::make(Input::get('password'), $data->salt) !== $data->password){
				Session::flash('edit_user_pwd_error', 'Password is blank/incorrect.');
			} else{
				//update
				try{
					$user->update([
						'username'	=>	Input::get('username'),
						'name' => Input::get('name')
					], $data->id);
					
					Session::flash('edit_user_success', 'Your details have been updated.');
					
				} catch(Exception $e){
					die($e->getMessage());
				}
			}
		
		} else {
			//echo errors
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
			if (Session::exists('edit_user_success')){
				echo '<p>' . Session::flash('edit_user_success') . '</p>';
			}
		?>

		<p>To modify your existing details, fill-in your new details in the fields below.  Then type your password in the field provided and click "Submit".</p>
		
		<form action="" method="POST">
			<div class="field">
				<article>
					<?php
						if(Session::exists('username')){
							echo '<p class="error">' . Session::flash('username') . '</p>';
						}
					?>
				</article>
				<label for="name">Username</label>
				<input type="text" name="username" value="<?php echo escape($data->username); ?>" />
			</div>
			<div class="field">
				<article>
					<?php
						if(Session::exists('name')){
							echo '<p class="error">' . Session::flash('name') . '</p>';
						}
					?>
				</article>
				<label for="name">Full Name</label>
				<input type="text" name="name" value="<?php echo escape($data->name); ?>" />
			</div>
			<div class="field">
				<article>
					<?php
						if(Session::exists('password')){
							echo '<p class="error">' . Session::flash('password') . '</p>';
						}
					?>
				</article>
				<article>
					<?php
						if(Session::exists('edit_user_pwd_error')){
							echo '<p class="error">' . Session::flash('edit_user_pwd_error') . '</p>';
						}
					?>
				</article>
				<label for="password">Password</label>
				<input type="password" name="password" id="password" autocomplete="off" value="" />
			</div>
			<div class="field">	
				<input type="submit" value="Submit" />
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
			</div>
		</form>

		<p><a href="changepassword.php?user_id=<?php echo escape($user->data()->id); ?>">Click here</a> if you want to change your password.</p>
		
	</div>