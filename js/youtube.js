/* 
JS for YouTube API
*/

var player;

function onYouTubeIframeAPIReady() {
	player = new YT.Player("player", {
		height: "100%",
		width: "100%",
		videoId: "",
		playerVars: {
				"autohide": 1,
				"controls": 2,
				"enablejsapi": 1,
				"iv_load_policy": 3,
				"modestbranding": 1,   
				"playsinline": 1,
				"rel": 0,
				"showinfo": 0
			},
		events:{
				"onReady":onPlayerReady,
				"onStateChange":onPlayerStateChange
			}
	});
}

function onPlayerReady(event){ 
	if($("#videos_list li").length > 0){
		//get data for the first video to be cued
		var firstCuedVidImgDat = $("#videos_list li").eq(0).find('img').attr('src');
		
		//extract the video_id
		//based on img src */
		var imgRegex = /https:\/\/i3.ytimg.com\/vi\/([\w-]{11})\/mqdefault.jpg/;
		var firstCuedVidId = firstCuedVidImgDat.match(imgRegex)[1];
		
		//cue the first video
		event.target.cueVideoById(firstCuedVidId);
		
		//behavior of the videos list
		$("#videos_list li").each(function(){
			//get the videoid from each li item
			var vidImgDat = $(this).find('img').attr('src');
			var vidId = vidImgDat.match(imgRegex)[1];
			//play the video on the player
			$(this).on("click", "img", function(){
				event.target.loadVideoById(vidId);
			}).on("click", "h3", function(){
				event.target.loadVideoById(vidId);
			});
		});
	} else {
		event.target.loadVideoById('a1NgU2LSIRc');
	}
	
	
	//listen for custom events
	//'mh370.vidListRender' and 'mh370.vidCarouselRender'
	//and execute callbacks
	//(some repeating code here)
	
	//for the videos_list
	$('#videos_list').on('mh370.vidListRender', function(){
		
		if($("#videos_list li").length > 0){
			//get data for the first video to be cued
			var firstCuedVidImgDat = $("#videos_list li").eq(0).find('img').attr('src');
			
			//extract the video_id
			//based on img src
			var firstCuedVidId = firstCuedVidImgDat.match(imgRegex)[1];
			
			event.target.cueVideoById(firstCuedVidId);
			
			$("#videos_list li").each(function(){
				//get the videoid from each li item
				var vidImgDat = $(this).find('img').attr('src');
				var vidId = vidImgDat.match(imgRegex)[1];
				//play the video on the player
				$(this).on("click", "img", function(){
					event.target.loadVideoById(vidId);
				}).on("click", "h3", function(){
					event.target.loadVideoById(vidId);
				});
			});
		} else {
			event.target.loadVideoById('a1NgU2LSIRc');
		} 
	
	});
}

function onPlayerStateChange(event){
	//if the video has ENDED
	if(event.data === 0){
		//get the YouTube URL of the video playing
		var vidurl = event.target.getVideoUrl();
		//extract the video_id
		var urlRegex = /https\:\/\/www\.youtube\.com\/watch\?v=([\w-]{11})/;
		var vidIdFrURI = vidurl.match(urlRegex)[1];
		var imgRegex = /https:\/\/i3.ytimg.com\/vi\/([\w-]{11})\/mqdefault.jpg/;
		var firstImgDat = $("#videos_list li").eq(0).find('img').attr('src');
		var firstVidId = firstImgDat.match(imgRegex)[1];
		var endOfUL = parseInt(($("#videos_list li").length) - 1);
		
		$("#videos_list li").each(function(){
			var thisImgDat = $(this).find('img').attr('src');
			var thisVidId = thisImgDat.match(imgRegex)[1];
			var nextImgDat = $(this).next().find('img').attr('src');
			var nextVidId = nextImgDat.match(imgRegex)[1];
			if(vidIdFrURI === thisVidId){
				if($(this).attr('data-index') === endOfUL){
					event.target.cueVideoById(firstVidId);
				} else {
					event.target.loadVideoById(nextVidId);
				}
			}
		});
	}
} 

//the custom event registered
$(document).on('ajaxSuccess', function(){
		$('#videos_list').trigger('mh370.vidListRender');
});