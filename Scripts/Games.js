
$(document).ready(function () {
	/**
	 * Выбор даты матча
	 */
    $('#date').datetimepicker({ changeYear: true, changeMonth: true, timeFormat: 'hh:mm:ss', dateFormat: "yy-mm-dd",  yearRange: "y:+2y"});

  /**
   * При выборе команды хозяев выводим список игроков
   */
    $('#team_owner').change(function () {
    	$('#team_owner_start').attr('disabled', false);
    	var team_name = $('#team_owner :selected').html();
    	$.post('../Ajax/GamesAjax.php', { team_name : team_name, 
            								action : "showPlayers"},
            function(result) {
            	var options = '';
            	$(result.players).each(function() {
            		options += '<option value="' + $(this).attr('id_player') + '">' + $(this).attr('player_number') + ' ' + $(this).attr('player_name') + '</option>';
            	});
            	$('#team_owner_start').attr('size', 30);
            	$('#team_owner_start').html(options);
            	
            	$('#stadium').html($(result.stadium).attr('stadium_name'));
            	$("#stadium").tooltip({
        			txt: '<center>Вместительность - '+ $(result.stadium).attr('stadium_capacity') +'</center><br><img height="300px" width="300px" src="../Images/stadiums/' + $(result.stadium).attr('stadium_image') + '">'                
                 });
            }, "json");
    });
    
    /**
     * При выборе команды гостей выводим список игроков
     */
    $('#team_guest').change(function () {
    	$('#team_guest_start').attr('disabled', false);
    	var team_name = $('#team_guest :selected').html();
    	$.post('../Ajax/GamesAjax.php', { team_name : team_name, 
            								action : "showPlayers"},
            function(result) {
            	var options = '';
            	$(result.players).each(function() {
            		options += '<option value="' + $(this).attr('id_player') + '">' + $(this).attr('player_number') + ' ' + $(this).attr('player_name') + '</option>';
            	});
            	$('#team_guest_start').attr('size', 30);
            	$('#team_guest_start').html(options);
            }, "json");
    });
});

	function addGame(team_owner, team_guest, team_owner_start, team_guest_start, tour, referee, date, stadium) {
		if ($(team_owner).val() == 'Выберите команду...') {
			$("#errorChanging").remove();
			$(team_owner).before("<span id='errorChanging'>&nbsp;Выберите команду !<br></span>");
		}
		else if ($(team_guest).val() == 'Выберите команду...') {
			$("#errorChanging").remove();
			$(team_guest).before("<span id='errorChanging'>&nbsp;Выберите команду !<br></span>");
		}
		else if (($(team_owner_start).val() || []) == '') {
			$("#errorChanging").remove();
			$(team_owner_start).before("<span id='errorChanging'>&nbsp;Выберите игроков !<br></span>");
		}
		else if (($(team_guest_start).val() || []) == '') {
			$("#errorChanging").remove();
			$(team_guest_start).before("<span id='errorChanging'>&nbsp;Выберите игроков !<br></span>");
		}
		else if ($(tour).val() == 'Выберите тур...') {
			$("#errorChanging").remove();
			$(tour).before("<span id='errorChanging'>&nbsp;Выберите тур !<br></span>");
		}
		else if ($(referee).val() == 'Выберите судью...') {
			$("#errorChanging").remove();
			$(referee).before("<span id='errorChanging'>&nbsp;Выберите судью !<br></span>");
		}
		else if ($(date).val() == '') {
			$("#errorChanging").remove();
			$(date).before("<span id='errorChanging'>&nbsp;Выберите дату !<br></span>");
		}
		else
		$.post('../Ajax/GamesAjax.php', { team_owner_id : $(team_owner).val(), 
											team_guest_id : $(team_guest).val(),
											team_owner_start : $(team_owner_start).val() || [],
											team_guest_start : $(team_guest_start).val() || [],
											tour : $(tour).val(),
											id_referee : $(referee).val(),
											date : $(date).val(),					
											stadium_name : $(stadium).html(),
											action : "addGame"},
				function(result) {
					alert('Игра была успешно добавлена !');
					window.location.reload();
				});
	}
	
function scored_form() {
    $('#scored').modal();
}

function yellow_card_form() {
    $('#yellow_card').modal();
}

function red_card_form() {
    $('#red_card').modal();
}

function substitution_form() {
    $('#substitution').modal();
}

function penalty_shootout_form(id_game) {
    $.post('../Ajax/GamesAjax.php', {   id_game : id_game, 
		action : "penalty_shootout_start" },
	function(result) {
	});
    $('#penalty_shootout').modal();
}
function time_out(id_game) {
	$('#scored_button').hide();
	$('#yellow_card_button').hide();
	$('#red_card_button').hide();
	$('#substitution_button').hide();
	$('#end_of_match_button').hide();
	$('#time_out_button').hide();
	$('#penalty_shootout_button').hide();
	$("#time_out_end_button").show();
	$.post('../Ajax/GamesAjax.php', {   id_game : id_game, 
										action : "break" },
									function(result) {
									});
	
}
function end_of_match(id_game) {
	$('#scored_button').remove();
	$('#yellow_card_button').remove();
	$('#red_card_button').remove();
	$('#substitution_button').remove();
	$('#end_of_match_button').remove();
	$('#time_out_button').remove();
	$('#penalty_shootout_button').remove();
	$.post('../Ajax/GamesAjax.php', {   id_game : id_game, 
										action : "finished" },
									function(result) {
									});
}
function end_of_penalty_shootout(id_game) {
	$('#scored_button').remove();
	$('#yellow_card_button').remove();
	$('#red_card_button').remove();
	$('#substitution_button').remove();
	$('#end_of_match_button').remove();
	$('#time_out_button').remove();
	$('#penalty_shootout_button').remove();
	$.post('../Ajax/GamesAjax.php', {   id_game : id_game, 
										action : "finished" },
									function(result) {
									});
	window.location.reload();
}
function time_out_end(id_game) {
	$("#time_out_end_button").hide();
	$('#scored_button').show();
	$('#yellow_card_button').show();
	$('#red_card_button').show();
	$('#substitution_button').show();
	$('#end_of_match_button').show();
	$('#penalty_shootout_button').show();

	$('#time_out_button').show();
	$.post('../Ajax/GamesAjax.php', {   id_game : id_game, 
										action : "break_end" },
									function(result) {
									});
}
function penalty_scored(id_team, id_player, id_game) {
	$.post('../Ajax/GamesAjax.php', {   id_team : $(id_team).val(), 
										id_player : $(id_player).val(),
										id_game : id_game,
										action : "penalty_scored" },
										function(result) {
								        });
}
function penalty_not_scored(id_team, id_player, id_game) {
	$.post('../Ajax/GamesAjax.php', {   id_team : $(id_team).val(), 
										id_player : $(id_player).val(),
										id_game : id_game,
										action : "penalty_not_scored" },
										function(result) {
								        });
}
function scored(id_team, id_player, minute, id_game, own_goal, penalty) {
	var flag_own_goal = 0;
	var minute_string = $(minute).val();
	if ($(own_goal).attr('checked') != null) flag_own_goal = 1;
	if ($(penalty).attr('checked') != null) minute_string += "'' (pen.)";
	$.post('../Ajax/GamesAjax.php', {   id_team : $(id_team).val(), 
										id_player : $(id_player).val(),
										minute : minute_string,
										id_game : id_game,
										own_goal : flag_own_goal,
										action : "scored" },
										function(result) {
								        });
	window.location.reload();
}
function yellow_card(id_team, id_player, minute, id_game) {
	
	$.post('../Ajax/GamesAjax.php', {   id_team : $(id_team).val(), 
										id_player : $(id_player).val(),
										minute : $(minute).val(),
										id_game : id_game,
										action : "yellow_card" },
										function(result) {
								        });
	window.location.reload();
}

function red_card(id_team, id_player, minute, id_game) {
	
	$.post('../Ajax/GamesAjax.php', {   id_team : $(id_team).val(), 
										id_player : $(id_player).val(),
										minute : $(minute).val(),
										id_game : id_game,
										action : "red_card" },
										function(result) {
								        });
	window.location.reload();
}
function substitution(id_team, id_player, id_second_player, minute, id_game) {
	
	$.post('../Ajax/GamesAjax.php', {   id_team : $(id_team).val(), 
										id_player : $(id_player).val(),
										id_second_player : $(id_second_player).val(),
										minute : $(minute).val(),
										id_game : id_game,
										action : "substitution" },
										function(result) {
								        });
	window.location.reload();
}
function showTeamPlayers(selected_element, target_element) {
	$(target_element).attr('disabled', false);
	var team_name = $(selected_element + " option:selected").html();
	$.post('../Ajax/GamesAjax.php', { team_name : team_name, 
        								action : "showPlayers"},
        function(result) {
        	var options = '';
        	$(result.players).each(function() {
        		options += '<option value="' + $(this).attr('id_player') + '">' + $(this).attr('player_number') + ' ' + $(this).attr('player_name') + '</option>';
        	});
        	$(target_element).html(options);
        	$('#substitution_second_team_players').html(options);
        	$('#substitution_second_team_players').attr('disabled', false);

        }, "json");
}



function show_monthes(year, target, id_championship) {
	var selectedYear = $(year + ' :selected').html();
	$(target).attr('disabled', false);
	$.post('../Ajax/GamesAjax.php', { year : selectedYear, 
										id_championship : id_championship,
									  action : "showMonthes"},
									function(result) {
										var options = '';
										$(result.monthes).each(function() {
											options += '<option value="' + $(this).attr('month') + '">' + $(this).attr('month_name') + '</option>';
									});
				$(target).html("<option selected disabled>Выберите месяц...</option>" + options);
				}, "json");
}

function show_games(year, month, id_championship, div) {
	var selectedYear = $(year + ' :selected').html();
	var selectedMonth = $(month + ' :selected').val();
	$.post('../Ajax/GamesAjax.php', { 	year : selectedYear, 
										month : selectedMonth,
										id_championship : id_championship,
		  								action : "showArchive"},
		  								function(result) {
		  									$(div).html(result);
		  								});
}
