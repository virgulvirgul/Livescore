<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Free CSS template by ChocoTemplates.com</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<!--[if lte IE 6]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" /><![endif]-->
</head>
<body bgcolor = 'inactiveborder'>
<script type="text/javascript" src="jquery-1.7.1.js"></script> 
<script type="text/javascript" src="scripts.js"></script> 

<?php


$client = new SoapClient(null, array(
		'location' => "http://localhost/Livescore/WebService/server.php",
		'uri'      => "urn://www.livescore.com/req",
		'trace'    => 1 ));

 
$result = $client->getStatistics($_GET['id_game']);

$teams = $result['teams_array'];
$goals = $result['goals_array'];
$goals_owner = $goals['goals_array_owner'];
$goals_guest = $goals['goals_array_guest'];


$yellow_cards_owner_array = $result['yellow_cards_owner_array'];
$yellow_cards_guest_array = $result['yellow_cards_guest_array'];
$red_cards_owner_array = $result['red_cards_owner_array'];
$red_cards_guest_array = $result['red_cards_guest_array'];

$subs_owner_array = $result['subs_owner_array'];
$subs_guest_array = $result['subs_guest_array'];

$penalty_shootout_flag = $result['penalty_shootout_flag'];
$penalty_shootout_owner_array = $result['penalty_shootout_owner_array'];
$penalty_shootout_guest_array = $result['penalty_shootout_guest_array'];
$penalty_score_owner_array = $result['penalty_score_owner_array'];
$penalty_score_guest_array = $result['penalty_score_guest_array'];



$lines_up_team_owner = $result['lines_up_team_owner'];
$lines_up_team_guest = $result['lines_up_team_guest'];

$previous_meetings_array = $result['previous_meetings_array'];

$referee = $result['referee'];
$stadium = $result['stadium'];
$tour = $result['tour'];
echo "<center><table>";
	foreach ($teams as $row_teams) {
		$team_owner_name = $row_teams['team_owner_name'];
		$team_guest_name = $row_teams['team_guest_name'];
   		echo "<tr id='tr_header'>
   		<td><center>".$row_teams['team_owner_name']." ".$row_teams['team_owner_score']." - ".$row_teams['team_guest_score']." ".$row_teams['team_guest_name']."</center></td></tr>";
   	}
   	echo "</table></center>";
   	
echo "<center><table border='1'>";
echo "<tr id='tr_header'><td><a id='statistics'>Статистика</a></td>
						<td><a id='lines_up'>Составы</a></td>
						<td><a id='previous_meetings'>Предыдущие встречи</a></td>
						<td><a id='addition_info'>Доп инфо</a></td>
					</tr>";
echo "</table></center>";

echo "<div id='statistics_table'>";

echo "<center><table border='1'>";
echo "<tr id='tr_header'><td width='300px'><center>".$team_owner_name."</td><td width='300px'><center>".$team_guest_name."</td></tr>";
	foreach ($goals_owner as $row_goals) {
		$minutes_owner[] = (int)$row_goals['team_owner_goal_minute'];
		$names_owner[] = $row_goals['team_owner_goal_player_name'];
	}
	foreach ($goals_guest as $row_goals) {
		$minutes_guest[] = (int)$row_goals['team_guest_goal_minute'];
		$names_guest[] = $row_goals['team_guest_goal_player_name'];
	}
	if (count($minutes_owner) >= count($minutes_guest)) {
		for($i = 0; $i < count($minutes_owner); $i++) {
			if ($minutes_owner[$i] < $minutes_guest[$i]) {
				echo "<tr><td>".$minutes_owner[$i]."&nbsp&nbsp&nbsp".$names_owner[$i]."&nbsp<img src='css/images/goal.gif'></td><td></td></tr>";
				echo "<tr><td></td><td><div align='left'>".$minutes_guest[$i]."&nbsp&nbsp&nbsp".$names_guest[$i]."&nbsp<img src='css/images/goal.gif'></div></td></tr>";
				
			}
			else {
				echo "<tr><td></td><td><div align='left'>".$minutes_guest[$i]."&nbsp&nbsp&nbsp".$names_guest[$i]."&nbsp<img src='css/images/goal.gif'></div></td></tr>";
				echo "<tr><td>".$minutes_owner[$i]."&nbsp&nbsp&nbsp".$names_owner[$i]."&nbsp<img src='css/images/goal.gif'></td><td></td></tr>";
				
			}
		} 
	}
		else {
			for($i = 0; $i < count($minutes_guest); $i++) {
				echo $minutes_owner[$i];
				if ($minutes_owner[$i] < $minutes_guest[$i]) {
					echo "<tr><td>".$minutes_owner[$i]."&nbsp&nbsp&nbsp".$names_owner[$i]."&nbsp<img src='css/images/goal.gif'></td><td></td></tr>";
					echo "<tr><td></td><td><div align='left'>".$minutes_guest[$i]."&nbsp&nbsp&nbsp".$names_guest[$i]."&nbsp<img src='css/images/goal.gif'></div></td></tr>";
			
				}
				else {
					echo "<tr><td></td><td><div align='left'>".$minutes_guest[$i]."&nbsp&nbsp&nbsp".$names_guest[$i]."&nbsp<img src='css/images/goal.gif'></div></td></tr>";
					echo "<tr><td>".$minutes_owner[$i]."&nbsp&nbsp&nbsp".$names_owner[$i]."&nbsp<img src='css/images/goal.gif'></td><td></td></tr>";
			
				}
			}
	}
	// for($i = 0; $i < count$minutes_guest)


echo "<tr id='tr_header'><td colspan='2'>Карточки</td></tr>";

foreach ($yellow_cards_owner_array as $row) {
	if ($row['team_card_minute'] != "") echo "<tr><td>".$row['team_card_minute']."&nbsp&nbsp&nbsp".$row['team_card_player_name']."&nbsp<img src='css/images/yellow_card.gif'></td><td></td></tr>";
}

foreach ($yellow_cards_guest_array as $row) {
	if ($row['team_card_minute'] != "") echo "<tr><td></td><td><div align='left'>".$row['team_card_minute']."&nbsp&nbsp&nbsp".$row['team_card_player_name']."&nbsp<img src='css/images/yellow_card.gif'></div></td></tr>";
}

foreach ($red_cards_owner_array as $row) {
	if ($row['team_card_minute'] != "") echo "<tr><td>".$row['team_card_minute']."&nbsp&nbsp&nbsp".$row['team_card_player_name']."&nbsp<img src='css/images/red_card.gif'></td><td></td></tr>";
}

foreach ($red_cards_guest_array as $row) {
	if ($row['team_card_minute'] != "") echo "<tr><td></td><td><div align='left'>".$row['team_card_minute']."&nbsp&nbsp&nbsp".$row['team_card_player_name']."&nbsp<img src='css/images/red_card.gif'></div></td></tr>";
}

//if ($row_goals['team_guest_goal_minute'] != "") echo "<tr><td></td><td><div align='left'>".$row_goals['team_guest_goal_minute']."'&nbsp&nbsp&nbsp".$row_goals['team_guest_goal_player_name']."&nbsp<img src='css/images/goal.gif'></div></td></tr>";

echo "<tr id='tr_header'><td colspan='2'>Замены</td></tr>";

foreach ($subs_owner_array as $row) {
	if ($row['team_substitution_minute'] != "") echo "<tr><td>".$row['team_substitution_minute']."&nbsp&nbsp&nbsp".$row['team_first_player_name']."&nbsp<img style='height:10px;width:8px;' float='left' src='css/images/substitution.gif'>&nbsp".$row['team_second_player_name']."</td><td></td></tr>";
}
foreach ($subs_guest_array as $row) {
	if ($row['team_substitution_minute'] != "") echo "<tr><td></td><td><div align='left'>".$row['team_substitution_minute']."&nbsp&nbsp&nbsp".$row['team_first_player_name']."&nbsp<img style='height:10px;width:8px;' float='left' src='css/images/substitution.gif'>&nbsp".$row['team_second_player_name']."</div></td></tr>";
}

if ($penalty_shootout_flag == 1) {
	echo "<tr id='tr_header'><td colspan='2'><center>Серия пенальти [".$penalty_score_owner_array." - ".$penalty_score_guest_array."]</td></tr>";
	echo "<td>";
		foreach ($penalty_shootout_owner_array as $row) {
			echo $row['player_name']."&nbsp".$row['scored']."<br>";
		}
	echo "</td>";
	echo "</td><td>";
		foreach ($penalty_shootout_guest_array as $row) {
			echo $row['player_name']."&nbsp".$row['scored']."<br>";
		}
	echo "</td></tr>";
}
echo "</table></center>";
echo "</div>";

echo "<div id='lines_up_table' style='display:none'>";
echo "<table align='left' style='width:50%;'>";

echo "<tr id='tr_header'><td colspan='3' width='300px'><center>".$team_owner_name."</td></td></tr>";

echo "<tr id='tr_header'>
<td>№</td><td>Имя</td><td><div id='amplua'>Амплуа</div></td>
</tr>";

	foreach ($lines_up_team_owner as $owner) {
		echo "<tr><td>".$owner['player_owner_number']."</td><td >".$owner['player_owner_name']."</td>
		<td>".$owner['player_owner_position']."</td></tr>";
	}
echo "</table>";

echo "<table align='right' style='width:50%;'>";

echo "<tr id='tr_header'><td colspan='3' width='300px'><center>".$team_guest_name."</td></td></tr>";

echo "<tr id='tr_header'>
<td>№</td><td>Имя</td><td><div id='amplua'>Амплуа</div></td>
</tr>";

foreach ($lines_up_team_guest as $guest) {
	echo "<tr><td>".$guest['player_guest_number']."</td><td >".$guest['player_guest_name']."</td>
	<td>".$guest['player_guest_position']."</td></tr>";
}
echo "</table>";
echo "</div>";

echo "<div id='previous_meetings_table'  style='display:none'>";

echo "<center><table>";

foreach ($previous_meetings_array as $row_prev) {
	$allDate = $row_prev['date'];
	$year = substr($allDate, 0, 4);
	$month = substr($allDate, 5, 2);
	$day = substr($allDate, 8, 2);
	$date = date('d F Y',mktime(0,0,0,$month, $day, $year));
	echo "<tr><td style='width:80px'>".$date."</td><td width='100px'><div align='right'>".$row_prev['team_owner_name']."</div></td><td width='15px'><a onclick='openWindow(".$row_prev['id_game'].");'>".$row_prev['team_owner_score']." - ".$row_prev['team_guest_score']."</a></td><td width='100px'>".$row_prev['team_guest_name']."</td></tr>";
}


echo "</table></center>";


echo "</div>";


echo "<div id='addition_info_table' style='display:none'>";
echo "<center><table>";
echo "<tr id='tr_header'><td>Тур</td></tr>";

echo "<tr><td>".$tour['tour']."</td></tr>";
echo "<tr id='tr_header'><td>Судья</td></tr>";

echo "<tr><td>".$referee['referee_name']."</td></tr>";
echo "<tr id='tr_header'><td>Стадион</td></tr>";

echo "<tr><td>".$stadium['stadium_name']." (".$stadium['stadium_capacity'].")</td></tr><tr><td>".$stadium['stadium_image']."</td></tr>";
echo "</table></center>";


echo "</div>";
?>

</body>
</html>