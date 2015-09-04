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
	
	function removeEmptyImgForSlick(url, imgObj, pos){
		
		$("<img/>").attr("src", url).load(function(){
			
			s = {w: this.width, h: this.height};
			
			if(s.w === 120){
				$('#videos_carousel').slick('slickRemove', pos);
			}
		});	
	}
	
	$(document).ajaxSuccess(function(event, xhr, settings){
		if(settings.url == "http://localhost/mh370/includes/gen_video_list.php"){
			if($('#videos_carousel').is(':hidden')){
				$('#videos_carousel').show();
			}
			
			while($('#videos_carousel li').length > 0){
				$('#videos_carousel').slick('slickRemove', 0);
			}
			var videos_carousel_data = JSON.parse(xhr.responseText);
			$.each(videos_carousel_data, function(k,v){
				var vid_item = '<li>';
				vid_item += "<img src='https://i3.ytimg.com/vi/" + v.video_id + "/mqdefault.jpg' alt='\"" + v.video_title + "\" thumbnail' width='120px' height='68px' longdesc='Thumbnail for the Youtube video of \"" + v.video_title + "\"'/>";
				vid_item += '<p>' + v.string_date_pub + '</p>';
				vid_item += '<h5>' + v.video_title + '</h5>';
				vid_item += '</li>';
				$('#videos_carousel').slick('slickAdd', vid_item);
			});
			
			//behavior of the videos carousel
			$("#videos_carousel li").each(function(){
				var srcUrl = $(this).find('img').attr('src');
				var imgContainer = $(this);
				var imgIndex = $(this).index();
				//console.log(imgIndex);
				removeEmptyImgForSlick(srcUrl, imgContainer, imgIndex);
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
		} else if(settings.url == "http://localhost/mh370/includes/search_return.php"){
			
			if($('#videos_carousel').is(':hidden')){
				$('#videos_carousel').show();
			}
			
			while($('#videos_carousel li').length > 0){
				$('#videos_carousel').slick('slickRemove', 0);
			}
			
			var data = JSON.parse(xhr.responseText);
			
			if(data[1]['results'].length){
				var search_results = data[1]['results'];
				$.each(search_results, function(k,v){
					var vid_item = '<li>';
					vid_item += "<img src='https://i3.ytimg.com/vi/" + v.video_id + "/mqdefault.jpg' alt='\"" + v.video_title + "\" thumbnail' width='120px' height='68px' longdesc='Thumbnail for the Youtube video of \"" + v.video_title + "\"'/>";
					vid_item += '<p>' + v.string_date_pub + '</p>';
					vid_item += '<h5>' + v.video_title + '</h5>';
					vid_item += '</li>';
					$('#videos_carousel').slick('slickAdd', vid_item);
				});
				
				//behavior of the videos carousel
				$("#videos_carousel li").each(function(){
					var srcUrl = $(this).find('img').attr('src');
					var imgContainer = $(this);
					var imgIndex = $(this).index();
					//console.log(imgIndex);
					removeEmptyImgForSlick(srcUrl, imgContainer, imgIndex);
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
			} else {
				while($('#videos_carousel li').length > 0){
					$('#videos_carousel').slick('slickRemove', 0);
				}
				$('#videos_carousel').trigger('mh370.vidCrslRender');
			}
			
		}
		
	});
});