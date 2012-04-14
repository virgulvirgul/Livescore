   

function getTooltipForStadiums(id_stadium, stadium_capacity, stadium_image) {
    		$("#stadium" + id_stadium).tooltip({
    			txt: '<center>Вместительность - '+ stadium_capacity +'</center><br><img height="300px" width="300px" src="../Images/stadiums/' + stadium_image + '">'                
            });
    }