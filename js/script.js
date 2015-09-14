$(document).ready(function(){
	
	
	function populateVideoList(obj){
		$("#videos_list").empty();
		$.ajax({
			type: "POST",
			url: "http://localhost/mh370/includes/gen_video_list.php",
			dataType: 'json',
			cache: false,
			data:obj,
			success: (function(data){
				$("#videos_list").empty();
				if(!data.length){
					$("#videos_list").html("<li>Sorry, no data found.</li>");
				} else {
					$.each(data, function(k,v){
						var video_item = "<li data-video_id='" + v.video_id + "'>";
						video_item += "<div>";
						video_item += "<img src='https://i3.ytimg.com/vi/" + v.video_id + "/mqdefault.jpg' alt='\"" + v.video_title + "\" thumbnail' width='150px' height='84px' longdesc='Thumbnail for the Youtube video of \"" + v.video_title + "\"'/>";
						video_item += "<h5>" + v.string_date_pub + "</h5>";	
						video_item += "<h6>Week " + v.week_number + "</h6>";
						video_item += "</div>";
						video_item += "<div>";
						video_item += "</div>";
						video_item += "<h3>" + v.video_title + "</h3>";
						video_item += "<p>" + v.video_desc + '</p>';
						video_item += "<p><span class='source'>" + v.video_uploader + "</span>";
						video_item += "<span class='tag'>(" + v.tag + ")</span></p>";
						video_item += "</li>";
						$("#videos_list").append(video_item);
					});	
				}
				
			})
		});
	}
	
	//slicknav for login_splash
	$(function(){
		$('#normal_login').slicknav({
			label: 'Login',
			prependTo:'#login_splash',
			init: function(){
					$(window).resize(function(){
						$('#normal_login').slicknav('close');
					});
				},
			afterOpen: function(trigger){
					$('.slicknav_menu span.slicknav_menutxt').html('Close');
					$('.slicknav_nav form ul').eq(1).find('li').children().css({
						'display': 'inline'
					});
				},
			afterClose: function(trigger){
					$('.slicknav_menu span.slicknav_menutxt').html('Login');
				}
		});
	});
	
	
	
	//clear the value
	//of the search field
	$('#search_field').val('');
	
	//Build the RegExp function
	//for each item in the
	//#weeks_carousel_menu list
	var wkslistregex = /(\d{1,3})-(\d{1,3})/; //regular expression to isolate the numbers
	
	function make_wk_st_wk_end_obj(start, end, ordering){
		var wk_st_wk_end_obj = {};
		wk_st_wk_end_obj.week_start = start;
		wk_st_wk_end_obj.week_end = end;
		wk_st_wk_end_obj.week_order = ordering;
		return wk_st_wk_end_obj;
	}
	
	//add a 'selected' class
	//to the first or last li item
	//in the 'weeks_carousel_menu' menu
	//depending on the sort order
	if (week_order === 'ASC'){
		$("#weeks_carousel_menu li").first().addClass('selected');
	} else if(week_order === 'DESC'){
		$("#weeks_carousel_menu li").last().addClass('selected');
	}
	
	
	var wk_st_wk_end_data = $("#weeks_carousel_menu li.selected").text();
	var wk_st_regex_match = wk_st_wk_end_data.match(wkslistregex)[1];
	var wk_end_regex_match = wk_st_wk_end_data.match(wkslistregex)[2];
	var wk_st_wk_end_post = make_wk_st_wk_end_obj(wk_st_regex_match, wk_end_regex_match, week_order);
	
	//populate the ul 'videos_list'
	//by default parameters
	populateVideoList(wk_st_wk_end_post);
	
	$('#back_to_top_btn div p').click(function(){
		$("html, body").animate({
			scrollTop: $("#weeks_carousel_container").offset().top 
		},500);
	});
	
	$('#videos_list').on('mh370.weekListRender', function(){
		
		$("#weeks_carousel_menu li").each(function(){
			$(this).on("click", function(){	
				$("#weeks_carousel_menu").find("li").removeClass("selected");
				$(this).addClass('selected');
				var wk_st_wk_end_data = $(this).text();
				var wk_st_regex_match = wk_st_wk_end_data.match(wkslistregex)[1];
				var wk_end_regex_match = wk_st_wk_end_data.match(wkslistregex)[2];
				var wk_st_wk_end_post = make_wk_st_wk_end_obj(wk_st_regex_match, wk_end_regex_match, week_order);
				
				//populate the videos_list
				//again, given user-determined parameters
				populateVideoList(wk_st_wk_end_post);
			});
		});
		
		$('#weeks_carousel_menu li').each(function(){
			if($(this).hasClass('selected')){
				var wk_st_wk_end_data = $(this).text();
				var wk_st_regex_match = wk_st_wk_end_data.match(wkslistregex)[1];
				var wk_st_int = parseInt(wk_st_regex_match, 10);
				var wk_limit = wk_st_int + 4;
				for(w = wk_st_int; w < wk_limit; w++){
					var wk_list_item = '<li>';
					wk_list_item += '<p>Week ' + w + '</p>';
					wk_list_item += '</li>';
					$('#per_wk_list').append(wk_list_item);
				}
			}
		});
	});
	
	$(document).ajaxSuccess(function(event, xhr, settings){
		if(settings.url == "http://localhost/mh370/includes/gen_video_list.php"){
			
			//clear the value
			//of the search field
			$('#search_field').val('');

			$('#search_stats').html('');
			$('#prevPgBtn').remove();
			$('#nextPgBtn').remove();
			$('#pages_info p').empty();
			
			if($('#filter_boxes li').length > 1){
				var filter_checkboxes = $('#filter_boxes li input:checkbox');
				$(filter_checkboxes).each(function(){
					$(this).prop('checked', false);
				});
			}
			
			//delete any html found
			//in the 'search_input_feedback' element
			$('#search_input_feedback, #filter_boxes').html('');
			$('#filters_title').remove();
			
			$('.show_hide').hide();
			$('.special_show_hide').show();
			
			$('#videos_list li').each(function(){
				$(this).attr('data-index', $(this).index());
				var srcUrl = $(this).find('img').attr('src');
				var imgContainer = $(this);
			});
			
			$('#per_wk_list').show().empty();
			
			if($('#per_wk_list_container').is(':hidden')){
				$('#per_wk_list_container').show();
			}

			$('#videos_list').trigger('mh370.weekListRender');
		}
	});
}); 