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
    	$('#simplemodal-container').css({'height' : '550px'});
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
    	$('#selectTeam' + number).autocompleteArray([
	    "Магадан",
	    "Магас",
	    "Магнитогорск", ],
	    	    {
    			    delay:10,
    			    minChars:1,
    			    matchSubset:1,
    			    autoFill:true,
    			    maxItemsToShow:10
    			    });
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
    function editPlayer(id_player, number) {
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
                                                    player_position : playerPosition},
                                                    ////// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
                                                    function(result) {
                                                        if (result == "errorNumber") {
                                                            alert ('ololo');
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
