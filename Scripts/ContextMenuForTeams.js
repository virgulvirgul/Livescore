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
        $.post('../Scripts/TeamsAjax.php', { id_team : id_team, action : "showResult"}, function(result) {
            // Выводим данные полученные с TeamAjax.php
            name.val(result);
            oldRes = result;
        });
        var flag = true;
         $("#form_").submit(function () {
                // Если поле ввода пустое то выводим сообщение и заставляем ввести имя
                if (name.val() == "") {
                    //$("#editError" + number).html("Введите название чемпионата !");
                    $("#errorChanging").remove();
                    $("#teamName" + number).after("<span id='errorChanging' style='color:red;font-size:15px;'>&nbsp;Введите название команды !</span>");
                    $.post('../Scripts/TeamsAjax.php', { id_team : id_team, action : "showResult"}, function(result) {
                        // Выводим данные полученные с TeamAjax.php
                        name.val(result);
                    });
                    return false;
                }
                // При правильном вводе обновляем данные и закрываем окно редактирования
                else {
                    $.post('../Scripts/TeamsAjax.php', { id_team : id_team, 
                                                    action : "edit", 
                                                    name : name.val()},
                                                    function(result) {
                                                        if (result == "error" && name.val() != oldRes) {
                                                            $("#errorChanging").remove();
                                                            $("#teamName" + number).after("<span id='errorChanging' style='color:red;font-size:15px;'>&nbsp;Такая команда уже существует !</span>");
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
        $.post('../Scripts/TeamsAjax.php', { id_team : id_team, 
                                             action : "delete"});
        window.location.reload();
    }
}

function addTeam(id_championship, inputElement, formName) {
    var input = $(inputElement);
    var form = $(formName);
        if (input.val() == "")  
            {
                $("#errorAdding").remove();
                input.before("<span id='errorAdding' style='color:red;font-size:15px;'>&nbsp;Введите название !<br><br></span>");
            }
        else {
            $.post('../Scripts/TeamsAjax.php', { id_championship : id_championship, 
                                            name : input.val(),
                                            action : "addTeam"},
                                            function(result) {
                                                if (result == "error") {
                                                    
                                                $("#errorAdding").remove();
                                                input.before("<span id='errorAdding' style='color:red;font-size:15px;'>" +
                                                        "&nbsp;Такая команда уже существует !<br><br></span>");
                                                }
                                                else {
                                                    window.location.reload();
                                                }
                                            });
            input.val("");
            $("#errorAdding").remove();
        }
}

function showModalForTeams(id_team, number) {
        $('#modalContent' + number).modal();
        return false;
}

function moveTeam(id_team, number) {
    alert($("#selectChamps"+number+" :selected").html());  
    $("#selectChamps"+number).empty();
   // alert($('#europeSelect'+number+' option:selected').html());  
}
