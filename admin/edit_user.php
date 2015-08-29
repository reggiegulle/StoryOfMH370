<?php

require_once '../includes/init.php';

$user = new User();

//if $user not logged in,
//back to index.php	
if (!$user->exists()){
	Redirect::to(HTTP . 'index.php');
} else {
	if(!$user->isLoggedIn() || !$user->hasPermission('admin')){
		Redirect::to(HTTP . 'index.php');
	} else {
		$user_id = $_GET['id'];
		$user_to_be_edited = new User($user_id);
		$user_data = $user_to_be_edited->data();
	}
}
?>

<!--include reg_user_header.php-->
<?php include '../includes/layout/reg_user_header.php'; ?>
	<section>

		<article>
			<p>Hello <a href="profile.php?user_id=<?php echo escape($user->data()->id); ?>"><?php echo escape($user->data()->username); ?>!</a></p>
		</article>
		
		<article>
			<?php
				if(Session::exists('edit_user_success')){
					echo '<p class="phpnotif">' . Session::flash('edit_user_success') . '</p>';
				}
			?>
		</article>

		<p>To modify the user's existing details, fill-in the user's new details in the fields below.  Then type the user's reset password in the field provided and click "Submit".</p>


		<form action="<?php print HTTP . 'includes/edit_user_admin_post.php?id=' . escape($user_id); ?>" method="POST">
			<div class="field">
				<label for="name">Username</label>
				<input type="text" name="username" value="<?php echo escape($user_data->username); ?>" />
				<article>
					<?php
						if(Session::exists('username')){
							echo '<p class="error">' . Session::flash('username') . '</p>';
						}
					?>
				</article>
			</div>
			
			<div class="field">
				<label for="name">User's Real Name</label>
				<input type="text" name="name" id="name" value="<?php echo escape($user_data->name); ?>" />
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
				<input type="radio" name="group" value="1" <?php if($user_data->group == 1){echo 'checked';} ?>/>Standard User
				&nbsp;
				<input type="radio" name="group" value="2" <?php if($user_data->group == 2){echo 'checked';} ?>/>Site Admin
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
				<label for="password">Password</label>
				<input type="password" name="password" id="password" autocomplete="off" value="" />
				<article>
					<?php
						if(Session::exists('password')){
							echo '<p class="error">' . Session::flash('password') . '</p>';
						}
					?>
				</article>
			</div>	
				
			<div class="field">
				<input type="submit" value="Submit" />
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
			</div>
		</form>
		
		<!--<p>Back To: <a href="manage_users.php">Users Table</a></p>-->
	
	</section>

<!--include reg_user_footer.php-->
<?php include '../includes/layout/reg_user_footer.php'; ?>