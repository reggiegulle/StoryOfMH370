<?php
	require_once "/includes/init.php";
	
	$user = new User();
	
	$week = new Week();
	
	$week->get_latest('videos', 'week_number');
	
	$latest_wk = (int)$week->latest_week();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Lorem Ipsum</title>
		
		<meta name="Description" CONTENT=""/>
		<!-- Bootstrap style-->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<!--slick js carousel styles-->
		<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
		<link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
		<!--Main Style-->
		<link rel="stylesheet" type="text/css" href="css/style.main.css"/>
		<!--Colors Style-->
		<link rel="stylesheet" type="text/css" href="css/style.theme.css"/>
		
		<!--jQuery from Google CDN Hosted Libraries-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<!--slick js plugin-->
		<script type="text/javascript" src="slick/slick.js"></script>
		<!--main js-->
		<?php
			if (!$user->isLoggedIn()){			
		?>
			<script src="js/script.js" type="text/javascript"></script>
		<?php
			} else {
		?>
			<script src="js/script.admin.js" type="text/javascript"></script>
		<?php 
			}
		?>
		
		<!--JS for the search functions-->
		<?php
			if (!$user->isLoggedIn()){			
		?>
			<script type="text/javascript" src="js/search.js"></script>
		<?php
			} else {
		?>
			<script type="text/javascript" src="js/search.admin.js"></script>
		<?php 
			}
		?>
		
		<!--js for determining styles-->
		<script type="text/javascript" src="js/styling.js"></script>
		
		<!--[if gte IE 9]>
		  <style type="text/css">
			.gradient {
			   filter: none;
			}
		  </style>
		<![endif]-->
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	
	<body>
		
		<!--YouTube Async iframe API-->
		<script type="text/javascript">
			$(document).ready(function(){
				var tag = document.createElement('script');
				tag.src = "https://www.youtube.com/iframe_api";
				var firstScriptTag = document.getElementsByTagName('script')[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
			});
		</script>
		
		<div id="wrapper" class="container">
			<section id="masthead" class="row">
				<article id="masthead_title" class="col-xs-12 col-sm-8 col-md-8 col-lg-7">
					<div class="rows">
						<h1 class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-1">
							<a href="index.php">The Story of <br />
							Flight MH370 <br />
							In Online Videos</a>
						</h1>
						<div class="col-xs-12 col-sm-8 col-sm-offset-3 col-md-8 col-md-offset-4 col-lg-8 col-lg-offset-4">
							<img src="images/280x149.airplane.masthead.png" width="280px" height="149px" alt="" />
						</div>
					</div>
				</article>
				<article id="masthead_login" class="col-xs-12 col-sm-4 col-md-4 col-lg-5">
					<?php include_once "includes/layout/login_splash.php" ;?>
				</article>
			</section>
			<!--This is where the search form should be-->
			<section id="search_container" class="row gradient">
				<div class="col-xs-0 col-sm-7 col-md-7"></div>
				<ul class="col-xs-12 col-sm-5 col-md-5">
					<li>
						<h5>Search</h5>
					</li>
					<li>
						<img src="images/25x25_search_icon.png" width="25px" height="25px" alt="" />
					</li>
					<li>
						<input id="search_field" type="text" name="keywords" value="" />
					</li>
					<li>
						<button id="reset_search" class="show_hide">Reset Search</button>
					</li>
					<br />
					<li>
						<article id="search_input_feedback" class="show_hide">
						</article>
					</li>
				</ul>
			</section>
			<div style="clear: both;"></div>
			
			<section id="weeks_carousel_container" class="gradient">
				<ul id="weeks_carousel_menu">
					<?php
						for($w=1; $w < ($latest_wk+5); $w++){
							if ($w%4 == 0){
								echo '<li>WEEKS ' . ($w - 3) . '-' . $w . '</li>';
							}
						}
					?>
				</ul>
			</section>
			
			<section id="per_wk_list_container">
				<ul id="per_wk_list" class="row">
				</ul>
			</section>
			
			<?php 
				if(Session::exists('delete')){
					echo '<p>' . Session::flash('delete') . '</p>';
				}
			?>
			
			<?php
				if ($user->isLoggedIn()){
			?>
					<article id="add_new_video_btn"><a href="admin/new_video.php">Add New Video</a></article>
			<?php
				}
			?>
			
			<section id="video_player_container">
				<article id="player"></article>
			</section>
			
			<ul id="videos_carousel" class="gradient">
			</ul>
			
			<section id="filter_boxes_container" class="show_hide">
				<ul id="filter_boxes" class="show_hide">
				</ul>
			</section>
			
			<div id="search_stats" class="show_hide">
			</div>
			
			<div id="pages_info" class="show_hide">
				<p class="show_hide"></p>
			</div>
			
			<ul id="videos_list">  
			</ul>
			<section id="footer_container">
				<article id="footer">
					<ul id="footer-ul">
						<li>Powered by <a href="http://www.youtube.com" title="YouTube"><img src="images/Youtube_icon45.png" width="45px" height="45px" alt="youtube_icon" /></a></li>
						<li><p>Design and UI by</p><h3>Reggie Gulle</h3></li>
						<li><p>All Rights Reserved <?php echo date("Y", time()); ?></p></li>
					</ul>
				</article>
			</section>
		</div>
		<script src="js/carousel.menu.js" type="text/javascript"></script>
		<script src="js/youtube.js" type="text/javascript"></script>
		<!--Bootstrap js-->
		<script src="js/bootstrap.min.js" type="text/javascript"></script>
	</body>
</html>