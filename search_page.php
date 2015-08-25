<?php
	require_once "/includes/init.php";
	
	$week = new Week();
	
	$week->get_latest('videos', 'week_number');
	
	$latest_wk = (int)$week->latest_week();
?>

<!DOCTYPE html>
<html>
<head>
<title>Test Search Page</title>

<!--slick js carousel styles-->
<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
<!--Main Style-->
<link rel="stylesheet" type="text/css" href="css/style.main.css"/>
<style type='text/css'>
	#nextPgBtn,
	#prevPgBtn{
		cursor: pointer;
	}
</style>

<!--jQuery from Google CDN Hosted Libraries-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!--js for determining styles-->
<script type="text/javascript" src="js/styling.js"></script>
<!--slick js plugin-->
<script type="text/javascript" src="slick/slick.js"></script>
<!--main js-->
<script src="js/script.js" type="text/javascript"></script>
<!--JS for the search functions-->
<script type="text/javascript" src="js/search.js"></script>
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

	<div id="wrapper">
	
		<h1>The Story of MH370</h1>
	
		<section id="search_container">
			<h5>Search</h5>
			<input id="search_field" type="text" name="keywords" value="" />
			<button id="reset_search">Reset Search</button>
		</section>
		
		
		<ul id="weeks_carousel_menu">
			<?php
				for($w=1; $w < ($latest_wk+5); $w++){
					if ($w%4 == 0){
						echo '<li>Weeks ' . ($w - 3) . '-' . $w . '</li>';
					}
				}
			?>
		</ul>
		
		<section id="video_player_container">
			<article id="player"></article>
		</section>
		
		<ul id="videos_carousel">
		</ul>

		<section id="output">
		</section>

		<section id="pages_info">
			<p></p>
		</section>

		<ul id="filter_boxes">
		</ul>

		<ul id="videos_list">
		</ul>

	</div>
	<script src="js/carousel.menu.js" type="text/javascript"></script>
	<script src="js/youtube.js" type="text/javascript"></script>

</body>
</html>