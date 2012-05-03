$(document).ready(function() {
    $('#newRefereeBirth').datepicker({ changeYear: true, changeMonth: true, dateFormat: "yy-mm-dd",  yearRange: "1960:-15y"});
		$('span').each(function(i) {
			$('.referee'+i).contextMenu('refereesContextMenu'+i, {

      bindings: {

        'Edit': function(t) {
        },

        'Delete': function(t) {
        },

      }

    })})});

//Редактирование судьи
function editReferee(id_referee, number) {
	// Выводим форму для редактирования
	$("span.referee"+number).html("<form id='form_'>" +
			"<input class='editRefereeInput' value='' id='refereeName" + number + "' type='text'></form>");
	var name = $('#refereeName' + number);
	var oldName;
	// Получаем данные из RefereesAjax.php
	$.post('../Ajax/RefereesAjax.php', { id_referee : id_referee, action : "showResult"}, function(result) {
	    // Выводим данные полученные с RefereeesAjax.php
		name.val(result);
		oldName = result;
	});
	 $("#form_").submit(function () {
	    	// Если поле ввода пустое то выводим сообщение и заставляем ввести имя
		 	if (name.val() == "") {
		 		//$("#editError" + number).html("Введите название чемпионата !");
		 		$("#errorChanging").remove();
		 		$("#refereeName" + number).after("<span id='errorChanging' >&nbsp;Введите имя судьи !</span>");
		 		$.post('../Ajax/RefereesAjax.php', { id_referee : id_referee, action : "showResult"}, function(result) {
				    // Выводим данные полученные с ChampionshipsAjax.php
					name.val(result);
				});
		 		return false;
		 	}
		 	// При правильном вводе обновляем данные и закрываем окно редактирования
		 	else {
		 		$.post('../Ajax/RefereesAjax.php', { id_referee : id_referee, 
		 										action : "edit", 
		 										referee_name : name.val()},
		 										function(result) {
		 										    // Если такой судья существует не даём добавить
		 											if (result == "error" && name.val() != oldName) {
		 										 		$("#errorChanging").remove();
		 												$("#refereeName" + number).after("<span id='errorChanging' >&nbsp;Такой судья уже существует !</span>");
		 											}
		 											else {
		 												$("span.referee" + number).html("<span class='referee"+number+"'>" +
		 										 				"<a style='cursor:pointer'>"+name.val()+"</a></span>");
		 											}
		 										});
		 		
		 		
		 		return false;
		 	}
		});
}

function addReferee(id_country, referee_name, referee_birth, formName) {
	var referee_name_ = $(referee_name);
	var referee_birth_ = $(referee_birth);
	var form = $(formName);
		if (referee_name_.val() == "")  
			{
				$("#errorChanging").remove();
				referee_name_.before("<span id='errorChanging'>&nbsp;Введите имя !<br></span>");
			}
		else if (referee_birth_.val() == "")  
		{
			$("#errorChanging").remove();
			referee_birth_.before("<span id='errorChanging'>&nbsp;Введите дату рождения !<br></span>");
		}
		else {

			$.post('../Ajax/RefereesAjax.php', { id_country : id_country, 
											referee_name : referee_name_.val(),
											referee_birth : referee_birth_.val(),
											action : "addReferee"},
											function(result) {
												if (result == "error") {
													
												$("#errorChanging").remove();
												referee_name_.before("<span id='errorChanging'>" +
														"&nbsp;Такой судья уже существует !<br><br></span>");
												}
												else {
													//#TODO добавление нового чемпионата
													window.location.reload();
												}
											});
			referee_name_.val("");
			$("#errorChanging").remove();
		}
}
function deleteReferee(id_referee, number) {
	if (confirm('Вы уверены что хотите удалить судью ?') == true) {
		$.post('../Ajax/RefereesAjax.php', { id_referee : id_referee, 
										action : "delete"});
		window.location.reload();
	}

}