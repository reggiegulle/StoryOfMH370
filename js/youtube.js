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

var vidPlayed;
var withScrollBar;

function onPlayerReady(event){ 
	if($("#videos_list li").length > 0){
		//get data for the first video to be cued
		var firstCuedVidId = $("#videos_list li").first().data('video_id');
		
		//extract the video_id
		//based on img src */
		var imgRegex = /https:\/\/i3.ytimg.com\/vi\/([\w-]{11})\/mqdefault.jpg/;
		//var firstCuedVidId = firstCuedVidImgDat.match(imgRegex)[1];
		
		event.target.cueVideoById(firstCuedVidId);
		
		//behavior of the video_desc_list
		$("#video_desc_list li").each(function(){
			var descItmVidId = $(this).data('video_id');
			if(descItmVidId == firstCuedVidId){
				$(this).show();
			} else {
				$(this).hide();
			}
		});
		
		//behavior of the videos_carousel
		$("#videos_carousel li").each(function(){
			var vidCarImgDat = $(this).find('img').attr('src');
			var vidCarVidId = vidCarImgDat.match(imgRegex)[1];
			if(vidCarVidId == firstCuedVidId){
				$(this).addClass('loaded');
			} else {
				$(this).removeClass('loaded');
			}
		});
		
		//behavior of the videos list
		$("#videos_list li").each(function(){
			//get the videoid from each li item
			var vidId = $(this).data('video_id');
			$(this).removeClass('inplayer');
			if(vidId == firstCuedVidId){
				$(this).addClass('inplayer');
			}
			//play the video on the player
			$(this).on("click", "img", function(){
				$("html, body").animate({
					scrollTop: $("#weeks_carousel_container").offset().top 
				},500);
				event.target.loadVideoById(vidId);
			}).on("click", "h3", function(){
				$("html, body").animate({
					scrollTop: $("#weeks_carousel_container").offset().top 
				},500);
				event.target.loadVideoById(vidId);
			});
		});
		
		
	} else {
		event.target.loadVideoById('a1NgU2LSIRc');
	}
	
	//load the filler video
	//when search is reset
	$('#reset_search').click(function(){
		event.target.loadVideoById('PcRBWsJPCZc');
	});
	
	//by default,
	//hide the "HIDE INFO" button
	$("#showinfo").show();
	$("#hideinfo").hide();
	//by default,
	//hide the "video_desc_list_container" section
	$("#video_desc_list_container").hide();
	
	//by default,
	//hide the "HIDE INFO" button
	$(window).resize(function(){
		$("#showinfo").show();
		$("#hideinfo").hide();
		$("#video_desc_list_container").hide();
	});
	
	//onclick, show descrip list
	$("#showinfo").click(function(){
		$(this).hide();
		$("#hideinfo").show();
		$("#video_desc_list_container").show();
	});
	
	//onclick, hide descrip list
	$("#hideinfo").click(function(){
		$(this).hide();
		$("#showinfo").show();
		$("#video_desc_list_container").hide();
	});
	
	
	
	
	//listen for custom events
	//'mh370.vidListRender'
	//and execute callbacks
	//(some repeating code here)
	
	//for the videos_list
	$('#videos_list').on('mh370.vidListRender', function(){
		
		if($("#videos_list li").length > 0){
			//get data for the first video to be cued
			var firstCuedVidId = $("#videos_list li").first().data('video_id');
			
			//extract the video_id
			//based on img src */
			var imgRegex = /https:\/\/i3.ytimg.com\/vi\/([\w-]{11})\/mqdefault.jpg/;
			//extract the video_id
			//based on img src
			
			event.target.cueVideoById(firstCuedVidId);
			
			//behavior of the video_desc_list
			$("#video_desc_list li").each(function(){
				var descItmVidId = $(this).data('video_id');
				if(descItmVidId == firstCuedVidId){
					$(this).show();
				} else {
					$(this).hide();
				}
			});
			
			//behavior of the videos_carousel
			$("#videos_carousel li").each(function(){
				var vidCarImgDat = $(this).find('img').attr('src');
				var vidCarVidId = vidCarImgDat.match(imgRegex)[1];
				if(vidCarVidId == firstCuedVidId){
					$(this).addClass('loaded');
				} else {
					$(this).removeClass('loaded');
				}
			});
			
			//behavior of the videos list
			$("#videos_list li").each(function(){
				//get the videoid from each li item
				var vidId = $(this).data('video_id');
				$(this).removeClass('inplayer');
				if(vidId == firstCuedVidId){
					$(this).addClass('inplayer');
				}
				//play the video on the player
				$(this).on("click", "img", function(){
					$("html, body").animate({
						scrollTop: $("#weeks_carousel_container").offset().top 
					},500);
					event.target.loadVideoById(vidId);
				}).on("click", "h3", function(){
					$("html, body").animate({
						scrollTop: $("#weeks_carousel_container").offset().top 
					},500);
					event.target.loadVideoById(vidId);
				});
			});
		} else {
			event.target.loadVideoById('a1NgU2LSIRc');
		}

		
		//load the filler video
		//when search is reset
		$('#reset_search').click(function(){
			event.target.loadVideoById('PcRBWsJPCZc');
		});
		
		
		//by default,
		//hide the "HIDE INFO" button
		$("#showinfo").show();
		$("#hideinfo").hide();
		//by default,
		//hide the "video_desc_list_container" section
		$("#video_desc_list_container").hide();
		
		//by default,
		//hide the "HIDE INFO" button
		$(window).resize(function(){
			$("#showinfo").show();
			$("#hideinfo").hide();
			$("#video_desc_list_container").hide();
		});
		
		//onclick, show descrip list
		$("#showinfo").click(function(){
			$(this).hide();
			$("#hideinfo").show();
			$("#video_desc_list_container").show();
		});
		
		//onclick, hide descrip list
		$("#hideinfo").click(function(){
			$(this).hide();
			$("#showinfo").show();
			$("#video_desc_list_container").hide();
		});
	});
}

function onPlayerStateChange(event){
	//if the video is PAUSED
	if(event.data === 2){
		var owl_vids_car = $('#videos_carousel');
		var owllicarloaded = $('#videos_carousel li.loaded').find('div').data('index');
		console.log('The index of the loaded video is ' + owllicarloaded);
		$('#videos_carousel').trigger('to.owl.carousel', [owllicarloaded]);
	}
	//if the video is PLAYING
	if(event.data === 1){
 		//get the YouTube URL of the video playing
		var vidurl = event.target.getVideoUrl();
		//console.info('The URL of the video playing is: ' + vidurl);
		//extract the video_id
		var regex = /v=([\w-]{11})/;
		var imgRegex = /https:\/\/i3.ytimg.com\/vi\/([\w-]{11})\/mqdefault.jpg/;
		var vidIdFrURI = vidurl.match(regex)[1];
		vidPlayed = vidIdFrURI;
		
		//behavior of the video_desc_list
		$("#video_desc_list li").each(function(){
			if($(this).data('video_id') == vidIdFrURI){
				$(this).show();
			} else {
				$(this).hide();
			}
		});
		
		//by default,
		//hide the "HIDE INFO" button
		$("#showinfo").show();
		$("#hideinfo").hide();
		//by default,
		//hide the "video_desc_list_container" section
		$("#video_desc_list_container").hide();
		
		//by default,
		//hide the "HIDE INFO" button
		$(window).resize(function(){
			$("#showinfo").show();
			$("#hideinfo").hide();
			$("#video_desc_list_container").hide();
		});
		
		//onclick, show descrip list
		$("#showinfo").click(function(){
			$(this).hide();
			$("#hideinfo").show();
			$("#video_desc_list_container").show();
		});
		
		//onclick, hide descrip list
		$("#hideinfo").click(function(){
			$(this).hide();
			$("#showinfo").show();
			$("#video_desc_list_container").hide();
		});
		
		//behavior of the videos_carousel
		$("#videos_carousel li").each(function(){
			var vidCarImgDat = $(this).find('img').attr('src');
			var vidCarVidId = vidCarImgDat.match(imgRegex)[1];
			if(vidCarVidId == vidIdFrURI){
				$(this).addClass('loaded');
			} else {
				$(this).removeClass('loaded');
			}
		});
		
		//behavior of the videos list
		$("#videos_list li").each(function(){
			//get the videoid from each li item
			var vidId = $(this).data('video_id');
			var topDistance = this.offsetTop;
			$(this).removeClass('inplayer');
			if(vidId == vidIdFrURI){
				$(this).addClass('inplayer');
				if(withScrollBar = true){
					$('#videos_list').scrollTop(topDistance);
				}
			}
		});
	}
	//if the video has ENDED
	if(event.data === 0){
		//extract the video_id
		//based on img src */
		var imgRegex = /https:\/\/i3.ytimg.com\/vi\/([\w-]{11})\/mqdefault.jpg/;
		var firstVidId = $('#videos_list li').first().data('video_id');
		var endOfUL = $('#videos_list li').last().data('video_id');
		
		$("#videos_list li").each(function(){
			var thisVidId = $(this).data('video_id');
			var nextVidId = $(this).next().data('video_id');
			if(vidPlayed === thisVidId){
				if($(this).data('video_id') == endOfUL){
					event.target.cueVideoById(firstVidId);
				} else {
					event.target.loadVideoById(nextVidId);
				}
			}
		});
	}
} 

//the custom event registered
/* $(document).on('ajaxSuccess', function(){
	$('#videos_list').trigger('mh370.vidListRender');
}); */
$(document).ajaxSuccess(function(event, xhr, settings){
	$('#videos_list').trigger('mh370.vidListRender');
	if(settings.url == "http://localhost/mh370/includes/gen_video_list.php"){
		withScrollBar = true;
	} else if(settings.url == "http://localhost/mh370/includes/search_return.php"){
		withScrollBar = false;
	}
});