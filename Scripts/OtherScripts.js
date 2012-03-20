

$(document).ready(function() {
			/**
 			* При наведениие на ячейку меняем её цвет
 			*/
		$('td').each(function(i) {
				$('#selected' + i).mouseover(function() {
					$(this).css('backgroundColor', '#D0F500');
			});
			$('#selected' + i).mouseout(function() {
					$(this).css('backgroundColor', '#6495ED');
			});
			});
});


