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
			
			//The code below holds true
			//if the form registering a new user
			//is submitted
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
					}
				}
			}
			
			//The code below holds true
			//even if no submission is made
			//to register a new user
			$all_users_obj = new User();
			$all_users_obj->find_all();
			$all_users_data = $all_users_obj->data();
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
			if(Session::exists('delete_user')){
				echo '<p>' . Session::flash('delete_user') . '</p>';
			}
		?>
	</article>


	<h4>Register New User</h4>

	<form action="" method="POST">
		<div class="field">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" value="" autocomplete="off" />
			<article>
				<?php
					if(Session::exists('username')){
						echo '<p class="error">' . Session::flash('username') . '</p>';
					}
				?>
			</article>
		</div>
		
		<div class="field">
			<article>
			<label for="name">User's Full Name</label>
			<input type="text" name="name" id="name" value="" />
			<article>
				<?php
					if(Session::exists('name')){
						echo '<p class="error">' . Session::flash('name') . '</p>';
					}
				?>
			</article>
		</div>
		
		<div class="field">
			<label for="group">User Group</label>
			<input type="radio" name="group" value="1" />Standard User
			&nbsp;
			<input type="radio" name="group" value="2" />Site Admin
			<br />
			<article>
				<?php
					if(Session::exists('group')){
						echo '<p class="error">' . Session::flash('group') . '</p>';
					}
				?>
			</article>
		</div>
		
		<div class="field">
			<label for="password">Choose a password</label>
			<input type="password" name="password" id="password" value="" />
			<article>
				<?php
					if(Session::exists('password')){
						echo '<p class="error">' . Session::flash('password') . '</p>';
					}
				?>
			</article>
		</div>
		
		<div class="field">
			<label for="password_again">Enter password again</label>
			<input type="password" name="password_again" id="password_again" value="" />
			<article>
				<?php
					if(Session::exists('password_again')){
						echo '<p class="error">' . Session::flash('password_again') . '</p>';
					}
				?>
			</article>
		</div>
		
		<div class="field">
			<input type="hidden" name="token" value="<?php echo Token::generate() ?>" >
		</div>
		
		<input type="submit" value="Register" >

		
	</form>
	<article>
		<h5><a href="../index.php">Cancel</a></h5>
	</article>
	
	<section id="all_users_list_container">
		<h2>Registered Users</h2>
		<ul id="all_users_list">
			<?php
				foreach($all_users_data as $user_data){
					$li_item = '';
					$li_item .= '<li>';
					$li_item .= '<h6>Database ID: ' . $user_data->id . '</h6>';
					$li_item .= '<h6>Username: ' . $user_data->username . '</h6>';
					$li_item .= '<h6>Full Name: ' . $user_data->name . '</h6>';
					$li_item .= '<p>Date Joined: ' . $user_data->joined . '</p>';
					$li_item .= '<p>Group: ';
					if($user_data->group == 1){
						$li_item .= 'Standard User';
					} else {
						$li_item .= 'Administrator';
					} 
					$li_item .= '</p>';
					$li_item .= '<a href="edit_user.php?id=' . escape($user_data->id) . '">Edit User</a>';
					$li_item .= '<br />';
					$li_item .= '<a href="delete_user.php?id='. escape($user_data->id) . '" onclick="return confirm(\'Are You Sure?\')">Delete User</a>';
					$li_item .= '</li>';
					echo $li_item;
				}
			?>
		</ul>
	</section>