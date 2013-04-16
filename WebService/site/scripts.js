
$(document).ready(function() {
			/**
 			* При наведениие на ячейку меняем её цвет
 			*/
	$('#lines_up').click(function () {
		$('#statistics_table').hide('slow');
		$('#previous_meetings_table').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#lines_up_table').show('slow');
		$('#championship_table_show').hide('slow');
		$('#video_broadcast_table').hide('slow');
		$('#game_statistics_table').hide('slow');
	});
	
	$('#statistics').click(function () {
		$('#statistics_table').show('slow');
		$('#previous_meetings_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#championship_table_show').hide('slow');
		$('#video_broadcast_table').hide('slow');
		$('#game_statistics_table').hide('slow');
	});
	$('#previous_meetings').click(function () {
		$('#previous_meetings_table').show('slow');
		$('#statistics_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#championship_table_show').hide('slow');
		$('#video_broadcast_table').hide('slow');
		$('#game_statistics_table').hide('slow');
	});
	$('#championship_table').click(function () {
		$('#championship_table_show').show('slow');
		$('#addition_info_table').hide('slow');
		$('#statistics_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#previous_meetings_table').hide('slow');
		$('#video_broadcast_table').hide('slow');
		$('#game_statistics_table').hide('slow');
	});
	$('#addition_info').click(function () {
		$('#championship_table_show').hide('slow');
		$('#addition_info_table').show('slow');
		$('#statistics_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#previous_meetings_table').hide('slow');
		$('#video_broadcast_table').hide('slow');
		$('#game_statistics_table').hide('slow');
	});
	$('#video_broadcast').click(function () {
		$('#video_broadcast_table').show('slow');
		$('#championship_table_show').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#statistics_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#previous_meetings_table').hide('slow');
		$('#game_statistics_table').hide('slow');
	});
	$('#game_statistics').click(function () {
		$('#game_statistics_table').show('slow');
		$('#statistics_table').hide('slow');
		$('#previous_meetings_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#championship_table_show').hide('slow');
		$('#video_broadcast_table').hide('slow');
	});
});