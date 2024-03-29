$(document).ready(function() {
        $('span').each(function(i) {
            $('.team'+i).contextMenu('teamContextMenu'+i, {

      bindings: {

        'Edit': function(t) {
        },

        'Delete': function(t) {
        },

      }

    })})});
    
// Редактирование чемпионата
    function editTeam(id_team, number) {
        // Выводим форму для редактирования
        $("span.team"+number).html("<form id='form_' action=''>" +
                "<input class='editTeamInput' value='' id='teamName" + number + "' type='text'></form>");
        var name = $('#teamName' + number);
        var oldRes;
        // Получаем данные из TeamAjax.php
        $.post('../Ajax/TeamsAjax.php', { id_team : id_team, action : "showResult"}, function(result) {
            // Выводим данные полученные с TeamAjax.php
            name.val(result);
            oldRes = result;
        });
         $("#form_").submit(function () {
                // Если поле ввода пустое то выводим сообщение и заставляем ввести имя
                if (name.val() == "") {
                    //$("#editError" + number).html("Введите название чемпионата !");
                    $("#errorChanging").remove();
                    $("#teamName" + number).after("<span id='errorChanging'>&nbsp;Введите название команды !</span>");
                    $.post('../Ajax/TeamsAjax.php', { id_team : id_team, action : "showResult"}, function(result) {
                        // Выводим данные полученные с TeamAjax.php
                        name.val(result);
                    });
                    return false;
                }
                // При правильном вводе обновляем данные и закрываем окно редактирования
                else {
                    $.post('../Ajax/TeamsAjax.php', { id_team : id_team, 
                                                    action : "edit", 
                                                    name : name.val()},
                                                    function(result) {
                                                        if (result == "error" && name.val() != oldRes) {
                                                            $("#errorChanging").remove();
                                                            $("#teamName" + number).after("<span id='errorChanging'>&nbsp;Такая команда уже существует !</span>");
                                                        }
                                                        else {
                                                            $("span.team" + number).html("<span class='team"+number+"'>" +
                                                                    "<a href='index.php?id_team="+id_team+"''>"+name.val()+"</a></span>");
                                                        }
                                                    });
                    
                    
                    return false;
                }
            });
    }
    
function deleteTeam(id_team, number) {
    if (confirm('Вы уверены что хотите удалить команду ?') == true) {
        $.post('../Ajax/TeamsAjax.php', { id_team : id_team, 
                                             action : "delete"});
        window.location.reload();
    }
}

function addTeam(id_championship, inputElement, formName) {
    var input = $(inputElement);
    var form = $(formName);
        if (input.val() == "")  
            {
                $("#errorChanging").remove();
                input.before("<span id='errorChanging'>&nbsp;Введите название !<br><br></span>");
            }
        else {
            $.post('../Ajax/TeamsAjax.php', { id_championship : id_championship, 
                                            name : input.val(),
                                            action : "addTeam"},
                                            function(result) {
                                                if (result == "error") {
                                                $("#errorChanging").remove();
                                                input.before("<span id='errorChanging'>" +
                                                        "&nbsp;Такая команда уже существует !<br><br></span>");
                                                }
                                                else {
                                                    window.location.reload();
                                                }
                                            });
            input.val("");
            $("#errorChanging").remove();
        }
}

function showModalForTeams(id_team, number) {
        $('#modalContent' + number).modal();
        return false;
}

function moveTeam(id_team, number, currentChampId) {
    var champName = $("#selectChamps"+number+" :selected").html();
    var europeChampName = $("#selectEuropeChamps"+number+" :selected").html();
    if (champName == "Выберите чемпионат..." && (europeChampName == "Выберите международный чемпионат..." 
                || europeChampName == null) ) {
        $("#errorChanging").remove();
        $("#selectChamps"+number).before("<span id='errorChanging'>" +
                                                        "&nbsp;Вы не выбрали чемпионат !<br><br></span>");
    }
    else {
        $.post('../Ajax/TeamsAjax.php', { champName : champName,
                                            europeChampName : europeChampName,
                                            currentChampId : currentChampId,
                                            id_team : id_team,
                                            action : "moveTeam"});
        window.location.reload();
    }
}
