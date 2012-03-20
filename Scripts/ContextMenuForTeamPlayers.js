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
    
    // Редактирование чимени игрока
    function editPlayer(id_player, number) {
        // Выводим форму для редактирования
        $("span.player"+number).html("<form id='form_' action=''>" +
                "<input class='editPlayerInput' value='' id='playerName" + number + "' type='text'></form>");
        var name = $('#playerName' + number);
        var oldRes;
        // Получаем данные из TeamPlayersAjax.php
        $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, action : "showResult"}, function(result) {
            // Выводим данные полученные с TeamPlayersAjax.php
            name.val(result);
            oldRes = result;
        });
        
         $("#form_").submit(function () {
                // Если поле ввода пустое то выводим сообщение и заставляем ввести имя
                if (name.val() == "") {
                    //$("#editError" + number).html("Введите название чемпионата !");
                    $("#errorChanging").remove();
                    $("#playerName" + number).after("<span id='errorChanging' style='color:red;font-size:15px;'>&nbsp;Введите имя игрока !</span>");
                    $.post('../Ajax/TeamPlayersAjax.php', { id_player : id_player, action : "showResult"}, function(result) {
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
                                                        if (result == "error" && name.val() != oldRes) {
                                                            $("#errorChanging").remove();
                                                            $("#playerName" + number).after("<span id='errorChanging' style='color:red;font-size:15px;'>&nbsp;Игрок с таким именем уже существует !</span>");
                                                        }
                                                        else {
                                                            $("span.player" + number).html("<span class='player"+number+"'>" +
                                                                    "<a href='index.php?id_player="+id_player+"''>"+name.val()+"</a></span>");
                                                        }
                                                    });
                    
                    
                    return false;
                }
            });
    }
    
    