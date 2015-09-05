/*

JS/jQuery for search

*/

$(document).ready(function(){
	var search_input = {};
	var search_val = null;
	
	var filters_title = '<h6 id="filters_title">Filter Search Results</h6>';

	var filters = ['Breaking News','Headline News','Press Conference','News Feature','News Analysis','Official Communication','Tribute'];
	
	
	
	var total_entries,
		current_page,
		last_page;
	
	var prevPgBtn = '<div id="prevPgBtn">Prev Page</div>';
	var nextPgBtn = '<div id="nextPgBtn">Next Page</div>';
	
	
	function getSearchResults(search_obj){
		$.ajax({
			type: "POST",
			url: "http://localhost/mh370/includes/search_return.php",
			dataType: 'json',
			cache: false,
			data:search_obj,
			success: (function(data){
				$("#search_stats").empty();
				if(!data[1]['results'].length){
					$("#search_stats").html("<p>Sorry, no data found.</p>");
					$("#videos_list").empty();
				} else {
					//console.log(JSON.stringify(data));
					$("#videos_list").empty();
					$.each(data[1]['results'], function(){
						var search_li_item = "<li>";
						search_li_item += "<div>";
						search_li_item += "<img src='https://i3.ytimg.com/vi/" + this.video_id + "/mqdefault.jpg' alt='\"" + this.video_title + "\" thumbnail' width='150px' height='84px' longdesc='Thumbnail for the Youtube video of \"" + this.video_title + "\"'/>";
						search_li_item += "<h5>" + this.string_date_pub + "</h5>"; 
						search_li_item += "<h6>Week " + this.week_number + "</h6>";
						search_li_item += "</div>";
						search_li_item += "<div>";
						search_li_item += "</div>";
						search_li_item += "<h3>" + this.video_title + "</h3>";
						search_li_item += "<p>" + this.video_desc + "</p>";
						search_li_item += "<p><span class='source'>" + this.video_uploader + "</span>";
						search_li_item += "<span class='tag'>(" + this.tag + ")</span></p>";
						//START only for admin
						search_li_item += "<p><a href='admin/edit_video_entry.php?id=" + this.id + "'>Edit Video</a>";
						search_li_item += "<a href='admin/delete_video.php?id=" + this.id + "' onclick=\"return confirm('Are You Sure?')\">Delete Video</a></p>";
						//END only for admin
						search_li_item += "</li>";
						$("#videos_list").append(search_li_item);
					});	
				} 
				
				$('#videos_list').trigger('mh370.searchListRender');
			})
		});
	}
	
	$('#search_field').keypress(function(e){
		if(e.which == 13){
			
			//hide the 'per_wk_list'
			$('#per_wk_list').hide();
			
			//show all class 'show_hide' elements
			$('.show_hide').show();
			
			search_val = $('#search_field').val();
			if(search_val.length >= 3){
				
				$('#search_input_feedback').html('');
				
				search_input.keywords = search_val;
				search_input.curr_pg = '1';
				
				if($('#filter_boxes li').length === 0){
						//$(filters_title).remove();
						$(filters_title).insertBefore('#filter_boxes');
						$.each(filters, function(k, v){
						var value_lowercase = v.toLowerCase();
						var value_split_lc = value_lowercase.split(' ');
						var filter_item_id = value_split_lc.join('');
						var value_split = v.split(' ');
						var value_split_first = value_split[0].toLowerCase();
						var value_split_second = value_split[1];

						var filter_item = '';
						filter_item += '<li>';
						filter_item += '<input type="checkbox" id="';
						filter_item += filter_item_id;
						filter_item += '" name="';
						filter_item += value_split_first;
						if(value_split.length > 1){
							filter_item += value_split_second;
						}
						filter_item += '" />';
						filter_item += '<label for="';
						filter_item += filter_item_id;
						filter_item += '">';
						filter_item += v;
						filter_item += '</label>';
						filter_item += '</li>';
						$('#filter_boxes').append(filter_item);
						
						//search_input.filter_array = '';
					});
				}
				if($('#filter_boxes li').length > 1){
					var filter_checkboxes = $('#filter_boxes li input:checkbox');
					$(filter_checkboxes).each(function(){
						$(this).prop('checked', false);
					});
				}
				if(search_input.hasOwnProperty('filter_array')){
					delete search_input.filter_array;
				}
				
				console.log(JSON.stringify(search_input));
				getSearchResults(search_input);
			} else {
				$('#search_input_feedback').html('<p>Please enter 3 or more characters</p>');
				$('#videos_carousel').empty();
				$('#search_stats').html('');
				$('#prevPgBtn').remove();
				$('#nextPgBtn').remove();
				$('#pages_info p').empty();
				$('#videos_list').empty();
				
				if($('#filter_boxes li').length > 1){
					var filter_checkboxes = $('#filter_boxes li input:checkbox');
					$(filter_checkboxes).each(function(){
						$(this).prop('checked', false);
					});
				}
				
				
				search_input = {};
			}
		}
	});

	
	$('#videos_list').on('searchResults', function(){
		
		$('#nextPgBtn').click(function(){
			search_input.curr_pg = current_page + 1;
			//console.log(search_input);
			getSearchResults(search_input);
		});
		
		$('#prevPgBtn').click(function(){
			search_input.curr_pg = current_page - 1;
			//console.log(search_input);
			getSearchResults(search_input);
		});
				
		var filter_checkboxes = $('#filter_boxes li input:checkbox');
		
		function filterSearch(){
			var filter_options = [];
			$(filter_checkboxes).each(function(){
				var checkbox_index = $(this).closest('li').index();
				if($(this).is(':checked')){
					filter_options.push(filters[checkbox_index].toString());
				}
			});
			return filter_options;
		}
		
	
		$(filter_checkboxes).on('change', function(){
			//var opts = getEmployeeFilterOptions();
			var filter_strings = filterSearch();
			search_input.filter_array = filter_strings;
			search_input.curr_pg = '1';
			getSearchResults(search_input);
			console.log(JSON.stringify(search_input));
		});
		
		
		//for "Reset Search" button
		$('#reset_search').click(function(){
			$('#search_field').val('');
			$('#videos_carousel').empty();
			$(filters_title).remove();
			$('#search_stats').html('');
			$('#prevPgBtn').remove();
			$('#nextPgBtn').remove();
			$('#pages_info p').empty();
			$('#videos_list').empty();
			
			if($('#filter_boxes li').length > 1){
				var filter_checkboxes = $('#filter_boxes li input:checkbox');
				$(filter_checkboxes).each(function(){
					$(this).prop('checked', false);
				});
			}
			
			search_input = {};
		});
	});
	
	$(document).ajaxSuccess(function(event, xhr, settings){
		if(settings.url == "http://localhost/mh370/includes/search_return.php"){
			
			//var filter_checkboxes = $('#filter_boxes li input:checkbox');
				
			var data = JSON.parse(xhr.responseText);
			
			if(data[1]['results'].length){
				
				$(filters_title).remove();
				
				total_entries = data[0]['total_count'];
				current_page = data[0]['current_page'];
				last_page = data[0]['last_page'];
				
				$('#prevPgBtn').remove();
				$('#nextPgBtn').remove();
				
				if(last_page > 1){
					//console.log('The last page is greater than one and is = ' + last_page);
					if(current_page < last_page){
						$(nextPgBtn).insertAfter('#pages_info p');	
					}
					if(current_page == last_page){
						$('#nextPgBtn').remove();
					}
					if(current_page > 1){
						$(prevPgBtn).insertBefore('#pages_info p');
					}
				}
				
				$("#search_stats").html('<p>Yes, ' + total_entries + ' items found!</p>');
				
				$("#pages_info p").text(current_page + ' of ' + last_page + ' pages');
			
				$('#videos_list').trigger('searchResults');
			} else {
				$(filters_title).remove();
				$('#search_stats').html('');
				$('#prevPgBtn').remove();
				$('#nextPgBtn').remove();
				$('#pages_info p').html('');
				$("#search_stats").html('<p>Sorry, 0 items found.</p>');
				$('#videos_list').empty().trigger('searchResults');
			}
			
		}
		//console.log('total count is ' + data[0]['total_count']);
	});
	
});