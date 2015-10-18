/* 
JS for the Videos Description Lists
*/
$(document).ready(function(){
	$('#videos_list').on('mh370.weekListRender', function(){
		$('#video_desc_list').empty();
		
		if($('#videos_list').length > 0){
			$('#videos_list li').each(function(){
				var vid_desc_item = $(this).clone();
				$('#video_desc_list').append(vid_desc_item);
			});
		}
	});
	
	$('#videos_list').on('mh370.searchListRender', function(){
		$('#video_desc_list').empty();
		
		if($('#videos_list').length > 0){
			$('#videos_list li').each(function(){
				var vid_desc_item = $(this).clone();
				$('#video_desc_list').append(vid_desc_item);
			});
		}
	});
});

