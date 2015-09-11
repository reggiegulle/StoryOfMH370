/* 
JS for the Videos Description Lists
*/
$(document).ready(function(){
	$('#videos_list').on('mh370.vidListRender', function(){
		$('#video_desc_list').empty();
		
		/* if($('#videos_list').length > 0){
			$('#videos_list li').each(function(){
				var vid_desc_item = $('<li>');
				var vid_desc_img = $(this).find('img').clone();
				vid_desc_img.appendTo(vid_desc_item);
				$('#video_desc_list').append(vid_desc_item);
			});
		} */
		if($('#videos_list').length > 0){
			$('#videos_list li').each(function(){
				var vid_desc_item = $(this).clone();
				$('#video_desc_list').append(vid_desc_item);
			});
		}
	});
});

