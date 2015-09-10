/*
JavaScript for owl carousel menu
*/

$(document).ready(function(){
	$('#weeks_carousel_menu').slick({
		infinite: false,
		slide: 'li',
		slidesToShow: 2,
		edgeFriction: 0.02,
		swipeToSlide: true
	});
	
	$('#videos_carousel').slick({
		infinite: false,
		slide: 'li',
		slidesToShow: 6,
		edgeFriction: 0.02,
		swipeToSlide: true,
		responsive: [
			{
				breakpoint:1024,
				settings:{
					slidesToShow: 4
				}
			},
			{
				breakpoint:600,
				settings:{
					slidesToShow: 3
				}
			},
			{
				breakpoint:480,
				settings:{
					slidesToShow: 2
				}
			}
		]
	});
	
	$('#videos_list').on('mh370.vidListRender', function(){
		if($('#videos_carousel').is(':hidden')){
			$('#videos_carousel').show();
		}
		
		while($('#videos_carousel li').length > 0){
			$('#videos_carousel').slick('slickRemove', 0);
		}
		
		$('#videos_list li').each(function(){
			var vid_item = $('<li>');
			var carouselLiImg = $(this).find('img').clone();
			carouselLiImg.appendTo(vid_item);
			var carouselDtPubData = $(this).find('h5').text();
			var carouselDtPub = $('<p>')
			carouselDtPub.html(carouselDtPubData);
			carouselDtPub.appendTo(vid_item);
			var carouselTitleData = $(this).find('h3').text();
			var carouselTitle = $('<h5>');
			carouselTitle.html(carouselTitleData);
			carouselTitle.appendTo(vid_item);
			$('#videos_carousel').slick('slickAdd', vid_item);
		});
		
		//behavior of the videos carousel
		$("#videos_carousel li").each(function(){
			var srcUrl = $(this).find('img').attr('src');
			var imgContainer = $(this);
			var imgIndex = $(this).index();
			//console.log(imgIndex);
			var imgRegex = /https:\/\/i3.ytimg.com\/vi\/([\w-]{11})\/mqdefault.jpg/;
			//get the videoid from each li item
			var vidImgDat = $(this).find('img').attr('src');
			var vidId = vidImgDat.match(imgRegex)[1];
			//play the video on the player
			$(this).on("click", "img", function(){
				player.loadVideoById(vidId);
			});
		});
		
		$('#videos_carousel').trigger('mh370.vidCrslRender');
	});
});