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
?>

<!--include reg_user_header.php-->
<?php include '../includes/layout/reg_user_header.php'; ?>
		
<section>
		<h5>User Profile:</h5>

		<p>Username: <strong>"<?php echo escape($data->username); ?>"</strong></p>
		<p>Full Name: <strong>"<?php echo escape($data->name); ?>"</strong></p>

		<p><a href="edit_user_details.php?user_id=<?php echo escape($data->id); ?>">Click here</a> if you want to change your profile details.</p>
</section>

<!--include reg_user_footer.php-->
<?php include '../includes/layout/reg_user_footer.php'; ?>