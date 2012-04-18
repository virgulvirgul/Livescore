
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

	function ololo1(input) {
		alert(input);
	   
	}


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
function scored(id_team, id_player, minute, id_game) {
	
	$.post('../Ajax/GamesAjax.php', {   id_team : $(id_team).val(), 
										id_player : $(id_player).val(),
										minute : $(minute).val(),
										id_game : id_game,
										action : "scored" },
										function(result) {
								        	alert(result);
								        });
}
function showTeamPlayers(selected_element, target_element) {
	$(target_element).attr('disabled', false);
	var team_name = $(selected_element + ":selected").html();
	$.post('../Ajax/GamesAjax.php', { team_name : team_name, 
        								action : "showPlayers"},
        function(result) {
        	var options = '';
        	$(result.players).each(function() {
        		options += '<option value="' + $(this).attr('id_player') + '">' + $(this).attr('player_number') + ' ' + $(this).attr('player_name') + '</option>';
        	});
        	$(target_element).html(options);
        }, "json");
}