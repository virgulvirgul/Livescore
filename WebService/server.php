<?php 
require_once '../Scripts/autoload.php';


function getContent() {
	$continentsModel = new ContinentsModel();
	$countriesModel = new CountriesModel();
	$teamPlayersModel = new TeamPlayersModel();
	$usersModel = new UsersModel();
	$gamesModel = new GamesModel();
	$teamsModel = new TeamsModel();
	$championshipsModel = new ChampionshipsModel();
	
	$i = 0;
	$dates = array();
	$returned_array = array();
	foreach ($gamesModel->getAllNearestDates() as $row) {
		$dates[] = $row['date'];
	}
	foreach ($dates as $date) {
		$allDate = $date;
		$year = substr($allDate, 0, 4);
		$month = substr($allDate, 5, 2);
		$day = substr($allDate, 8, 2);
		$hour = substr($allDate, 11, 2);
		$minute = substr($allDate, 14, 2);
		$date = date('d F, l',mktime($hour,$minute,0,$month, $day, $year));
		$hour = date('H : i',mktime($hour,$minute));
		$month_for_sql = date('n',mktime(0, 0, 0, $month));
		$day_for_sql = date('j',mktime(0, 0, 0, 0, $day));
		
		foreach ($gamesModel->getChampionshipIdByDate($year, $month_for_sql, $day_for_sql) as $row) {
			$championship_name = $championshipsModel->getChampionshipNameById($row['id_championship']);
			$country_name = $countriesModel->getCountryNameById($championshipsModel->getIdCoutryByChampionshipId($row['id_championship']));
			
			$returned_array[] = array("country_name" => $country_name, "championship_name" => $championship_name);
				
			foreach ($gamesModel->getAllGamesByDateAndChampioshipId($year, $month_for_sql, $day_for_sql, $row['id_championship']) as $row) {
				$i++;
				$team_owner_name = $teamsModel->getTeamNameByTeamId($row['id_team_owner']);
				$team_guest_name = $teamsModel->getTeamNameByTeamId($row['id_team_guest']);
				$hour = substr($row['date'], 0, 2);
				$minute = substr($row['date'], 3, 2);
				$hour = date('H : i',mktime($hour,$minute));
				if ($i % 2 == 0) $backgroundColor = '#5475ED';
				else $backgroundColor = '';
	
				$team_owner_score = $gamesModel->getScoreOwnerByGameId($row['id_game']);
				$team_guest_score = $gamesModel->getScoreGuestByGameId($row['id_game']);
	
				echo "<tr>
				<td style='background-color:".$backgroundColor.";' width='5px'>";
				if ($gamesModel->getFinishedByGameId($row['id_game']) == 1 ||
						$gamesModel->getMinutesByGameId($row['id_game']) > 130) {
					$hour = 'FT';
				}
				else if ($gamesModel->getBreakByGameId($row['id_game']) == 1) {
					$hour = "<img src='".$SITE_IMAGES."flash.gif'>&nbspHT";
				}
				else if ($gamesModel->getMinutesByGameId($row['id_game']) < 130  &&
						($gamesModel->getMinutesByGameId($row['id_game']) > 0)) {
					if($gamesModel->getScoreGuestByGameId($row['id_game']) == '?') {
						$gamesModel->setScores($row['id_game']);
					}
					$minute = round($gamesModel->getMinutesByGameId($row['id_game']));
					if ($minute >= 45 && $minute < 60) {
						$minute = 45;
					}
					if ($minute >= 60 && $minute < 105) {
						$minute = round($gamesModel->getMinutesByGameId($row['id_game'])) - 15;
					}
					if ($minute >= 105) {
						$minute = "90";
					}
					$hour = "<img src='".$SITE_IMAGES."flash.gif'>&nbsp".$minute."'";
				}
				echo $hour."</td>";
				
				$returned_array[] = array("hour" => $hour);
				$returned_array[] = array("team_owner_name" => $team_owner_name, "team_guest_name" => $team_guest_name,
											"$eam_owner_score" => $team_owner_score, "team_guest_score" => $team_guest_score);
				echo "<td style='background-color:".$backgroundColor.";' align='right' width='100px'><div align='right'>".$team_owner_name."</div>
				<td style='background-color:".$backgroundColor.";' width='20px'>
				<div align='center'><a href='index.php?id_game=".$row['id_game']."'> ".$team_owner_score." - ".$team_guest_score." </a> </div></td>
				<td style='background-color:".$backgroundColor.";' width='100px'><div align='left'>".$team_guest_name."</div></td></td>
				</tr>";
			}
		}
	}
	return $returned_array;
}



function hello($someone) { 
   return "Hello " . $someone . "!";
} 
   $server = new SoapServer(null, 
      array('uri' => "urn://www.livescore.com/res"));
  // $server->setClass("Livescore");
   $server->addFunction("getContent"); 
   $server->handle(); 
?>