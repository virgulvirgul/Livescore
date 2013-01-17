$(document).ready(function() {
		$('span').each(function(i) {
			$('.championship'+i).contextMenu('champContextMenu'+i, {

      bindings: {

        'Edit': function(t) {
        },

        'Delete': function(t) {
        },

      }

    })})});
// Редактирование чемпионата
	function editChamp(id_champ, number) {
    	// Выводим форму для редактирования
    	$("span.championship"+number).html("<form id='form_' action=''>" +
    			"<input class='editChampInput' value='' id='champName" + number + "' type='text'></form>");
		var name = $('#champName' + number);
		var oldRes;
		// Получаем данные из ChampionshipsAjax.php
		$.post('../Ajax/ChampionshipsAjax.php', { id_championship : id_champ, action : "showResult"}, function(result) {
		    // Выводим данные полученные с ChampionshipsAjax.php
			name.val(result);
			oldRes = result;
		});
		var flag = true;
		 $("#form_").submit(function () {
		    	// Если поле ввода пустое то выводим сообщение и заставляем ввести имя
			 	if (name.val() == "") {
			 		//$("#editError" + number).html("Введите название чемпионата !");
			 		$("#errorChanging").remove();
			 		$("#champName" + number).after("<span id='errorChanging' >&nbsp;Введите название чемпионата !</span>");
			 		$.post('../Ajax/ChampionshipsAjax.php', { id_championship : id_champ, action : "showResult"}, function(result) {
					    // Выводим данные полученные с ChampionshipsAjax.php
						name.val(result);
					});
			 		return false;
			 	}
			 	// При правильном вводе обновляем данные и закрываем окно редактирования
			 	else {
			 		$.post('../Ajax/ChampionshipsAjax.php', { id_championship : id_champ, 
			 										action : "edit", 
			 										name : name.val()},
			 										function(result) {
			 										    // Если такой чемпионат существует не даём добавить
			 											if (result == "error" && name.val() != oldRes) {
			 										 		$("#errorChanging").remove();
			 												$("#champName" + number).after("<span id='errorChanging' >&nbsp;Такой чемпионат уже существует !</span>");
			 											}
			 											else {
			 												$("span.championship" + number).html("<span class='championship"+number+"'>" +
			 										 				"<a href='index.php?id_championship="+id_champ+"''>"+name.val()+"</a></span>");
			 											}
			 										});
			 		
			 		
			 		return false;
			 	}
			});
	}
	
function deleteChamp(id_champ, number) {
	if (confirm('Вы уверены что хотите удалить чемпионат ?')) {
		$.post('../Ajax/ChampionshipsAjax.php', { id_championship : id_champ, 
										action : "delete"});
		window.location.reload();
	}

}

function addChamp(id_country, inputElement, formName) {
	var input = $(inputElement);
	var form = $(formName);
		if (input.val() == "")  
			{
				$("#errorChanging").remove();
				input.before("<span id='errorChanging'>&nbsp;Введите название !<br><br></span>");
			}
		else {
			$.post('../Ajax/ChampionshipsAjax.php', { id_country : id_country, 
											name : input.val(),
											action : "addChamp"},
											function(result) {
												if (result == "error") {
													
												$("#errorChanging").remove();
												input.before("<span id='errorChanging'>" +
														"&nbsp;Такой чемпионат уже существует !<br><br></span>");
												}
												else {
													//#TODO добавление нового чемпионата
													window.location.reload();
												}
											});
			input.val("");
			$("#errorChanging").remove();
		}
}