/*
JavaScript for owl carousel menu
*/

$(document).ready(function(){
	var owl_weeks_carousel_menu = $('#weeks_carousel_menu');
	owl_weeks_carousel_menu.owlCarousel({
		nav: true,
		navText: ['<p>&laquo;</p>', '<p>&raquo;</p>'],
		responsive:{
				0:{
					items: 1
				},
				768:{
					items: 2
				},
				992:{
					items: 3
				}
			}
	});
	if (week_order === 'DESC'){
		//var descPos = ($('#weeks_carousel_menu li').length) - 1;
		var descPos = $('#weeks_carousel_menu li').index( $('#weeks_carousel_menu li').last());
		owl_weeks_carousel_menu.trigger('to.owl.carousel', [parseInt(descPos)]);
	}
	
	var owl_vids_car = $('#videos_carousel');
	owl_vids_car.owlCarousel({
		loop: false,
		itemElement: 'li',
		margin: 1,
		nav: true,
		navText: ['<p>&laquo;</p>&nbsp;<p>prev</p>', '<p>next</p>&nbsp;<p>&raquo;</p>'],
		responsive:{
				0:{
					items: 2
				},
				768:{
					items: 4
				},
				992:{
					items: 5
				},
				1200:{
					items: 6
				}
			}
	});
	
	while($('#videos_carousel li').length > 0){
		owl_vids_car.trigger('remove.owl.carousel', [0]);
	}
	
	var vids_car_len = $('#videos_list li').length;
	for(n=(vids_car_len); n > 0; n--){
		var vid_car_item = $('<div>');
		var vid_car_img = $('#videos_list li').eq(n-1).find('img').clone();
		vid_car_img.appendTo(vid_car_item);
		var vid_car_datePub_data = $('#videos_list li').eq(n-1).find('h5').text();
		var vid_car_datePub = $('<p>');
		vid_car_datePub.html(vid_car_datePub_data);
		vid_car_datePub.appendTo(vid_car_item);
		var vid_car_title_data = $('#videos_list li').eq(n-1).find('h3').text();
		var vid_car_title = $('<h5>');
		vid_car_title.html(vid_car_title_data);
		vid_car_title.appendTo(vid_car_item);
		owl_vids_car.trigger('add.owl.carousel', [vid_car_item, 0]);
	}
	owl_vids_car.trigger('refresh.owl.carousel');
	
	$("#videos_carousel li").each(function(){
		
		$(this).css({
			'height' : $('#videos_carousel').height() + 'px'
		});
		
		
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

	$('#videos_list').on('mh370.vidListRender', function(){
		
		owl_weeks_carousel_menu.trigger('refresh.owl.carousel');
		
		while($('#videos_carousel li').length > 0){
			owl_vids_car.trigger('remove.owl.carousel', [0]);
		}
		
		var vids_car_len = $('#videos_list li').length;
		for(n=(vids_car_len); n > 0; n--){
			var vid_car_item = $('<div>');
			var vid_car_img = $('#videos_list li').eq(n-1).find('img').clone();
			vid_car_img.appendTo(vid_car_item);
			var vid_car_datePub_data = $('#videos_list li').eq(n-1).find('h5').text();
			var vid_car_datePub = $('<p>');
			vid_car_datePub.html(vid_car_datePub_data);
			vid_car_datePub.appendTo(vid_car_item);
			var vid_car_title_data = $('#videos_list li').eq(n-1).find('h3').text();
			var vid_car_title = $('<h5>');
			vid_car_title.html(vid_car_title_data);
			vid_car_title.appendTo(vid_car_item);
			owl_vids_car.trigger('add.owl.carousel', [vid_car_item, 0]);
		}
		owl_vids_car.trigger('refresh.owl.carousel');
		
		$("#videos_carousel li").each(function(){
			
			$(this).css({
				'height' : $('#videos_carousel').height() + 'px'
			});
			
			
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
		
		if($('#videos_carousel').is(':hidden')){
			$('#videos_carousel').show();
		}
		
		$('#videos_carousel').trigger('mh370.vidCrslRender');
	});
});