<?php
	require_once '../includes/init.php';

	$user = new User();

	//if $user not logged in,
	//back to index.php	
	if (!$user->exists()){
		Redirect::to('../index.php');
	} else {
		if(!$user->isLoggedIn() || !$user->hasPermission('admin')){
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

<!--include reg_user_header.php-->
<?php include '../includes/layout/reg_user_header.php'; ?>

	<section class="user_interface row">
	
		<section class="user_interface_panel col-xs-12 col-sm-8">
			<article>
				<p>
					Hello 
						<a href="profile.php?user_id=<?php echo escape($user->data()->id); ?>">
							<?php echo escape($user->data()->username); ?>!
						</a>
				</p>
			</article>

			<article>
				<?php
					if(Session::exists('register')){
						echo '<p class="phpnotif">' . Session::flash('register') . '</p>';
					}
					if(Session::exists('delete_user')){
						echo '<p class="phpnotif">' . Session::flash('delete_user') . '</p>';
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
								echo '<p class="phpnotif">' . Session::flash('username') . '</p>';
							}
						?>
					</article>
				</div>
				
				<div class="field">
					<label for="name">User's Full Name</label>
					<input type="text" name="name" id="name" value="" />
					<article>
						<?php
							if(Session::exists('name')){
								echo '<p class="phpnotif">' . Session::flash('name') . '</p>';
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
								echo '<p class="phpnotif">' . Session::flash('group') . '</p>';
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
								echo '<p class="phpnotif">' . Session::flash('password') . '</p>';
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
								echo '<p class="phpnotif">' . Session::flash('password_again') . '</p>';
							}
						?>
					</article>
				</div>
				
				<div class="field">
					<input type="submit" class="submit" value="Register" >
					<article id="cancel">
						<a href="<?php print HTTP . '/admin/manage_users.php'; ?>">Cancel</a>
					</article>
					<input type="hidden" name="token" value="<?php echo Token::generate() ?>" >
				</div>
			</form>
			
			<section id="all_users_list_container">
				<h2>Registered Users</h2>
				<ul id="all_users_list">
					<?php
						foreach($all_users_data as $user_data){
							$joined_date = new DateTime($user_data->joined);
							$clean_joined_date = strftime('%d-%b-%Y');
							$li_item = '';
							$li_item .= '<li>';
							$li_item .= '<h6>Database ID: ' . $user_data->id . '</h6>';
							$li_item .= '<h6>Username: ' . $user_data->username . '</h6>';
							$li_item .= '<h6>Full Name: ' . $user_data->name . '</h6>';
							$li_item .= '<p>Date Joined: ' . $clean_joined_date . '</p>';
							$li_item .= '<p>Group: ';
							if($user_data->group == 1){
								$li_item .= 'Standard User';
							} else {
								$li_item .= 'Administrator';
							} 
							$li_item .= '</p>';
							$li_item .= '<a href="edit_user.php?id=' . escape($user_data->id) . '">Edit User</a>';
							$li_item .= '<br />';
							$li_item .= '<a href="';
							$li_item .= HTTP . 'includes/delete_user_post.php?id='. escape($user_data->id) . '" onclick="return confirm(\'Are You Sure?\')">Delete User</a>';
							$li_item .= '</li>';
							echo $li_item;
						}
					?>
				</ul>
			</section>
		
		</section>
				
		<section id="constraint" class="col-xs-0 col-sm-4"></section>
		
	</section>

<!--include reg_user_footer.php-->
<?php include '../includes/layout/reg_user_footer.php'; ?>