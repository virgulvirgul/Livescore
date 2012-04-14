

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
			
			
			$("#amplua").tooltip({
                txt: 'GK - GoalKeeper (Вратарь)' +
                    '<br>D - Defender (Защитник)' +
                    '<br>M - Midfielder (Полузащитник)'+
                    '<br>AM - AttaсkingMidfielder (Атакующий полузащитник)'+
                    '<br>ST - Striker (Нападающий)',
               
            });
			
});



