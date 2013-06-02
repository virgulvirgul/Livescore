
$(document).ready(function() {
	$("a").easyTooltip();
	
	$('#lines_up').click(function () {
		$('#statistics_table').hide('slow');
		$('#previous_meetings_table').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#lines_up_table').show('slow');
		$('#championship_table_show').hide('slow');
		$('#video_broadcast_table').hide('slow');
		$('#game_statistics_table').hide('slow');
		$('#players_statistics_table').hide('slow');

	});
	
	$('#statistics').click(function () {
		$('#statistics_table').show('slow');
		$('#previous_meetings_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#championship_table_show').hide('slow');
		$('#video_broadcast_table').hide('slow');
		$('#game_statistics_table').hide('slow');
		$('#players_statistics_table').hide('slow');

	});
	$('#previous_meetings').click(function () {
		$('#previous_meetings_table').show('slow');
		$('#statistics_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#championship_table_show').hide('slow');
		$('#video_broadcast_table').hide('slow');
		$('#game_statistics_table').hide('slow');
		$('#players_statistics_table').hide('slow');

	});
	$('#championship_table').click(function () {
		$('#championship_table_show').show('slow');
		$('#addition_info_table').hide('slow');
		$('#statistics_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#previous_meetings_table').hide('slow');
		$('#video_broadcast_table').hide('slow');
		$('#game_statistics_table').hide('slow');
		$('#players_statistics_table').hide('slow');

	});
	$('#addition_info').click(function () {
		$('#championship_table_show').hide('slow');
		$('#addition_info_table').show('slow');
		$('#statistics_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#previous_meetings_table').hide('slow');
		$('#video_broadcast_table').hide('slow');
		$('#game_statistics_table').hide('slow');
		$('#players_statistics_table').hide('slow');

	});
	$('#video_broadcast').click(function () {
		$('#video_broadcast_table').show('slow');
		$('#championship_table_show').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#statistics_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#previous_meetings_table').hide('slow');
		$('#game_statistics_table').hide('slow');
		$('#players_statistics_table').hide('slow');

	});
	$('#game_statistics').click(function () {
		$('#game_statistics_table').show('slow');
		$('#statistics_table').hide('slow');
		$('#previous_meetings_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#championship_table_show').hide('slow');
		$('#video_broadcast_table').hide('slow');
		$('#players_statistics_table').hide('slow');

	});
	$('#players_statistics').click(function () {
		$('#players_statistics_table').show('slow');
		$('#statistics_table').hide('slow');
		$('#previous_meetings_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#championship_table_show').hide('slow');
		$('#video_broadcast_table').hide('slow');
		$('#game_statistics_table').hide('slow');
	});

	$('#strikers_statistics').click(function () {
		$('#strikers_statistics_table').show('slow');
		$('#yellow_cards_statistics_table').hide('slow');
		$('#red_cards_statistics_table').hide('slow');
	});
	$('#yellow_cards_statistics').click(function () {
		$('#strikers_statistics_table').hide('slow');
		$('#yellow_cards_statistics_table').show('slow');
		$('#red_cards_statistics_table').hide('slow');
	});
	$('#red_cards_statistics').click(function () {
		$('#strikers_statistics_table').hide('slow');
		$('#yellow_cards_statistics_table').hide('slow');
		$('#red_cards_statistics_table').show('slow');
	});
	
	
});
function changeActive(element) {
	$("#td_" + $(element).attr("id")).css('background-color', '#D0F500');
	$(element).css('color', 'black');
	
	if ($(element).attr("id") == "strikers_statistics") {
		$("#td_yellow_cards_statistics").css('background', 'url(images/news-divider.gif) repeat-x 0 bottom');
		$("#yellow_cards_statistics").css('color', '#D0F500');
		$("#td_red_cards_statistics").css('background', 'url(images/news-divider.gif) repeat-x 0 bottom');
		$("#red_cards_statistics").css('color', '#D0F500');
	} else if ($(element).attr("id") == "yellow_cards_statistics") {
		$("#td_strikers_statistics").css('background', 'url(images/news-divider.gif) repeat-x 0 bottom');
		$("#strikers_statistics").css('color', '#D0F500');
		$("#td_red_cards_statistics").css('background', 'url(images/news-divider.gif) repeat-x 0 bottom');
		$("#red_cards_statistics").css('color', '#D0F500');
	} else {
		$("#td_strikers_statistics").css('background', 'url(images/news-divider.gif) repeat-x 0 bottom');
		$("#strikers_statistics").css('color', '#D0F500');
		$("#td_yellow_cards_statistics").css('background', 'url(images/news-divider.gif) repeat-x 0 bottom');
		$("#yellow_cards_statistics").css('color', '#D0F500');
	}
	
}
/*function getTooltipForGame(number, team_owner_name, team_guest_name, team_owner_score, 
							team_guest_score, id_game) {
	$("#show_game" + number).tooltip({
		txt: team_owner_name + ' ' + team_owner_score + ' - ' + team_guest_score + ' ' + team_guest_name,            
		effect: 'fadeIn'
	});
}*/

function getTooltipForGame(number, team_owner_name, team_guest_name, team_owner_score, 
		team_guest_score, id_game, date) {
$("#show_game" + number).easyTooltip({
	content: '<center>' + team_owner_name + ' <u>' + team_owner_score + ' - ' + team_guest_score + '</u> ' + team_guest_name + ' (' + date + ')</center>',
	xOffset: -250,
	yOffset: 50,
	clickRemove: true
});
}