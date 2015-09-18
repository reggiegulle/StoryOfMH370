<?php
	if(Session::exists('user_logged_out')){
		echo '<p>' . Session::flash('user_logged_out') . '</p>';
	}
?>

<?php
	if (!$user->isLoggedIn()){			
?>
	<section id="login_splash">
		<article id="normal_login">
			<p>Registered Users Login</p>
			<?php
				if(Session::exists('login_error')){
					echo '<p class="error">' . Session::flash('login_error') . '</p>';
				}
			?>
			<form action="<?php print HTTP . 'includes/login_post.php'; ?>" method="POST">
			
				<ul>
					<li>
						<label for="username">Username</label>
						<input type="text" name="username" id="username" autocomplete="off" value="" />
						<?php
							if(Session::exists('username')){
								echo '<p class="error">' . Session::flash('username') . '</p>';
							}
						?>
					</li>
					<li>
						<label for="password">Password</label>
						<input type="password" name="password" id="password" autocomplete="off" value="" />
						<?php
							if(Session::exists('password')){
								echo '<p class="error">' . Session::flash('password') . '</p>';
							}
						?>
					</li>
				</ul>
				
				<ul>
					<li id="desc_inline">
						<input type="checkbox" name="remember" id="remember" />
						<p class="remember">Remember me</p>
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
						<input type="submit" value="Log In" />
					</li>
				</ul>
			</form>
		</article>
	</section>
<?php
	} else {
		if (!$user->hasPermission('admin')){
?>
			<section class="user_interface_panel_login row">
				<div class="col-xs-12">
					<p>Welcome back, 
						<a href="<?php print HTTP . 'admin/profile.php?user_id=' . $user->data()->id; ?>">
							<?php echo $user->data()->username; ?>
						</a>
					</p>
					<div class="user_interface_btn">
						<a href="<?php print HTTP . 'includes/logout_post.php'; ?>">
							Logout
						</a>
					</div>
				</div>
			</section>
<?php			
		} else {		
?>
			<section class="user_interface_panel_login row">
				<div class="col-xs-12">
					<p>Welcome back, 
						<a href="<?php print HTTP . 'admin/profile.php?user_id=' . $user->data()->id; ?>">
							<?php echo $user->data()->username; ?>
						</a>
					</p>
					<p>
						<a href="<?php print HTTP . 'admin/manage_users.php'; ?>">
							Administer Users
						</a>
					</p>
					<div class="user_interface_btn">
						<a href="<?php print HTTP . 'includes/logout_post.php'; ?>">
							Logout
						</a>
					</div>
				</div>
			</section>
<?php
		}
	}
?>