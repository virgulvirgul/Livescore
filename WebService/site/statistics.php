<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Free CSS template by ChocoTemplates.com</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<!--[if lte IE 6]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" /><![endif]-->
</head>
<body bgcolor = 'inactiveborder'>

<?php


$client = new SoapClient(null, array(
		'location' => "http://localhost/Livescore/WebService/server.php",
		'uri'      => "urn://www.livescore.com/req",
		'trace'    => 1 ));

 
$result = $client->getStatistics($_GET['id_game']);

$teams = $result['teams_array'];
$goals = $result['goals_array'];

$yellow_cards_owner_array = $result['yellow_cards_owner_array'];
$yellow_cards_guest_array = $result['yellow_cards_guest_array'];
$red_cards_owner_array = $result['red_cards_owner_array'];
$red_cards_guest_array = $result['red_cards_guest_array'];

$subs_owner_array = $result['subs_owner_array'];
$subs_guest_array = $result['subs_guest_array'];

echo "<center><table>";
	foreach ($teams as $row_teams) {
   		echo "<tr id='tr_header'>
   		<td><center>".$row_teams['team_owner_name']." ".$row_teams['team_owner_score']." - ".$row_teams['team_guest_score']." ".$row_teams['team_guest_name']."</center></td></tr>";
   	}
   	echo "</table></center>";
   	
echo "<center><table border='1'>";
echo "<tr id='tr_header'><td><a>Статистика</a></td>
						<td><a>Составы</a></td>
						<td><a>Предыдущие встречи</a></td></tr>";
echo "</table></center>";

echo "<center><table border='1'>";
foreach ($goals as $row_goals) {
	if ($row_goals['team_owner_goal_minute'] != "") echo "<tr><td>".$row_goals['team_owner_goal_minute']."'&nbsp&nbsp&nbsp".$row_goals['team_owner_goal_player_name']."&nbsp<img src='css/images/goal.gif'></td><td></td></tr>";
	if ($row_goals['team_guest_goal_minute'] != "") echo "<tr><td></td><td><div align='left'>".$row_goals['team_guest_goal_minute']."'&nbsp&nbsp&nbsp".$row_goals['team_guest_goal_player_name']."&nbsp<img src='css/images/goal.gif'></div></td></tr>";
}

echo "<tr id='tr_header'><td colspan='2'>Карточки</td></tr>";

foreach ($yellow_cards_owner_array as $row) {
	if ($row['team_card_minute'] != "") echo "<tr><td>".$row['team_card_minute']."'&nbsp&nbsp&nbsp".$row['team_card_player_name']."&nbsp<img src='css/images/yellow_card.gif'></td><td></td></tr>";
}

foreach ($yellow_cards_guest_array as $row) {
	if ($row['team_card_minute'] != "") echo "<tr><td></td><td><div align='left'>".$row['team_card_minute']."'&nbsp&nbsp&nbsp".$row['team_card_player_name']."&nbsp<img src='css/images/yellow_card.gif'></div></td></tr>";
}

foreach ($red_cards_owner_array as $row) {
	if ($row['team_card_minute'] != "") echo "<tr><td>".$row['team_card_minute']."'&nbsp&nbsp&nbsp".$row['team_card_player_name']."&nbsp<img src='css/images/red_card.gif'></td><td></td></tr>";
}

foreach ($red_cards_guest_array as $row) {
	if ($row['team_card_minute'] != "") echo "<tr><td></td><td><div align='left'>".$row['team_card_minute']."'&nbsp&nbsp&nbsp".$row['team_card_player_name']."&nbsp<img src='css/images/red_card.gif'></div></td></tr>";
}

//if ($row_goals['team_guest_goal_minute'] != "") echo "<tr><td></td><td><div align='left'>".$row_goals['team_guest_goal_minute']."'&nbsp&nbsp&nbsp".$row_goals['team_guest_goal_player_name']."&nbsp<img src='css/images/goal.gif'></div></td></tr>";

echo "<tr id='tr_header'><td colspan='2'>Замены</td></tr>";

foreach ($subs_owner_array as $row) {
	if ($row['team_substitution_minute'] != "") echo "<tr><td>".$row['team_substitution_minute']."'&nbsp&nbsp&nbsp".$row['team_first_player_name']."&nbsp<img style='height:10px;width:8px;' float='left' src='css/images/substitution.gif'>&nbsp".$row['team_second_player_name']."</td><td></td></tr>";
}
foreach ($subs_guest_array as $row) {
	if ($row['team_substitution_minute'] != "") echo "<tr><td></td><td><div align='left'>".$row['team_substitution_minute']."'&nbsp&nbsp&nbsp".$row['team_first_player_name']."&nbsp<img style='height:10px;width:8px;' float='left' src='css/images/substitution.gif'>&nbsp".$row['team_second_player_name']."</div></td></tr>";
}
echo "</table></center>";

?>

</body>
</html>