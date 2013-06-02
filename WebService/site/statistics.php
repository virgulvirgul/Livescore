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
<script type="text/javascript" src="easyTooltip.js"></script>

<script type="text/javascript" src="easyTooltip1.js"></script>
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
$last_games_owner_array = $result['last_games_owner_array'];
$last_games_guest_array = $result['last_games_guest_array'];

$referee = $result['referee'];
$stadium = $result['stadium'];
$tour = $result['tour'];


$championship_table_array = $result['championship_table_array'];
$forecast_and_announcement_array = $result['forecast_and_announcement_array'];
$video_broadcast_array = $result['video_broadcast_array'];
$form_array = $result['form_array'];
$game_statistics_array = $result['game_statistics_array'];
$tactics_array = $result['tactics_array'];
$strikers_array = $result['strikers_array'];
$yellow_cards_statistics_array = $result['yellow_cards_statistics_array'];
$red_cards_statistics_array = $result['red_cards_statistics_array'];
echo "<center><table>";
	foreach ($teams as $row_teams) {
		$team_owner_name = $row_teams['team_owner_name'];
		$team_guest_name = $row_teams['team_guest_name'];
   		echo "<tr id='tr_header'>
   		<td><center>".$row_teams['team_owner_name']." ".$row_teams['team_owner_score']." - ".$row_teams['team_guest_score']." ".$row_teams['team_guest_name']."</center></td></tr>";
   	}
   	echo "</table></center>";
   	
echo "<center><table border='1'>";
echo "<tr id='tr_header'><td><a id='statistics'>Ход матча</a></td>
						<td><a id='lines_up'>Составы</a></td>
						<td><a id='previous_meetings'>Последние игры</a></td>
						<td><a id='championship_table'>Таблица чемпионата</a></td>
						<td><a id='addition_info'>Доп инфо</a></td></td>
						<tr id='tr_header'><td></td><td><a id='video_broadcast'>Онлайн трансляция</a></td>
						<td><a id='game_statistics'>Статистика матча</a></td><td><a id='players_statistics'>Статистика игроков</a></td><td></td>
					</tr>";
echo "</table></center>";

echo "<div id='statistics_table'>";
echo "<center><table border='1'>";
echo "<tr id='tr_header'><td width='300px'><center>".$team_owner_name."</td><td width='300px'><center>".$team_guest_name."</td></tr>";
	foreach ($goals_owner as $row_goals) {
		$minutes_owner[] = $row_goals['team_owner_goal_minute'];
		$names_owner[] = $row_goals['team_owner_goal_player_name'];
	}
	foreach ($goals_guest as $row_goals) {
		$minutes_guest[] = $row_goals['team_guest_goal_minute'];
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
/**
 * Составы
 */
echo "<div id='lines_up_table' style='display:none'>";
echo "<table align='left' style='width:50%;'>";

echo "<tr id='tr_header'><td colspan='3' width='300px'><center>".$team_owner_name."</td></td></tr>";
echo "<tr id='tr_header'><td colspan='3'>Тактика</td></tr>";
echo "<tr><td colspan='3'><center>".$tactics_array['tactics_owner']."<img style='height:250px;width:220px;' src='images/".$tactics_array['tactics_owner'].".jpg'></center></td></tr>";
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
echo "<tr id='tr_header'><td colspan='3'>Тактика</td></tr>";
echo "<tr><td colspan='3'><center>".$tactics_array['tactics_guest']."<img style='height:250px;width:220px;' src='images/".$tactics_array['tactics_guest'].".jpg'></center></td></tr>";

echo "<tr id='tr_header'>
<td>№</td><td>Имя</td><td><div id='amplua'>Амплуа</div></td>
</tr>";

foreach ($lines_up_team_guest as $guest) {
	echo "<tr><td>".$guest['player_guest_number']."</td><td >".$guest['player_guest_name']."</td>
	<td>".$guest['player_guest_position']."</td></tr>";
}
echo "</table>";
echo "</div>";

/**
 * Конец составов
 */

/**
 * Предыдущие встречи
 */
echo "<div id='previous_meetings_table'  style='display:none'>";

echo "<center><table>";

echo "<tr id='tr_header'><td colspan=4>Последние встречи: <span style='color:#7FCAEB'>".$team_owner_name."</span><td></tr>";
foreach ($last_games_owner_array as $row_prev) {
		$allDate = $row_prev['date'];
	$year = substr($allDate, 0, 4);
	$month = substr($allDate, 5, 2);
	$day = substr($allDate, 8, 2);
	$date = date('d F Y',mktime(0,0,0,$month, $day, $year));
	$temp_owner = ''; $temp_guest = '';
	if ($row_prev['team_owner_name'] == $team_owner_name) {
		$temp_owner = "style='background-color:#7FCAEB;color:black'";
	} else if ($row_prev['team_guest_name'] == $team_owner_name) {
		$temp_guest = "style='background-color:#7FCAEB;color:black'";
	} 
	echo "<tr><td style='width:95px'>".$date."</td><td ".$temp_owner."><div align='right'>".$row_prev['team_owner_name']."</b></div></td><td style='width:30px'><a onclick='openWindow(".$row_prev['id_game'].");'>".$row_prev['team_owner_score']." - ".$row_prev['team_guest_score']."</a></td><td ".$temp_guest.">".$row_prev['team_guest_name']."</td>";
	echo "<td style='width:5px'>";
	if ($team_owner_name == $row_prev['team_owner_name'] && $row_prev['team_owner_score'] > $row_prev['team_guest_score']) {
		echo "<img src='images/win.png' style='height:15px;width:15px;'>";
	} else if ($team_owner_name == $row_prev['team_owner_name'] && $row_prev['team_owner_score'] < $row_prev['team_guest_score']) {
		echo "<img src='images/lose.png' style='height:15px;width:15px;'>";
	} else if ($team_owner_name == $row_prev['team_guest_name'] && $row_prev['team_owner_score'] < $row_prev['team_guest_score']) {
		echo "<img src='images/win.png' style='height:15px;width:15px;'>";
	} else if ($team_owner_name == $row_prev['team_guest_name'] && $row_prev['team_owner_score'] > $row_prev['team_guest_score']) {
		echo "<img src='images/lose.png' style='height:15px;width:15px;'>";
	} else echo "<img src='images/draw.png' style='height:15px;width:15px;'>";
	echo "</td></tr>";
}

echo "</table></center>";
echo "<center><table style='width:100%'>";

echo "<tr id='tr_header'><td colspan=4>Последние встречи: <span style='color:#7FCAEB'>".$team_guest_name."</span><td></tr>";
foreach ($last_games_guest_array as $row_prev) {
	$allDate = $row_prev['date'];
	$year = substr($allDate, 0, 4);
	$month = substr($allDate, 5, 2);
	$day = substr($allDate, 8, 2);
	$date = date('d F Y',mktime(0,0,0,$month, $day, $year));
	$temp_owner = ''; $temp_guest = '';
	if ($row_prev['team_owner_name'] == $team_guest_name) {
		$temp_owner = "style='background-color:#7FCAEB;color:black'";
	} else if ($row_prev['team_guest_name'] == $team_guest_name) {
		$temp_guest = "style='background-color:#7FCAEB;color:black'";
	} 
	echo "<tr><td style='width:95px'>".$date."</td><td ".$temp_owner."><div align='right'>".$row_prev['team_owner_name']."</b></div></td><td style='width:30px'><a onclick='openWindow(".$row_prev['id_game'].");'>".$row_prev['team_owner_score']." - ".$row_prev['team_guest_score']."</a></td><td ".$temp_guest.">".$row_prev['team_guest_name']."</td>";
	echo "<td style='width:5px'>";
	if ($team_guest_name == $row_prev['team_owner_name'] && $row_prev['team_owner_score'] > $row_prev['team_guest_score']) {
		echo "<img src='images/win.png' style='height:15px;width:15px;'>";
	} else if ($team_guest_name == $row_prev['team_owner_name'] && $row_prev['team_owner_score'] < $row_prev['team_guest_score']) {
		echo "<img src='images/lose.png' style='height:15px;width:15px;'>";
	} else if ($team_guest_name == $row_prev['team_guest_name'] && $row_prev['team_owner_score'] < $row_prev['team_guest_score']) {
		echo "<img src='images/win.png' style='height:15px;width:15px;'>";
	} else if ($team_guest_name == $row_prev['team_guest_name'] && $row_prev['team_owner_score'] > $row_prev['team_guest_score']) {
		echo "<img src='images/lose.png' style='height:15px;width:15px;'>";
	} else echo "<img src='images/draw.png' style='height:15px;width:15px;'>";
	echo "</td></tr>";
}


echo "</table></center>";
echo "<center><table>";

echo "<tr id='tr_header'><td colspan=3>Очные встречи: <span style='color:#7FCAEB'>".$team_owner_name."</span> - <span style='color:#7FCAEB'>".$team_guest_name."</span><td></tr>";
foreach ($previous_meetings_array as $row_prev) {
	$allDate = $row_prev['date'];
	$year = substr($allDate, 0, 4);
	$month = substr($allDate, 5, 2);
	$day = substr($allDate, 8, 2);
	$date = date('d F Y',mktime(0,0,0,$month, $day, $year));
	echo "<tr><td style='width:95px'>".$date."</td><td><div align='right'>".$row_prev['team_owner_name']."</div></td><td style='width:30px'><a onclick='openWindow(".$row_prev['id_game'].");'>".$row_prev['team_owner_score']." - ".$row_prev['team_guest_score']."</a></td><td>".$row_prev['team_guest_name']."</td></tr>";
}


echo "</table></center>";


echo "</div>";
/**
 * Конец предыдущие встречи
 */
echo "<div id='championship_table_show' style='display:none'>";
echo "<table><tr id='tr_header'><td width='1px'>№</td><td>Команда</td><td width='1px'>И</td><td width='1px'>В</td><td width='1px'>Н</td><td width='1px'>П</td><td width='1px'>Рм</td><td width='1px'>О</td><td>Форма</td></tr>";
$number = 0;
$number_form = 0;
foreach ($championship_table_array as $row) {
	$number++;
	
	if ($team_owner_name == $row['team_name'] || $team_guest_name == $row['team_name']) {
		echo "<tr id='tr_header2'>";
	}
	else echo "<tr>";
	
	echo "<td>".$number."</td>";
	echo "<td>".$row['team_name']."</td>";
	echo "<td>".$row['games']."</td>
							<td>".$row['win']."</td>
									<td>".$row['draw']."</td>
											<td>".$row['lose']."</td>
													<td>".$row['goal_diff']."</td>
															<td>".$row['points']."</td>";
	
	foreach ($form_array as $row_form) {
		if ($row['team_name'] == $row_form['team_name']) {
			if (strlen($row_form['form']) > 0) {
				$symb = str_split($row_form['form']);
			}
			echo "<td>";
			for ($i == 0; $i < count($symb); $i++) {
				$number_form++;
				if ($symb[$i] == "W") { $img = "win";}
				if ($symb[$i] == "L") { $img = "lose"; }
				if ($symb[$i] == "D") { $img = "draw"; } 
				$id_games = explode(";", $row_form['id_games']);
				$result_teams_names = $client->getTeamsNamesAndSoreByGameId($id_games[$i]);
				$teams_names_array = $result_teams_names['teams_names_array'];
				
				$allDate = $teams_names_array['date'];
				$year = substr($allDate, 0, 4);
				$month = substr($allDate, 5, 2);
				$day = substr($allDate, 8, 2);
				$hour = substr($allDate, 11, 2);
				$minute = substr($allDate, 14, 2);
				$date = date('d F, Y',mktime($hour,$minute,0,$month, $day, $year));

				echo "<span style='font-size:100px;' id='show_game{$number_form}' onmouseover='getTooltipForGame({$number_form}, \"".$teams_names_array['team_owner_name']."\", \"".$teams_names_array['team_guest_name']."\", \"".$teams_names_array['team_owner_score']."\", \"".$teams_names_array['team_guest_score']."\", {$id_games[$i]}, \"".$date."\")'><a   onclick='openWindow(".$id_games[$i].");'><img src='images/".$img.".png' style='height:15px;width:15px;'></a></span>&nbsp;";
			}  
			$i = 0;
			$symb = null;
				echo "</td><tr>";
				
		}
		
	}
}

echo "</table>";
echo "</div>";



echo "<div id='addition_info_table' style='display:none'>";
echo "<center><table>";
echo "<tr id='tr_header'><td>Тур</td></tr>";
echo "<tr><td>".$tour['tour']."</td></tr>";

echo "<tr id='tr_header'><td>Судья</td></tr>";
echo "<tr><td>".$referee['referee_name']."</td></tr>";

echo "<tr id='tr_header'><td>Прогноз</td></tr>";
foreach ($teams as $row_teams) {
	$team_owner_name = $row_teams['team_owner_name'];
	$team_guest_name = $row_teams['team_guest_name'];
	echo "<tr>
	<td>".$row_teams['team_owner_name']." ".$forecast_and_announcement_array['forecast']." ".$row_teams['team_guest_name']."</td></tr>";
}

echo "<tr id='tr_header'><td>Анонс матча</td></tr>";

echo "<tr><td>".$forecast_and_announcement_array['announcement']."</td></tr>";

echo "<tr id='tr_header'><td>Стадион</td></tr>";
echo "<tr><td>".$stadium['stadium_name']." (".$stadium['stadium_capacity'].")</td></tr><tr><td>".$stadium['stadium_image']."</td></tr>";
echo "</table></center>";


echo "</div>";

echo "<div id='video_broadcast_table' style='display:none'>";
echo $video_broadcast_array['video_broadcast'];
echo "</div>";
/**
 * Статистика матча
 */
echo "<div id='game_statistics_table' style='display:none'>";

echo "<table>";
echo "<tr id='tr_header'><td width='50%'>".$team_owner_name."</td><td></td><td width='50%'>".$team_guest_name."</td></tr>";

$line_width = 5;


echo "<tr><td style='text-align:right; font-size:17px;'>".$game_statistics_array['possession_owner']."%&nbsp;&nbsp;<img style='height:16px; width:".($game_statistics_array['possession_owner'] + 70)."px;' src='images/blue.png'></td><td height='20px'>Владение мячом</td><td style='text-align:left; font-size:17px;'><img style='height:16px; width:".($game_statistics_array['possession_guest'] + 70)."px;' src='images/blue.png'>&nbsp;&nbsp;".$game_statistics_array['possession_guest']."%</td></tr>";
echo "<tr><td style='text-align:right; font-size:17px;'>".$game_statistics_array['shots_owner']."&nbsp;&nbsp;<img style='height:16px; width:".($game_statistics_array['shots_owner'] * 20)."px;' src='images/blue.png'></td><td height='20px'>Удары</td><td style='text-align:left; font-size:17px;'><img style='height:16px; width:".($game_statistics_array['shots_guest'] * 30)."px;' src='images/blue.png'>&nbsp;&nbsp;".$game_statistics_array['shots_guest']."</td></tr>";
echo "<tr><td style='text-align:right; font-size:17px;'>".$game_statistics_array['shots_on_target_owner']."&nbsp;&nbsp;<img style='height:16px; width:".($game_statistics_array['shots_on_target_owner'] * 20)."px;' src='images/blue.png'></td><td height='20px'>Удары в створ</td><td style='text-align:left; font-size:17px;'><img style='height:16px; width:".($game_statistics_array['shots_on_target_guest'] * 20)."px;' src='images/blue.png'>&nbsp;&nbsp;".$game_statistics_array['shots_on_target_guest']."</td></tr>";
echo "<tr><td style='text-align:right; font-size:17px;'>".$game_statistics_array['shots_wide_owner']."&nbsp;&nbsp;<img style='height:16px; width:".($game_statistics_array['shots_wide_owner'] * 20)."px;' src='images/blue.png'></td><td height='20px'>Удары мимо</td><td style='text-align:left; font-size:17px;'><img style='height:16px; width:".($game_statistics_array['shots_wide_guest'] * 20)."px;' src='images/blue.png'>&nbsp;&nbsp;".$game_statistics_array['shots_wide_guest']."</td></tr>";
echo "<tr><td style='text-align:right; font-size:17px;'>".$game_statistics_array['corners_owner']."&nbsp;&nbsp;<img style='height:16px; width:".($game_statistics_array['corners_owner'] * 20)."px;' src='images/blue.png'></td><td height='20px'>Угловые</td><td style='text-align:left; font-size:17px;'><img style='height:16px; width:".($game_statistics_array['corners_guest'] * 20)."px;' src='images/blue.png'>&nbsp;&nbsp;".$game_statistics_array['corners_guest']."</td></tr>";
echo "<tr><td style='text-align:right; font-size:17px;'>".$game_statistics_array['offsides_owner']."&nbsp;&nbsp;<img style='height:16px; width:".($game_statistics_array['offsides_owner'] * 20)."px;' src='images/blue.png'></td><td height='20px'>Офсайды</td><td style='text-align:left; font-size:17px;'><img style='height:16px; width:".($game_statistics_array['offsides_guest'] * 20)."px;' src='images/blue.png'>&nbsp;&nbsp;".$game_statistics_array['offsides_guest']."</td></tr>";
echo "<tr><td style='text-align:right; font-size:17px;'>".$game_statistics_array['saves_owner']."&nbsp;&nbsp;<img style='height:16px; width:".($game_statistics_array['saves_owner'] * 20)."px;' src='images/blue.png'></td><td height='20px'>Сэйвы</td><td style='text-align:left; font-size:17px;'><img style='height:16px; width:".($game_statistics_array['saves_guest'] * 20)."px;' src='images/blue.png'>&nbsp;&nbsp;".$game_statistics_array['saves_guest']."</td></tr>";
echo "<tr><td style='text-align:right; font-size:17px;'>".$game_statistics_array['fouls_owner']."&nbsp;&nbsp;<img style='height:16px; width:".($game_statistics_array['fouls_owner'] * 20)."px;' src='images/blue.png'></td><td height='20px'>Нарушения</td><td style='text-align:left; font-size:17px;'><img style='height:16px; width:".($game_statistics_array['fouls_guest'] * 20)."px;' src='images/blue.png'>&nbsp;&nbsp;".$game_statistics_array['fouls_guest']."</td></tr>";
echo "<tr><td style='text-align:right; font-size:17px;'>".$game_statistics_array['yellow_cards_owner']."&nbsp;&nbsp;<img style='height:16px; width:".($game_statistics_array['yellow_cards_owner'] * 20)."px;' src='images/blue.png'></td><td height='20px'>Жёлтые карточки</td><td style='text-align:left; font-size:17px;'><img style='height:16px; width:".($game_statistics_array['yellow_cards_guest'] * 20)."px;' src='images/blue.png'>&nbsp;&nbsp;".$game_statistics_array['yellow_cards_guest']."</td></tr>";
echo "<tr><td style='text-align:right; font-size:17px;'>".$game_statistics_array['red_cards_owner']."&nbsp;&nbsp;<img style='height:16px; width:".($game_statistics_array['red_cards_owner'] * 20)."px;' src='images/blue.png'></td><td height='20px'>Красные карточки</td><td style='text-align:left; font-size:17px;'><img style='height:16px; width:".($game_statistics_array['red_cards_guest'] * 20)."px;' src='images/blue.png'>&nbsp;&nbsp;".$game_statistics_array['red_cards_guest']."</td></tr>";
echo "</table>";


echo "</div>";
/**
 * Конец статистики матча
 */



/**
 * Статистика игроков
 */

echo "<div id='players_statistics_table' style='display:none'>";

echo "<table><tr id='tr_header'><td onclick='changeActive(strikers_statistics)' id='td_strikers_statistics' style='background-color:#D0F500'><a id='strikers_statistics'  style='color:black'>Бомбардиры</a>&nbsp;&nbsp;<img style='height:15px;width:15px;' src='images/ball.png'></td><td onclick='changeActive(yellow_cards_statistics)' id='td_yellow_cards_statistics' ><a id='yellow_cards_statistics' style='color:#D0F500'>Жёлтые карточки</a>&nbsp;&nbsp;<img style='height:15px;width:15px;' src='images/yellow_card.gif'></td><td onclick='changeActive(red_cards_statistics)' id='td_red_cards_statistics'><a id='red_cards_statistics' style='color:#D0F500'>Красные карточки</a>&nbsp;&nbsp;<img style='height:15px;width:15px;' src='images/red_card.gif'></td></tr></table>";


echo "<div id='strikers_statistics_table'><table>";
echo "<tr id='tr_header'><td style='width:10px'>#</td><td>Игрок</td><td>Команда</td><td>Амплуа</td><td style='width:10px'>Кол-во голов</td></tr>";

$i = 0;
foreach ($strikers_array as $row_strikers) {
	$i++;
	echo "<tr><td>{$i}<td>".$row_strikers['player_name']."<td>".$row_strikers['player_team_name']."</td><td>".$row_strikers['player_position']."</td><td><center>".$row_strikers['goal_count']."&nbsp;&nbsp;<img style='height:10px;width:10px;' src='images/ball.png'></center></td></tr>";
}


echo "</table></div>";

echo "<div id='yellow_cards_statistics_table' style='display:none'><table>";
echo "<tr id='tr_header'><td style='width:10px'>#</td><td>Игрок</td><td>Команда</td><td>Амплуа</td><td style='width:100px;'>Кол-во карточек</td></tr>";
$i = 0;
foreach ($yellow_cards_statistics_array as $row_yellow_cards) {
	$i++;
	echo "<tr><td>{$i}<td>".$row_yellow_cards['player_name']."<td>".$row_yellow_cards['player_team_name']."</td><td>".$row_yellow_cards['player_position']."</td><td><center>".$row_yellow_cards['cards_count']."&nbsp;&nbsp;<img style='height:10px;width:10px;' src='images/yellow_card.gif'></center></td></tr>";
}
echo "</table></div>";

echo "<div id='red_cards_statistics_table' style='display:none'><table>";
echo "<tr id='tr_header'><td style='width:10px'>#</td><td>Игрок</td><td>Команда</td><td>Амплуа</td><td style='width:100px;'>Кол-во карточек</td></tr>";
$i = 0;
foreach ($red_cards_statistics_array as $row_red_cards) {
	$i++;
	echo "<tr><td>{$i}<td>".$row_red_cards['player_name']."<td>".$row_red_cards['player_team_name']."</td><td>".$row_red_cards['player_position']."</td><td><center>".$row_red_cards['cards_count']."&nbsp;&nbsp;<img style='height:10px;width:10px;' src='images/red_card.gif'></center></td></tr>";
}
echo "</table></div>";
echo "</div>"

/**
 * Конец статистики игроков
 */
?>

</body>
<script language="JavaScript">
	var newWindow; //глобальная переменная для ссылки на окно
	function openWindow(id_game){ //открытие первого окна
		window.status = "Первое окно /*статусная строка главного окна*/";
		strfeatures = "top=200,left=150, width=550, height=550, scrollbars=yes, location=no";
		window.open("statistics.php?id_game="+id_game, "Win1", strfeatures);
	}
</script>

</html>