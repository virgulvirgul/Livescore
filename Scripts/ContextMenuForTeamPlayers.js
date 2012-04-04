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
        $('#modalContent' + number).modal();
        showResults(id_player, number);
        return false;
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
                
                if (playerNumber.val() != "" && name.val() != "") {
                    $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, 
                                                    action : "edit", 
                                                    name : name.val(),
                                                    player_number : playerNumber.val(),
                                                    player_position : playerPosition },
                                                    ////// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
                                                    function(result) {
                                                        if (result == "errorName" && name.val() != oldName) {
                                                            $("#errorChanging").remove();
                                                            name.before("<span id='errorChanging'>&nbsp;Игрок с таким именем уже существует !<br><br></span>");
                                                        }
                                                        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                                                        else if (result == "errorNumber" && playerNumber.val() != oldNumber) {
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
    }
