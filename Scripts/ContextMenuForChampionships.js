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
		$.post('../Scripts/ChampionshipsAjax.php', { id_championship : id_champ, action : "showResult"}, function(result) {
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
			 		$("#champName" + number).after("<span id='errorChanging' style='color:red;font-size:15px;'>&nbsp;Введите название чемпионата !</span>");
			 		$.post('../Scripts/ChampionshipsAjax.php', { id_championship : id_champ, action : "showResult"}, function(result) {
					    // Выводим данные полученные с ChampionshipsAjax.php
						name.val(result);
					});
			 		return false;
			 	}
			 	// При правильном вводе обновляем данные и закрываем окно редактирования
			 	else {
			 		$.post('../Scripts/ChampionshipsAjax.php', { id_championship : id_champ, 
			 										action : "edit", 
			 										name : name.val()},
			 										function(result) {
			 										    // Если такой чемпионат существует не даём добавить
			 											if (result == "error" && name.val() != oldRes) {
			 										 		$("#errorChanging").remove();
			 												$("#champName" + number).after("<span id='errorChanging' style='color:red;font-size:15px;'>&nbsp;Такой чемпионат уже существует !</span>");
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
	if (confirm('Вы уверены что хотите удалить чемпионат ?') == true) {
		$.post('../Scripts/ChampionshipsAjax.php', { id_championship : id_champ, 
										action : "delete"});
		//$("#tr_number" + number).remove();
		window.location.reload();
		//$.each(function(i){$("#aNumber" + (number + 1)).html(number + 1);});
		//$("a").each(function(i){$("#aNumber" + ( number + (i + 1) ).html(number + (i+10)));});
		//$.each({52: 97}, function(index, value) { 
		//	  alert(index + ': ' + value); 
		//	});
		//$("a").each(function(i){$("#aNumber" + i).html(i);})
		//$("#aNumber").each(function(i){$(this).html(i);})
		//$("#aNumber" + (number+1)).html(number + 1);
	}

}

function addChamp(id_country, inputElement, formName) {
	var input = $(inputElement);
	var form = $(formName);
	//form.submit(function() { return false; });
	/*form.submit(function() {
		if (input.val() == "")  
		{
			if (flag == true) input.before("<span style='color:red;font-size:15px;'>&nbsp;Введите название чемпионата !</span><br>");
			flag = false;
			return false;
		}
	else {
		$.post('../Scripts/ChampionshipsAjax.php', { id_country : id_country, 
										name : input.val(),
										action : "addChamp"});
		input.val("");
		return false;
	}}); */
		if (input.val() == "")  
			{
				$("#errorAdding").remove();
				input.before("<span id='errorAdding' style='color:red;font-size:15px;'>&nbsp;Введите название !<br><br></span>");
			}
		else {
			$.post('../Scripts/ChampionshipsAjax.php', { id_country : id_country, 
											name : input.val(),
											action : "addChamp"},
											function(result) {
												if (result == "error") {
													
												$("#errorAdding").remove();
												input.before("<span id='errorAdding' style='color:red;font-size:15px;'>" +
														"&nbsp;Такой чемпионат уже существует !<br><br></span>");
												}
												else {
													//#TODO добавление нового чемпионата
													window.location.reload();
												}
											});
			input.val("");
			$("#errorAdding").remove();
		}
}