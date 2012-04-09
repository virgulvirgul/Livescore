$(document).ready(function() {
		$('span').each(function(i) {
			$('.player'+i).contextMenu('playerContextMenu'+i, {

      bindings: {

        'Edit': function(t) {
        },

        'Delete': function(t) {
        },

      }
    })})});
    
    function showModalForEditPlayer(id_player, number) {
        $('#modalEditContent' + number).modal();
        showResults(id_player, number);
        return false;
    }
    function showModalForMovePlayer(id_player, number) {
    	selectValues(id_player, number);
        $('#modalMoveContent' + number).modal();
    	return false;
    }
    function showModalForAddTeamPlayer(id_team) {
        $('#modalAddTeamPlayerContent').modal();
        $('#simplemodal-container').css({'height' : '400px'});
        $('#addTeamPlayerBirth').datepicker({ changeYear: true, changeMonth: true, dateFormat: "yy-mm-dd",  yearRange: "1960:-15y"});
        return false;
    }
    function selectValues(id_player, number) {
    	/*var continents = $('#selectContinent' + number);
    	var countries = $('#selectCountry' + number);
    	var championships = $('#selectChampionship' + number);
    	var teams = $('#selectTeam' + number);
    	
    	 $.post('../Ajax/TeamPlayersAjax.php', {action : "showContinents"}, function(result) {
             // Выводим данные полученные с TeamPlayersAjax.php
             var options = '<option disabled selected>Выберите континент</option>';
             
    		 $(result.continents).each(function() {
                 options += '<option>' + $(this).attr('name') + '</option>';
             });
    		 continents.html(options);
         }, "json");
    	 
    	 continents.change(function () {
    		 $.post('../Ajax/TeamPlayersAjax.php', {action : "showCountries", continent_name : continents.val()}, function(result) {
                 // Выводим данные полученные с TeamPlayersAjax.php
                 var options = '<option disabled selected>Выберите страну</option>';
                 
        		 $(result.countries).each(function() {
                     options += '<option>' + $(this).attr('name') + '</option>';
                 });
        		 countries.html(options);
        		 countries.attr('disabled', false);
             }, "json");
    	 });
    	 /// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
    	$('#movePlayerTeam' + number).autocomplete("../Scripts/autocomplete.php", {
    		delay:10,
    		minChars:2,
    		matchSubset:1,
    		autoFill:true,
    		matchContains:1,
    		cacheLength:10,
    		selectFirst:true,
    		formatItem:liFormat,
    		maxItemsToShow:10,
    	}); 
    }
    
    function liFormat (row, i, num) {
    	var result = row[0] + '<div class=showChampName>' + row[1] + '</div>';
    	return result;
    }
    
    var oldName, oldNumber;

    function showResults(id_player, number) {
        var name = $('#editPlayerName' + number);
        var number = $('#editPlayerNumber' + number);
        // Получаем данные из TeamPlayersAjax.php
        // Получаем имя игрока
        $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, action : "showPlayerName"}, function(result) {
            // Выводим данные полученные с TeamPlayersAjax.php
            name.val(result);
            oldName = result;
        });
        // Получаем номер игрока
         $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, action : "showPlayerNumber"}, function(result) {
            // Выводим данные полученные с TeamPlayersAjax.php
            number.val(result);
            oldNumber = result;
        });
    }
    function editPlayer(id_player, number, id_team) {
        // Выводим форму для редактирования
        var name = $('#editPlayerName' + number);
        var playerNumber = $('#editPlayerNumber' + number);
        var playerPosition = $('#editPlayerPosition' + number + " :selected").html();
                // Если поле ввода пустое то выводим сообщение и заставляем ввести имя
                if (name.val() == "") {
                    //$("#editError" + number).html("Введите название чемпионата !");
                    $("#errorChanging").remove();
                    name.before("<span id='errorChanging'>&nbsp;Введите имя игрока !<br><br></span>");
                    $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, action : "showPlayerName"}, function(result) {
                        // Выводим данные полученные с TeamAjax.php
                        name.val(result);
                    });
                    return false;
                }

              // Если поле ввода пустое то выводим сообщение и заставляем ввести имя
                if (playerNumber.val() == "") {
                    $("#errorChanging").remove();
                    playerNumber.before("<span id='errorChanging'>&nbsp;Введите номер игрока !<br><br></span>");
                    $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, action : "showPlayerNumber"}, function(result) {
                        // Выводим данные полученные с TeamAjax.php
                        playerNumber.val(result);
                    });
                    return false;
                }
                if (name.val() != "" && name.val() != oldName) {
                    $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, 
                                                    action : "edit", 
                                                    name : name.val()},
                                                    ////// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
                                                    function(result) {
                                                        if (result == "errorName") {
                                                            $("#errorChanging").remove();
                                                            name.before("<span id='errorChanging'>&nbsp;Игрок с таким именем уже существует !<br><br></span>");
                                                        }
                                                        else {
                                                           // $("span.player" + number).html("<span class='player"+number+"'>" +
                                                            //        "<a href='index.php?id_player="+id_player+"''>"+name.val()+"</a></span>");
                                                            window.location.reload();
                                                        }
                                                    });
                    
                    
                    return false;
                }
                
                if (playerNumber.val() != "" && playerNumber.val() != oldNumber) {
                    $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, 
                                                    action : "edit",
                                                    player_number : playerNumber.val(), 
                                                    id_team: id_team},
                                                    ////// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
                                                    function(result) {
                                                        if (result == "errorNumber") {
                                                            $("#errorChanging").remove();
                                                            playerNumber.before("<span id='errorChanging'> &nbsp;Игрок с таким номером уже существует !<br><br></span>");
                                                        }
                                                        else {
                                                            window.location.reload();
                                                        }
                                                    });
                    
                    
                    return false;
                }
                
                if (playerPosition != "Выберите амплуа...") {
                    $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, 
                                                    action : "edit",
                                                    player_position : playerPosition},
                                                    ////// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
                                                    function(result) {
                                                            window.location.reload();
                                                    });
                    
                    
                    return false;
                }
    }

    
    function movePlayer(id_player, number) {
    	
        var teamName = $('#movePlayerTeam' + number);
        var playerNumber = $('#movePlayerNumber' + number);
        var playerPosition = $('#movePlayerPosition' + number + " :selected").html();
                // Если поле ввода пустое то выводим сообщение и заставляем ввести имя
                if (teamName.val() == "") {
                    //$("#editError" + number).html("Введите название чемпионата !");
                    $("#errorChanging").remove();
                    teamName.before("<span id='errorChanging'>&nbsp;Введите имя команды !<br><br></span>");
                    return false;
                }

              // Если поле ввода пустое то выводим сообщение и заставляем ввести имя
                if (playerNumber.val() == "") {
                    $("#errorChanging").remove();
                    playerNumber.before("<span id='errorChanging'>&nbsp;Введите номер игрока !<br><br></span>");
                    return false;
                }
                
                if (playerPosition == "Выберите амплуа...") {
                    $("#errorChanging").remove();
                    $('#movePlayerPosition' + number).before("<span id='errorChanging'>&nbsp;Выберите амплуа !<br><br></span>");
                    return false;
                }
                
                if (playerNumber.val() != "" && teamName.val() != "" && playerPosition != "Выберите амплуа...") {
                    $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, 
                                                    action : "move",
                                                    team_name: teamName.val(),
                                                    player_number : playerNumber.val(),
                                                    player_position : playerPosition},
                                                    function(result) {
                                                    	if (result == "errorTeamName") {
                                                    		 $("#errorChanging").remove();
                                                             teamName.before("<span id='errorChanging'>&nbsp;Такой команды не существует !<br><br></span>");
                                                    	}
                                                    	else
                                                        if (result == "errorNumber") {
                                                            $("#errorChanging").remove();
                                                            playerNumber.before("<span id='errorChanging'> &nbsp;Игрок с таким номером уже существует !<br><br></span>");
                                                        }
                                                        else {
                                                           // $("span.player" + number).html("<span class='player"+number+"'>" +
                                                            //        "<a href='index.php?id_player="+id_player+"''>"+name.val()+"</a></span>");
                                                            window.location.reload();
                                                        }
                                                    });
                    

                    return false;
                }
    }

    function deletePlayer(id_player) {
        if (confirm('Вы уверены что хотите удалить игрока ?') == true) {
            $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, 
                                                 action : "delete"});
            window.location.reload();
        }
    }
    
    function addTeamPlayer(id_team) {
    	 var playerName = $('#addTeamPlayerName');
    	 var playerBirth = $('#addTeamPlayerBirth');
         var playerNumber = $('#addTeamPlayerNumber');
         var playerPosition = $('#addTeamPlayerPosition :selected').html();
         
         // Если поле ввода пустое то выводим сообщение и заставляем ввести имя
         if (playerName.val() == "") {
             //$("#editError" + number).html("Введите название чемпионата !");
             $("#errorChanging").remove();
             playerName.before("<span id='errorChanging'>&nbsp;Введите имя игрока !<br><br></span>");
             return false;
         }
         if (playerNumber.val() == "") {
             //$("#editError" + number).html("Введите название чемпионата !");
             $("#errorChanging").remove();
             playerNumber.before("<span id='errorChanging'>&nbsp;Введите номер игрока !<br><br></span>");
             return false;
         }
         if (playerBirth.val() == "") {
             //$("#editError" + number).html("Введите название чемпионата !");
             $("#errorChanging").remove();
             playerBirth.before("<span id='errorChanging'>&nbsp;Введите дату рождения игрока !<br><br></span>");
             return false;
         }
         if (playerPosition == "Выберите амплуа...") {
             $("#errorChanging").remove();
             $('#addTeamPlayerPosition').before("<span id='errorChanging'>&nbsp;Выберите амплуа !<br><br></span>");
             return false;
         }
         if (playerName.val() != "" && playerNumber != "" && playerBirth != "" && playerPosition != "Выберите амплуа...") {
             $.post('../Ajax/TeamPlayersAjax.php', {id_team: id_team,
            	 							 action : "add", 
                                             name : playerName.val(),
                                             player_number : playerNumber.val(),
                                             player_birth : playerBirth.val(),
                                             player_position : playerPosition},
                                             ////// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
                                             function(result) {
                                                 if (result == "errorName") {
                                                     $("#errorChanging").remove();
                                                     playerName.before("<span id='errorChanging'>&nbsp;Игрок с таким именем уже существует !<br><br></span>");
                                                 }
                                                 else if (result == "errorNumber") {
                                                     $("#errorChanging").remove();
                                                     playerNumber.before("<span id='errorChanging'> &nbsp;Игрок с таким номером уже существует !<br><br></span>");
                                                 }
                                                 else {
                                                      window.location.reload();
                                                  }
                                             });
             
             
             return false;
         }
    }