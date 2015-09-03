/*

JS for styling

*/

$(document).ready(function(){
	$("#video_player_container").css({
		"height":($("#video_player_container").width() * 0.609375) + "px"
	});
	
	$(window).resize(function(){
		$("#video_player_container").css({
			"height":($("#video_player_container").width() * 0.609375) + "px"
		});
	});
	
	$(document).ajaxSuccess(function(){
		$('#per_wk_list li').each(function(){
			if($(this).is(':visible')){
				$(this).addClass('col-xs-3');
			} else if ($(this).is(':hidden')){
				$(this).removeClass('col-xs-3');
			}
		});
	});
	
	$('#videos_carousel').on('mh370.vidCrslRender', function(){
		var liItmHt = $('#videos_carousel').height();
		$('#videos_carousel li').css({
			'height': (liItmHt) + 'px'
		});
		
		$(window).resize(function(){
			var liItmHt = $('#videos_carousel').height();
			$('#videos_carousel li').css({
				'height': (liItmHt) + 'px'
			});
		});
	});	
});