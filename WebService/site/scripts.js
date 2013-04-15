
$(document).ready(function() {
			/**
 			* При наведениие на ячейку меняем её цвет
 			*/
	$('#lines_up').click(function () {
		$('#statistics_table').hide('slow');
		$('#previous_meetings_table').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#lines_up_table').show('slow');
		$('#championship_table_show').hide('slow');
	});
	
	$('#statistics').click(function () {
		$('#statistics_table').show('slow');
		$('#previous_meetings_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#championship_table_show').hide('slow');
	});
	$('#previous_meetings').click(function () {
		$('#previous_meetings_table').show('slow');
		$('#statistics_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#addition_info_table').hide('slow');
		$('#championship_table_show').hide('slow');
	});
	$('#championship_table').click(function () {
		$('#championship_table_show').show('slow');
		$('#addition_info_table').hide('slow');
		$('#statistics_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#previous_meetings_table').hide('slow');

	});
	$('#addition_info').click(function () {
		$('#championship_table_show').hide('slow');
		$('#addition_info_table').show('slow');
		$('#statistics_table').hide('slow');
		$('#lines_up_table').hide('slow');
		$('#previous_meetings_table').hide('slow');

	});
			
});

var newWindow; //глобальная переменная для ссылки на окно
function openWindow(id_game){ //открытие первого окна
	window.status = "Первое окно /*статусная строка главного окна*/";
	strfeatures = "top=200,left=150, width=500, height=400, scrollbars=yes";
	window.open("statistics.php?id_game="+id_game, "Win1", strfeatures);
}