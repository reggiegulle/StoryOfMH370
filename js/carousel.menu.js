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
	
	$('#videos_carousel').owlCarousel({
		items: 6,
		itemsDesktop: [1199, 5],
		itemsDesktopSmall: [979, 4],
		itemsTablet: [768, 3],
		itemsMobile: [479, 2],
		navigation: true,
		pagination: false,
		itemsScaleUp: true
	});
	
	var owl_vids_car = $('#videos_carousel').data('owlCarousel');

	$('#videos_list').on('mh370.vidListRender', function(){
		
		while($('#videos_carousel li').length > 0){
			owl_vids_car.removeItem(0);
		}
		
		var vids_car_len = $('#videos_list li').length;
		for(n=0; n < vids_car_len; n++){
			var vid_car_item = '<li data-index="';
			vid_car_item += (n);
			vid_car_item += '" data-week="' + $('#videos_list li').eq(n-1).data('week') + '">';
			var vid_car_img = $('#videos_list li').eq(n).find('img').prop('outerHTML');
			vid_car_item += vid_car_img;
			var vid_car_datePub_data = $('#videos_list li').eq(n).find('h5').text();
			vid_car_item += '<p>' + vid_car_datePub_data + '</p>';
			var vid_car_wk_data = $('#videos_list li').eq(n).find('h6').text();
			vid_car_item += '<h6>' + vid_car_wk_data + '</h6>';
			var vid_car_title_data = $('#videos_list li').eq(n).find('h3').text();
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
		});
		
		$('#videos_carousel').trigger('mh370.vidCrslRender');
	}); 
	
	$('#videos_carousel').on('mh370.vidCrslRender', function(){
		$('#videos_list li').each(function(){ 
			$(this).on("click", "img", function(){
				//get the videoid from each li item
				var vidId = $(this).closest('li').data('video_id');
				var dataIdx = $(this).closest('li').data('index');
				//get the data-index from each li item
				var vidListLiIdx = $(this).closest('li').data('index');
				var vidListLiWk = $(this).closest('li').data('week');
				$('#videos_list li.inplayer').removeClass('inplayer');
				$(this).closest('li').addClass('inplayer');
				$('#video_desc_list li.playing').removeClass('playing');
				$('#video_desc_list li').eq(dataIdx).addClass('playing');
				owl_vids_car.goTo(vidListLiIdx);
				$('#videos_carousel li.loaded').removeClass('loaded');
				$('#videos_carousel').find('li[data-index="' + vidListLiIdx + '"]').addClass('loaded');
				$('#per_wk_list li.active_week').removeClass('active_week');
				$('#per_wk_list').find('li[data-week="' + vidListLiWk + '"]').addClass('active_week');
				$("html, body").animate({
					scrollTop: $("#weeks_carousel_container").offset().top 
				},500);
				player.loadVideoById(vidId);
			});
			$(this).on("click", "h3", function(){
				//get the videoid from each li item
				var vidId = $(this).closest('li').data('video_id');
				var dataIdx = $(this).closest('li').data('index');
				//get the data-index from each li item
				var vidListLiIdx = $(this).closest('li').data('index');
				var vidListLiWk = $(this).closest('li').data('week');
				$('#videos_list li.inplayer').removeClass('inplayer');
				$(this).closest('li').addClass('inplayer');
				$('#video_desc_list li.playing').removeClass('playing');
				$('#video_desc_list li').eq(dataIdx).addClass('playing');
				owl_vids_car.goTo(vidListLiIdx);
				$('#videos_carousel li.loaded').removeClass('loaded');
				$('#videos_carousel').find('li[data-index="' + vidListLiIdx + '"]').addClass('loaded');
				$('#per_wk_list li.active_week').removeClass('active_week');
				$('#per_wk_list').find('li[data-week="' + vidListLiWk + '"]').addClass('active_week');
				$("html, body").animate({
					scrollTop: $("#weeks_carousel_container").offset().top 
				},500);
				player.loadVideoById(vidId);
			});
		});
		
		$('#videos_carousel li').each(function(){
			//get the videoid from each li item
			var imgRegex = /https:\/\/i3.ytimg.com\/vi\/([\w-]{11})\/mqdefault.jpg/;
			var vidImgDat = $(this).find('img').attr('src');
			var vidId = vidImgDat.match(imgRegex)[1];
			var owl_vids_car_idx = $(this).data('index');
			var vidListLiWk = $(this).data('week');
			
			//play the video on the player
			$(this).on("click", "img", function(){
				$('#videos_carousel li.loaded').removeClass('loaded');
				$(this).parent('li').addClass('loaded');
				owl_vids_car.goTo(owl_vids_car_idx);
				var vidListItmEquiv = $('#videos_list').find('li[data-index="' + owl_vids_car_idx + '"]');
				$('#videos_list li.inplayer').removeClass('inplayer');
				$(vidListItmEquiv).addClass('inplayer');
				var vidListLiInPlyrOffset = document.querySelector('#videos_list li:nth-child(' + (owl_vids_car_idx + 1) + ')').offsetTop;
				$('#videos_list').scrollTop(vidListLiInPlyrOffset);
				$('#per_wk_list li.active_week').removeClass('active_week');
				$('#per_wk_list').find('li[data-week="' + vidListLiWk + '"]').addClass('active_week');
				$("html, body").animate({
					scrollTop: $("#weeks_carousel_container").offset().top 
				},500);
				player.loadVideoById(vidId);
			}).on("click", "h5", function(){
				$('#videos_carousel li.loaded').removeClass('loaded');
				$(this).parent('li').addClass('loaded');
				owl_vids_car.goTo(owl_vids_car_idx);
				var vidListItmEquiv = $('#videos_list').find('li[data-index="' + owl_vids_car_idx + '"]');
				$('#videos_list li.inplayer').removeClass('inplayer');
				$(vidListItmEquiv).addClass('inplayer');
				var vidListLiInPlyrOffset = document.querySelector('#videos_list li:nth-child(' + (owl_vids_car_idx + 1) + ')').offsetTop;
				$('#videos_list').scrollTop(vidListLiInPlyrOffset);
				$('#per_wk_list li.active_week').removeClass('active_week');
				$('#per_wk_list').find('li[data-week="' + vidListLiWk + '"]').addClass('active_week');
				$("html, body").animate({
					scrollTop: $("#weeks_carousel_container").offset().top 
				},500);
				player.loadVideoById(vidId);
			});
		});
	});
});