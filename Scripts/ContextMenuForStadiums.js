$(document).ready(function() {
		$('span').each(function(i) {
			$('.addStadium' + i).contextMenu('addStadiumContextMenu'+i, {

      bindings: {

        'Add': function(t) {
        },
      }

    })})});


function getTooltipForStadiums(id_stadium, stadium_capacity, stadium_image) {
    		$("#stadium" + id_stadium).tooltip({
    			txt: '<center>Вместительность - '+ stadium_capacity +'</center><br><img height="300px" width="300px" src="../Images/stadiums/' + stadium_image + '">'                
            });
    }

function addStadiumModal(number) {
	 $('#stadiumModalContent' + number).modal();
     return false;
}

function addStadium(number, id_team, stadium_name, stadium_capacity, stadium_image) {
	 if ($(stadium_name).val() == "")  
     {
         $("#errorChanging").remove();
         $(stadium_name).before("<span id='errorChanging'>&nbsp;Введите название !<br><br></span>");
     }
	 else
		 if ($(stadium_capacity).val() == "")  
	     {
	         $("#errorChanging").remove();
	         $(stadium_capacity).before("<span id='errorChanging'>&nbsp;Введите вместительность !<br><br></span>");
	     }
	 else
	 if ($(stadium_image).val() == "")  
     {
         $("#errorChanging").remove();
         $(stadium_image).before("<span id='errorChanging'>&nbsp;Выберите изображение !<br><br></span>");
     }
	 else {
		window.location.reload();
	 }
}