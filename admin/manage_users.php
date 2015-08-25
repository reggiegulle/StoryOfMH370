<?php
	require_once '../includes/init.php';

	$user = new User();

	//if $user not logged in,
	//back to index.php	
	if (!$user->exists()){
		Redirect::to('../index.php');
	} else {
		if(!$user->isLoggedIn() && !$user->hasPermission('admin')){
			Redirect::to('../index.php');
		} else {    
			if(Input::exists()){

				if(Token::check(Input::get('token'))){
				
					$validate = new Validate();
					$validation = $validate->check($_POST, [
						'username'	=> [
							'required'	=> true,
							'min'		=> 2,
							'max' 		=> 20,
							'unique'	=> 'users'
						],
						'password'	=> [
							'required'	=> true,
							'min'		=> 6
						],
						'password_again' => [
							'required'	=> true,
							'matches'	=> 'password'
						],
						'name' => [
							'required'	=> true,
							'min'		=> 2,
							'max'		=> 50
						],
						'group' => [
							'required'	=> true
						]
					]);
					
					if($validation->passed()){
						$user = new User();
						
						$user_name_input = Input::get('name');
						
						$salt = Hash::salt(32);
						
						try{
						
							$user->create([
								'username'	=> Input::get('username'),
								'password'	=> Hash::make(Input::get('password'), $salt),
								'salt'		=> $salt,
								'name'		=> Input::get('name'),
								'joined'	=> date('Y-m-d H:i:s'),
								'group'		=> Input::get('group')
							]);
							
							Session::flash('register', $user_name_input . ' has been registered and can now log in!');
						} catch (Exception $e){
							die($e->getMessage());
						}
					} else {
						//echo errors
						foreach($validation->errors() as $error){
							echo '<p class="error">' . $error . '</p><br />';
						}
					}
				}
			}
		}
	}
?>


	<article>
		<p>Hello <a href="profile.php?user_id=<?php echo escape($user->data()->id); ?>"><?php echo escape($user->data()->username); ?>!</a></p>
		
		<article id="logout"><a href="logout.php"><p>Logout</p></a></article>
	</article>

	<article>
		<?php
			if(Session::exists('register')){
				echo '<p>' . Session::flash('register') . '</p>';
			}
		?>
	</article>


	<h4>Register New User</h4>

	<form action="" method="POST">
		<div class="field">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" value="" autocomplete="off" />
		</div>
		
		<div class="field">
			<article>
			<label for="name">User's Full Name</label>
			<input type="text" name="name" id="name" value="" />
		</div>
		
		<div class="field">
			<label for="group">User Group</label>
			<input type="radio" name="group" value="1" />Standard User
			&nbsp;
			<input type="radio" name="group" value="2" />Site Admin
		</div>
		
		<div class="field">
			<label for="password">Choose a password</label>
			<input type="password" name="password" id="password" value="" />
		</div>
		
		<div class="field">
			<label for="password_again">Enter password again</label>
			<input type="password" name="password_again" id="password_again" value="" />
		</div>
		
		<div class="field">
			<input type="hidden" name="token" value="<?php echo Token::generate() ?>" >
		</div>
		
		<input type="submit" value="Register" >

		
	</form>
	<article>
		<h5><a href="../index.php">Cancel</a></h5>
	</article>