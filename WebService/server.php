<?php 
require_once '../Scripts/autoload.php';


function getStatistics($id_game) {
	$continentsModel = new ContinentsModel();
	$countriesModel = new CountriesModel();
	$teamPlayersModel = new TeamPlayersModel();
	$usersModel = new UsersModel();
	$gamesModel = new GamesModel();
	$teamsModel = new TeamsModel();
	$championshipsModel = new ChampionshipsModel();
	$gamesController = new GamesController();
	$teamGamePlayersModel = new TeamGamePlayersModel();
	$playersModel = new PlayersModel();
	$refereesModel = new RefereesModel();
	$stadiumsModel = new StadiumsModel();
	
	$teams_array = array();
	$goals_array = array();
	$lines_up_team_owner = array();
	$lines_up_team_guest = array();
	$previous_meetings_array = array();
	
	foreach ($gamesModel->getGameByGameId($id_game) as $row) {
		$team_owner_name = $teamsModel->getTeamNameByTeamId($row['id_team_owner']);
		$team_guest_name = $teamsModel->getTeamNameByTeamId($row['id_team_guest']);
		$team_owner_score = $gamesModel->getScoreOwnerByGameId($row['id_game']);
		$team_guest_score = $gamesModel->getScoreGuestByGameId($row['id_game']);
		
		$teams_array[] = array("team_owner_name" => $team_owner_name, "team_guest_name" => $team_guest_name,
					"team_owner_score" => $team_owner_score, "team_guest_score" => $team_guest_score);
		
		
		$team_owner_players_id_array = explode(',', $teamGamePlayersModel->getPlayersIdByGameAndTeamId($row['id_game'], $row['id_team_owner']));
		$team_guest_players_id_array = explode(',', $teamGamePlayersModel->getPlayersIdByGameAndTeamId($row['id_game'], $row['id_team_guest']));
		
			for ($i = 0; $i < count($team_owner_players_id_array); $i++) {
		
				$id_player = $team_owner_players_id_array[$i];
				$player_number = $teamPlayersModel->getTeamPlayersPlayerNumberByPlayerId($id_player);
				$player_position = $teamPlayersModel->getTeamPlayersPlayerPositionByPlayerId($id_player);
				$player_name = $playersModel->getPlayerNameById($id_player);
				$lines_up_team_owner[] = array('player_owner_number' => $player_number, 'player_owner_position' => $player_position, 
											'player_owner_name' => $player_name);
			}
				
			for ($i = 0; $i < count($team_guest_players_id_array); $i++) {
				$id_player_guest = $team_guest_players_id_array[$i];
				$player_guest_number = $teamPlayersModel->getTeamPlayersPlayerNumberByPlayerId($id_player_guest);
				$player_guest_position = $teamPlayersModel->getTeamPlayersPlayerPositionByPlayerId($id_player_guest);
				$player_guest_name = $playersModel->getPlayerNameById($id_player_guest);
				
				$lines_up_team_guest[] = array('player_guest_number' => $player_guest_number, 'player_guest_position' => $player_guest_position,
						'player_guest_name' => $player_guest_name);
			}
		
		
		
		
		
		
		
		
		
		$goals = explode(',', $teamGamePlayersModel->getScoreByGameAndTeamId($row['id_game'], $row['id_team_owner']));
		$minute = 0;
		for ($i = 0; $i < count($goals); $i++) {
			if ($i % 2 != 0) {
				$minute = $goals[$i];
			//	$goals_array[] = array("team_owner_goal_minute" => $minute);
				$goals_array[] = array("team_owner_goal_minute" => $minute, 
						"team_owner_goal_player_name" => $playersModel->getPlayerNameById($player_goal_id));
				echo $minute.'\'<br>';
			}
			else
				if ($i % 2 == 0 && $goals[$i] != "") {
				$player_goal_id = $goals[$i];
				
				//echo "<img style='height:10px;width:8px;' float='left' src='".$this->SITE_IMAGES."goal.gif'>&nbsp".$this->playersModel->getPlayerNameById($player_goal_id)."&nbsp";
			}
		}
		
		$goals_guest = explode(',', $teamGamePlayersModel->getScoreByGameAndTeamId($row['id_game'], $row['id_team_guest']));
		$minute = 0;
		for ($i = 0; $i < count($goals_guest); $i++) {
			if ($i % 2 != 0) {
				$minute = $goals_guest[$i];
				//	$goals_array[] = array("team_owner_goal_minute" => $minute);
				$goals_array[] = array("team_guest_goal_minute" => $minute, 
						"team_guest_goal_player_name" => $playersModel->getPlayerNameById($player_goal_id));
				echo $minute.'\'<br>';
			}
			else
				if ($i % 2 == 0 && $goals_guest[$i] != "") {
				$player_goal_id = $goals_guest[$i];
		
				//echo "<img style='height:10px;width:8px;' float='left' src='".$this->SITE_IMAGES."goal.gif'>&nbsp".$this->playersModel->getPlayerNameById($player_goal_id)."&nbsp";
			}
		}
		$yellow_cards_owner_array = getCards('yellow', $row['id_game'], $row['id_team_owner']);
		$yellow_cards_guest_array = getCards('yellow', $row['id_game'], $row['id_team_guest']);
		
		$red_cards_owner_array = getCards('red', $row['id_game'], $row['id_team_owner']);
		$red_cards_guest_array = getCards('red', $row['id_game'], $row['id_team_guest']);
		
		$subs_owner_array = getSubstitutions($row['id_game'], $row['id_team_owner']);
		$subs_guest_array = getSubstitutions($row['id_game'], $row['id_team_guest']);
		
		foreach ($gamesModel->getPreviousMeetingsByTeamOwnerAndGuestId($row['id_team_owner'], $row['id_team_guest']) as $row_prev) {
			
			$team_owner_name_ = $teamsModel->getTeamNameByTeamId($row_prev['id_team_owner']);
			$team_guest_name_ = $teamsModel->getTeamNameByTeamId($row_prev['id_team_guest']);
				
			$previous_meetings_array[] = array("date" => $row_prev['date'], "team_owner_score" => $row_prev['score_owner'],
													"team_guest_score" => $row_prev['score_guest'], "id_game" => $row_prev['id_game'],
												"team_owner_name" => $team_owner_name_, "team_guest_name" => $team_guest_name_);
		}
		
		$referee = array("referee_name" => $refereesModel->getRefereeNameById($gamesModel->getRefereeIdByGameId($row['id_game'])));
		$stadium_image = "<img height='200px' width='200px'  src='http://localhost/Livescore/Images/stadiums/".$stadiumsModel->getStadiumImageByStadiumId($gamesModel->getRefereeIdByGameId($row['id_game']))."'";
		$stadium = array("stadium_name" => $stadiumsModel->getStadiumNameById($gamesModel->getStadiumIdByGameId($row['id_game'])),
							"stadium_image" => $stadium_image,
								"stadium_capacity" => $stadiumsModel->getStadiumCapacityById($gamesModel->getStadiumIdByGameId($row['id_game'])));
		
	}
	return array('teams_array' => $teams_array, "goals_array" => $goals_array,
			 "yellow_cards_owner_array" => $yellow_cards_owner_array, "yellow_cards_guest_array" => $yellow_cards_guest_array,
			 "red_cards_owner_array" => $red_cards_owner_array,
			"red_cards_guest_array" => $red_cards_guest_array,
			"subs_guest_array" => $subs_guest_array, "subs_owner_array" => $subs_owner_array, "lines_up_team_guest" => $lines_up_team_guest,
			"lines_up_team_owner" => $lines_up_team_owner, "previous_meetings_array" => $previous_meetings_array, "referee" => $referee,
			"stadium" => $stadium);
}
/**
 * Получаем карточки команды
 * @param 'yellow', 'red' $card
 * @param id игры $id_game
 * @param id команды $id_team
 */
function getCards($card, $id_game, $id_team) {
	$teamGamePlayersModel = new TeamGamePlayersModel();
	$playersModel = new PlayersModel();
	
	$cards_array = array();
	if ($card == 'yellow') {
		$cards = explode(',', $teamGamePlayersModel->getYellowCardByGameAndTeamId($id_game, $id_team));
	}
	else {
		$cards = explode(',', $teamGamePlayersModel->getRedCardByGameAndTeamId($id_game, $id_team));

	}
	for ($i = 0; $i < count($cards); $i++) {
		if ($i % 2 != 0) {
			$minute = $cards[$i];
			$cards_array[] = array("team_card_minute" => $minute,
					"team_card_player_name" => $playersModel->getPlayerNameById($player_card_id));
		}
		else
			if ($i % 2 == 0 && $cards[$i] != "") {
			$player_card_id = $cards[$i];
		}
	}
	return $cards_array;
}
/**
 * Получаем замены команды
 * @param id игры $id_game
 * @param id команды $id_team
 */
function getSubstitutions($id_game, $id_team) {
	$teamGamePlayersModel = new TeamGamePlayersModel();
	$playersModel = new PlayersModel();
	$substitution = explode(',', $teamGamePlayersModel->getSubstitutionByGameAndTeamId($id_game, $id_team));

	for ($i = 0; $i < count($substitution); $i++) {
			
		if (($i == 0 || $i % 3 == 0) && $substitution[$i] != "") {
			$player_first_id = $substitution[$i];
		}
		else {
			if ($i % 3 == 1 && $substitution[$i] != ""){
				$player_second_id = $substitution[$i];
			}
		}
		if ($i % 3 == 2 ){
			$minute = $substitution[$i];
			$substitution_array[] = array("team_substitution_minute" => $minute,
					"team_first_player_name" => $playersModel->getPlayerNameById($player_first_id),
					"team_second_player_name" => $playersModel->getPlayerNameById($player_second_id));
			echo $minute.'\'<br>';
		}
	}
	return $substitution_array;
}
function getNearestMatches() {
	$continentsModel = new ContinentsModel();
	$countriesModel = new CountriesModel();
	$teamPlayersModel = new TeamPlayersModel();
	$usersModel = new UsersModel();
	$gamesModel = new GamesModel();
	$teamsModel = new TeamsModel();
	$championshipsModel = new ChampionshipsModel();
	$COUNTRY_IMAGES = '../Images/countries_flags/';
	$SITE_IMAGES = '../Images/site_images/';
	$i = 0;
	$dates = array();
	$returned_array = array();
	$date_array = array();
	$match_array = array();
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
			
			$date_array[] = array("country_name" => $country_name, "championship_name" => $championship_name,
										"date" => $date);
			
			foreach ($gamesModel->getAllGamesByDateAndChampioshipId($year, $month_for_sql, $day_for_sql, $row['id_championship']) as $row) {
				$team_owner_name = $teamsModel->getTeamNameByTeamId($row['id_team_owner']);
				$team_guest_name = $teamsModel->getTeamNameByTeamId($row['id_team_guest']);
				$hour = substr($row['date'], 0, 2);
				$minute = substr($row['date'], 3, 2);
				$hour = date('H : i',mktime($hour,$minute));
	
				$team_owner_score = $gamesModel->getScoreOwnerByGameId($row['id_game']);
				$team_guest_score = $gamesModel->getScoreGuestByGameId($row['id_game']);
	
				if ($gamesModel->getFinishedByGameId($row['id_game']) == 1 ||
						$gamesModel->getMinutesByGameId($row['id_game']) > 130) {
					$hour = 'FT';
				}
				else if ($gamesModel->getBreakByGameId($row['id_game']) == 1) {
					$hour = "<img src='css/images/flash.gif'>&nbspHT";
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
					$hour = "<img src='css/images/flash.gif'>&nbsp".$minute."'";
				}
				$match_array[] = array("hour" => $hour, "id_game" => $row['id_game'], "team_owner_name" => $team_owner_name, "team_guest_name" => $team_guest_name,
											"team_owner_score" => $team_owner_score, "team_guest_score" => $team_guest_score);
			}
		}
	}
	return array('date_array' => $date_array, 'match_array' => $match_array);
}

   $server = new SoapServer(null, 
    						array('uri' => "urn://www.livescore.com/res"));
   $server->addFunction("getNearestMatches"); 
   $server->addFunction("getStatistics");
    
   $server->handle(); 
?>