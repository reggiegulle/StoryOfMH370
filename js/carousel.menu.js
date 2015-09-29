/*
JavaScript for owl carousel menu
*/

$(document).ready(function(){
	$('#weeks_carousel_menu').owlCarousel({
		items: 3,
		itemsDesktop: [1200, 3],
		itemsDesktopSmall: [992, 3],
		itemsTablet: [768, 2],
		itemsMobile: [767, 1],
		navigation: true,
		navigationText: ['&laquo', '&raquo'],
		pagination: false
	});
	
	var owl_weeks_carousel_menu = $('#weeks_carousel_menu').data('owlCarousel');
	if (week_order === 'DESC'){
		var descPos = $('#weeks_carousel_menu li').index( $('#weeks_carousel_menu li').last());
		owl_weeks_carousel_menu.jumpTo(descPos);
	}
	
	$('#videos_carousel').owlCarousel({
		items: 6,
		itemsDesktop: [1199, 5],
		itemsDesktopSmall: [979, 4],
		itemsTablet: [768, 3],
		itemsMobile: [479, 2],
		navigation: true,
		pagination: false
	})
	
	var owl_vids_car = $('#videos_carousel').data('owlCarousel');

	$('#videos_list').on('mh370.vidListRender', function(){
		
		while($('#videos_carousel li').length > 0){
			owl_vids_car.removeItem(0);
		}
		
		var vids_car_len = $('#videos_list li').length;
		for(n=1; n < vids_car_len; n++){
			var vid_car_item = '<li data-index="';
			vid_car_item += (n-1) + '">';
			var vid_car_img = $('#videos_list li').eq(n-1).find('img').prop('outerHTML');
			vid_car_item += vid_car_img;
			var vid_car_datePub_data = $('#videos_list li').eq(n-1).find('h5').text();
			vid_car_item += '<p>' + vid_car_datePub_data + '</p>';
			var vid_car_title_data = $('#videos_list li').eq(n-1).find('h3').text();
			vid_car_item += '<h5>' + vid_car_title_data + '</h5>';
			vid_car_item += '</li>';
			owl_vids_car.addItem(vid_car_item);
		}
		
		if($('#videos_carousel').is(':hidden')){
			$('#videos_carousel').show();
		}
		
		$("#videos_carousel li").each(function(){
			
			$(this).css({
				'height' : $('#videos_carousel').height() + 'px'
			});
			
			var imgRegex = /https:\/\/i3.ytimg.com\/vi\/([\w-]{11})\/mqdefault.jpg/;
			//get the videoid from each li item
			var vidImgDat = $(this).find('img').attr('src');
			var vidId = vidImgDat.match(imgRegex)[1];
			//play the video on the player
			$(this).on("click", "img", function(){
				$("html, body").animate({
					scrollTop: $("#weeks_carousel_container").offset().top 
				},500);
				player.loadVideoById(vidId);
			}).on("click", "h5", function(){
				$("html, body").animate({
					scrollTop: $("#weeks_carousel_container").offset().top 
				},500);
				player.loadVideoById(vidId);
			});
		});
		
		$('#videos_carousel').trigger('mh370.vidCrslRender');
	}); 
});