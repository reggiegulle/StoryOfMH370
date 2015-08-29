<?php
	if(Session::exists('user_logged_out')){
		echo '<p>' . Session::flash('user_logged_out') . '</p>';
	}
?>

<?php
	if (!$user->isLoggedIn()){			
?>
		<p>Registered Users Login</p>
		<article>
			<?php
				if(Session::exists('login_error')){
					echo '<p class="error">' . Session::flash('login_error') . '</p>';
				}
			?>
		</article>
		<!--<form action="includes/post_pages/login_post.php" method="POST">-->
		<form action="<?php print HTTP . 'includes/login_post.php'; ?>" method="POST">
			<div class="field">
				<label for="username">Username</label>
				<input type="text" name="username" id="username" autocomplete="off" value="" />
				<article>
					<?php
						if(Session::exists('username')){
							echo '<p class="error">' . Session::flash('username') . '</p>';
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
			<p>Welcome back, <a href="<?php print HTTP . 'admin/profile.php?user_id=' . $user->data()->id; ?>"><?php echo $user->data()->username; ?></a></p>
			<p><a href="<?php print HTTP . 'includes/logout_post.php'; ?>">Logout</a></p>	
<?php			
		} else {		
?>
			<p>Welcome back, <a href="<?php print HTTP . 'admin/profile.php?user_id=' . $user->data()->id; ?>"><?php echo $user->data()->username; ?></a></p>
			<p><a href="<?php print HTTP . 'admin/manage_users.php'; ?>">Administer Users</a></p>
			<p><a href="<?php print HTTP . 'includes/logout_post.php'; ?>">Logout</a></p>
<?php
		}
	}
?>