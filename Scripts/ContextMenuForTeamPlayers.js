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
        
                // Если поле ввода пустое то выводим сообщение и заставляем ввести имя
                if (name.val() == "") {
                    //$("#editError" + number).html("Введите название чемпионата !");
                    $("#errorChanging").remove();
                    $("#editPlayerName" + number).before("<span id='errorChanging'>&nbsp;Введите имя игрока !<br><br></span>");
                    $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, action : "showPlayerName"}, function(result) {
                        // Выводим данные полученные с TeamAjax.php
                        name.val(result);
                    });
                    return false;
                }
                // При правильном вводе обновляем данные и закрываем окно редактирования
                else {
                    $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, 
                                                    action : "edit", 
                                                    name : name.val()},
                                                    function(result) {
                                                        if (result == "error" && name.val() != oldName) {
                                                            $("#errorChanging").remove();
                                                            $("#editPlayerName" + number).before("<span id='errorChanging' style='color:red;font-size:15px;'>&nbsp;Игрок с таким именем уже существует !<br><br></span>");
                                                        }
                                                        else {
                                                           // $("span.player" + number).html("<span class='player"+number+"'>" +
                                                            //        "<a href='index.php?id_player="+id_player+"''>"+name.val()+"</a></span>");
                                                        }
                                                    });
                    
                    
                    return false;
                }
    }
