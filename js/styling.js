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
	
	function isEmpty( el ){
		return !$.trim(el.html()); 
    }
	
	if(isEmpty($('#search_container'))){
		$('#search_container').height('32px');
	} else {
		$('#search_container').height('auto');
	}
	
	$(document).ajaxSuccess(function(){
		$('#per_wk_list li').each(function(){
			if($(this).is(':visible')){
				$(this).addClass('col-xs-3');
			} else if ($(this).is(':hidden')){
				$(this).removeClass('col-xs-3');
			}
		});
	});
	
	$('#videos_list').on('mh370.vidListRender', function(){
		$('#video_desc_list').addClass('col-xs-12');
		$('#video_desc_list li').each(function(){
			$(this).addClass('col-xs-12');
			var descliFtDiv = $(this).find('div').eq(0);
			$(descliFtDiv).addClass('col-xs-12 col-sm-6');
			var descliScnDiv = $(this).find('div').eq(1);
			$(descliScnDiv).addClass('col-xs-0 col-sm-6');
			$(this).find('h3, p').addClass('col-xs-12');
		});
		$('#videos_list').addClass('col-xs-12');
		$('#videos_list li').each(function(){
			$(this).addClass('col-xs-12');
			var liFtDiv = $(this).find('div').eq(0);
			$(liFtDiv).addClass('col-xs-12 col-sm-6');
			var liScnDiv = $(this).find('div').eq(1);
			$(liScnDiv).addClass('col-xs-0 col-sm-6');
			$(this).find('h3, p').addClass('col-xs-12');
		});
	});
	
	$('#videos_list').on('mh370.weekListRender', function(){
		function getVidListHt(){
			var height = 0;
		
			for(i = 0;i < 6;i++){
				height += $('#videos_list li').eq(i).height();
			}
			
			return height;
		}
		
		var vidListHt = getVidListHt();
		
		$('#videos_list').css({
			'height': vidListHt + 'px'
		});
	});
	
	$('#videos_list').on('mh370.searchListRender', function(){
		$('#videos_list').css({
			'height': 'auto'
		});
		$('#filter_boxes li').each(function(){
			if($(this).index() == 6){
				$(this).addClass('col-xs-12 col-md-4');
			}else{
				$(this).addClass('col-xs-6 col-md-4');
			}
		});
	});
});