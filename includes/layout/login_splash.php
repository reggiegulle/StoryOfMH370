<?php
	if(Session::exists('user_logged_out')){
		echo '<p>' . Session::flash('user_logged_out') . '</p>';
	}
?>

<?php
	if (!$user->isLoggedIn()){			
?>
		<p>Registered Users Login</p>
		<form action="admin/login.php" method="POST">
			<div class="field">
				<label for="username">Username</label>
				<input type="text" name="username" id="username" autocomplete="off" value="" />
			</div>
			<div class="field">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" autocomplete="off" value="" />
			</div>
			
			<div class="field">
				<label for="remember">
					<input type="checkbox" name="remember" id="remember" /> Remember me
				</label>
			</div>
			
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
			<input type="submit" value="Log In" />
		</form>
<?php
	} else {
		if (!$user->hasPermission('admin')){
?>
			<p>Welcome back, <a href="admin/profile.php?user_id=<?php echo $user->data()->id; ?>"><?php echo $user->data()->username; ?></a></p>
			<p><a href="admin/logout.php">Logout</a></p>	
<?php			
		} else {		
?>
			<p>Welcome back, <a href="admin/profile.php?user_id=<?php echo $user->data()->id; ?>"><?php echo $user->data()->username; ?></a></p>
			<p><a href="admin/manage_users.php">Administer Users</a></p>
			<p><a href="admin/logout.php">Logout</a></p>
<?php
		}
	}
?>