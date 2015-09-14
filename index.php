<?php
	require_once "/includes/init.php";
	
	$user = new User();
	
	$week = new Week();
	
	$week->get_latest('videos', 'week_number');
	
	$latest_wk = (int)$week->latest_week();
	
	$week_order = isset($_GET['ver']) ? $_GET['ver'] : null;
	
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
		<!--owl-carousel styles-->
		<link rel="stylesheet" type="text/css" href="css/owl.carousel.css"/>
		<link rel="stylesheet" type="text/css" href="css/owl.theme.default.css"/>
		<!--slicknav style-->
		<link rel="stylesheet" type="text/css" href="css/slicknav.css"/>
		<!--Main Style-->
		<link rel="stylesheet" type="text/css" href="css/style.main.css"/>
		<!--Colors Style-->
		<link rel="stylesheet" type="text/css" href="css/style.theme.css"/>
		
		<!--jQuery from Google CDN Hosted Libraries-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<!--JS snippet for determining ordering-->
		<script type="text/javascript">
			<?php 
				if(!isset($week_order)){
					echo 'var week_order = "ASC";';
				} else if ($week_order === 'n'){
					echo 'var week_order = "DESC";';
				}
			?>
		</script>
		<!--slick js plugin-->
		<script type="text/javascript" src="js/owl.carousel.js"></script>
		<!--js for slicknav-->
		<script type="text/javascript" src="js/jquery.slicknav.js"></script>
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
		
		<!--js for video_description_list-->
		<script type="text/javascript" src="js/vidsdesc.js"></script>
		
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
		
		<div class="header container-fluid">
			<section id="masthead" class="row">
				<article id="masthead_title" class="col-xs-12 col-sm-8 col-md-6 col-md-offset-1 col-lg-6 col-lg-offset-1">
					<div class="rows">
						<h1 class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-0 col-lg-6 col-lg-offset-1">
							<a href="index.php">The Story of <br />
							Flight MH370 <br />
							In Online Videos</a>
						</h1>
						<div class="col-xs-12 col-sm-8 col-sm-offset-3 col-md-8 col-md-offset-4 col-lg-8 col-lg-offset-4">
							<img src="images/280x149.airplane.masthead.png" width="280px" height="149px" alt="" />
						</div>
					</div>
				</article>
				<article id="masthead_login" class="col-xs-12 col-sm-4 col-sm-offset-0 col-md-5 col-md-offset-0 col-lg-4 col-lg-offset-0">
					<?php include_once "includes/layout/login_splash.php" ;?>
				</article>
			</section>
			<!--This is where the search form should be-->
			<section id="search_container" class="row gradient">
				<div class="col-xs-12 col-xs-offset-1 col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2">
					<p>View By: 
					<?php 
						if(!isset($week_order)){
							echo '<a href="index.php?ver=n" id="newtoold" class="special_show_hide">Newest To Oldest</a>';
						} else if($week_order === 'n'){
							echo '<a href="index.php" id="oldtonew" class="special_show_hide">Oldest To Newest</a>';
						}
					?>
					</p>
				</div>
				<ul class="col-xs-12 col-xs-offset-1 col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-1 col-lg-4 col-lg-offset-1">
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
		</div>
		
		<div id="wrapper" class="container">
			
			<section id="weeks_carousel_container" class="gradient">
				<ul id="weeks_carousel_menu" class="owl-carousel">
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
			
			<section id="info-buttons">
				<div id="showinfo">SHOW INFO</div>
				<div id="hideinfo">HIDE INFO</div>
			</section>
			
			<section id="video_desc_list_container" class="row">
				<ul id="video_desc_list">
				</ul>
			</section>
			
			<ul id="videos_carousel" class="gradient owl-carousel">
			</ul>
			
			<section id="filter_boxes_container" class="row show_hide">
				<ul id="filter_boxes" class="row show_hide">
				</ul>
			</section>
			
			<section id="search_notifier_top">
				<section class="search_info_container">
					<div class="search_stats show_hide">
					</div>
					<div class="pages_info show_hide">
						<p class="show_hide"></p>
					</div>
				</section>
			</section>
			
			<section id="videos_list_container" class="row">
				<ul id="videos_list">  
				</ul>
			</section>
			
			<section id="search_notifier_bottom">
			</section>
			
			<section id="back_to_top_btn">
				<div>
					<p><span id="arrow">&#9650;</span> Back To Top</p>
				</div>
			</section>
		</div>
		<section id="footer_container">
			<article id="footer">
				<ul id="footer-ul">
					<li>Powered by <a href="http://www.youtube.com" title="YouTube"><img src="images/Youtube_icon45.png" width="45px" height="45px" alt="youtube_icon" /></a></li>
					<li><p>Design and UI by</p><h3>Reggie Gulle</h3></li>
					<li><p>All Rights Reserved <?php echo date("Y", time()); ?></p></li>
				</ul>
			</article>
		</section>
		 <script src="js/carousel.menu.js" type="text/javascript"></script>
		<script src="js/youtube.js" type="text/javascript"></script>
		<!--Bootstrap js-->
		<script src="js/bootstrap.min.js" type="text/javascript"></script>
	</body>
</html>