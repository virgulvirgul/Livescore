<?php

require_once '../Scripts/autoload.php';
class GamesAjax {
	/**
	 Выбираем что будем делать (edit, delete)
	 */
	private $action;
	/**
	 * 
	 * GamesModel()
	 */
	private $gamesModel;
	/**
	 * 
	 * TeamsModel()
	 */
	private $teamsModel;
	/**
		TeamPlayersModel
	 */
	private $teamPlayersModel;
	/**
	 * 
	 * PlayersModel()
	 */
	private $playersModel;
	/**
	 * 
	 * id команды
	 */
	private $team_name;
	/**
	 * 
	 * StadiumsModel()
	 */
	private $stadiumsModel;
	private $teamGamePlayersModel;
	private $team_owner_id;
	private $team_guest_id;
	private $team_owner_start;
	private $team_guest_start;
	private $tour;
	private $id_referee;
	private $date;
	private $stadium_name;
	private $forecast;
	private $announcement;
	private $id_team;
	private $id_player;
	private $minute;
	private $id_game;
	private $id_second_player;
	private $year;
	private $month;
	private $id_championship;
	private $own_goal;
	private $team_owner_goal_diff;
	private $team_guest_goal_diff;
	private $COUNTRY_IMAGES = '../Images/countries_flags/';
	private $SITE_IMAGES = '../Images/site_images/';
	private $STADIUMS_IMAGES = '../Images/stadiums/';
	public function __construct($action = null, $team_name = null, $team_owner_id = null, $team_guest_id = null, $team_owner_start = null, 
								$team_guest_start = null, $tour = null, $id_referee = null, $date = null, $stadium_name = null, $forecast = null,
								$announcement = null, $id_team = null,
								$id_player = null, $minute = null, $id_game = null, $id_second_player = null, $year = null,
								$month = null, $id_championship = null, $own_goal = null, $team_owner_goal_diff = null, $team_guest_goal_diff = null) {
		$this->teamPlayersModel = new TeamPlayersModel();
		$this->playersModel = new PlayersModel();
		$this->teamsModel = new TeamsModel();
		$this->stadiumsModel = new StadiumsModel();
		$this->gamesModel = new GamesModel();
		$this->teamGamePlayersModel = new TeamGamePlayersModel();
		
		$this->action = $action;
		
		if ($team_name != null) $this->team_name = $team_name;
		if ($team_owner_id != null) $this->team_owner_id = $team_owner_id;
		if ($team_guest_id != null) $this->team_guest_id = $team_guest_id;
		if ($team_owner_start != null) $this->team_owner_start = $team_owner_start;
		if ($team_guest_start != null) $this->team_guest_start = $team_guest_start;
		if ($tour != null) $this->tour = $tour;
		if ($id_referee != null) $this->id_referee = $id_referee;
		if ($date != null) $this->date = $date;
		if ($stadium_name != null) $this->stadium_name = $stadium_name;
		if ($id_team != null) $this->id_team = $id_team;
		if ($id_player != null) $this->id_player = $id_player;
		if ($minute != null) $this->minute = $minute;
		if ($id_game != null) $this->id_game = $id_game;
		if ($id_second_player != null) $this->id_second_player = $id_second_player;
		if ($year != null) $this->year = $year;
		if ($month != null) $this->month = $month;
		if ($id_championship != null) $this->id_championship = $id_championship;
		if ($own_goal != null) $this->own_goal = $own_goal;
		if ($team_owner_goal_diff != null) $this->team_owner_goal_diff = $team_owner_goal_diff;
		if ($team_guest_goal_diff != null) $this->team_guest_goal_diff = $team_guest_goal_diff;
		if ($forecast != null) $this->forecast = $forecast;
		if ($announcement != null) $this->announcement = $announcement;
		
		if ($this->action == "showPlayers") $this->showTeamPlayersAndStadium();
		if ($this->action == "addGame") $this->addGame();
		if ($this->action == "scored") $this->scored();
		if ($this->action == "yellow_card") $this->yellow_card();
		if ($this->action == "red_card") $this->red_card();
		if ($this->action == "substitution") $this->substitution();
		if ($this->action == "break") $this->match_break();
		if ($this->action == "break_end") $this->match_break_end();
		if ($this->action == "finished") $this->finished();
		if ($this->action == "showMonthes") $this->showMonthes();
		if ($this->action == "showArchive") $this->showArchive();
		if ($this->action == "penalty_shootout_start") $this->penalty_shootout_start();
		if ($this->action == "penalty_scored") $this->penalty_scored();
		if ($this->action == "penalty_not_scored") $this->penalty_not_scored();
		if ($this->action == "postponed") $this->posponed_game();
		
	}
	/**
	 * Показываем всех игроков из данной команды
	 */
	private function showTeamPlayersAndStadium() {
		$players = array();	
		$id_team = $this->teamsModel->getTeamIdByName($this->team_name);
		foreach($this->teamPlayersModel->getTeamPlayersByTeamId($id_team) as $row) {
			$player_name = $this->playersModel->getPlayerNameById($row['id_player']);
			$players[] = array('id_player' => $row['id_player'], 'player_number' => $row['player_number'], 'player_name' => $player_name);
		}
		$id_stadium = $this->stadiumsModel->getStadiumIdByTeamId($id_team);
		$stadium_name = $this->stadiumsModel->getStadiumNameById($id_stadium);
		$stadium_image = $this->stadiumsModel->getStadiumImageByStadiumId($id_stadium);
		$stadium_capacity = $this->stadiumsModel->getStadiumCapacityById($id_stadium);
		
		$stadium = array('stadium_name'=>$stadium_name, 'stadium_image'=>$stadium_image, 
							'stadium_capacity'=>$stadium_capacity);
		
		$result = array('players' => $players, 'stadium' => $stadium);
		print json_encode($result);
	}
	/**
	 * Добавление игры
	 */
	private function addGame() {
		$id_championship = $this->teamsModel->getChampionshipIdByTeamId($this->team_owner_id);
		$id_stadium = $this->stadiumsModel->getStadiumIdByName($this->stadium_name);
		$this->gamesModel->addGame($this->date, $this->team_owner_id, $this->team_guest_id, $id_championship, $this->tour,
						$this->id_referee, $id_stadium, $this->forecast, $this->announcement, '');
		$id_game = $this->gamesModel->getLastInsertedGameId();
		$this->teamGamePlayersModel->addTeamGamePlayers(implode(',', $this->team_owner_start), $this->team_owner_id, $id_game);
		$this->teamGamePlayersModel->addTeamGamePlayers(implode(',', $this->team_guest_start), $this->team_guest_id, $id_game);
	}
	/**
	 * Обрабатываем забитый гол.
	 */
	private function scored() {
		if($this->own_goal == 1) {
			$this->gamesModel->updateOwnGoalScoreByGameId($this->id_game, $this->id_team);
			$this->teamGamePlayersModel->updateScoreByGameId($this->id_game, 
				$this->gamesModel->getAnotherTeamByTeamAndGameId($this->id_team, $this->id_game), $this->id_player, $this->minute."'' (own goal)");
		}
		else {
			$this->teamGamePlayersModel->updateScoreByGameId($this->id_game, $this->id_team, $this->id_player, $this->minute."''");
			$this->gamesModel->updateScoreByGameId($this->id_game, $this->id_team);
		}
	}
	/**
	 * Получение игроком жёлтой карточки
	 */
	private function yellow_card() {
		$this->teamGamePlayersModel->updateYellowCardByGameId($this->id_game, $this->id_team, $this->id_player, $this->minute."''");
	}
	/**
	 * Получение игроком красной карточки
	 */
	private function red_card() {
		$this->teamGamePlayersModel->updateRedCardByGameId($this->id_game, $this->id_team, $this->id_player, $this->minute."''");
	}
	/**
	 * Замена игрока
	 */
	private function substitution() {
		$this->teamGamePlayersModel->updateSubstitutionByGameId($this->id_game, $this->id_team, $this->id_player, $this->id_second_player, $this->minute."''");
	}
	/**
	 * Обраотка перерывы
	 */
	private function match_break() {
		$this->gamesModel->updateBreakByGameId($this->id_game);
	}
	/**
	 * Обработка перерыва
	 */
	private function match_break_end() {
		$this->gamesModel->updateBreakEndByGameId($this->id_game);
	}
	/**
	 * Обработка конца матча
	 */
	private function finished() {
		$this->teamsModel->updateStatisticsByTeamId($this->team_owner_goal_diff, $this->team_owner_id);
		$this->teamsModel->updateStatisticsByTeamId($this->team_guest_goal_diff, $this->team_guest_id);
		$this->gamesModel->updateFinishedByGameId($this->id_game);
	}
	private function posponed_game() {
		$this->gamesModel->updatePostponedByGameId($this->id_game);
	}
	private function showMonthes() {
		$monthes = array();
		$allDate = $row_date['date'];
		$year = substr($allDate, 0, 4);
		$month = substr($allDate, 5, 2);
		$day = substr($allDate, 8, 2);
		$hour = substr($allDate, 11, 2);
		$minute = substr($allDate, 14, 2);
		$date = date('d F, l',mktime($hour,$minute,0,$month, $day, $year));
			
		foreach($this->gamesModel->getMonthesByYearAndChampionshipId($this->year, $this->id_championship) as $row) {
			$monthes[] = array('month_name' => date('F',mktime(0,0,0,$row['date'])), 'month' => $row['date']);
		}
		$result = array('monthes' => $monthes);
		print json_encode($result);
	}
	
	private function penalty_shootout_start() {
		$this->gamesModel->setPealtyShootoutByGameId($this->id_game);
	}
	private function penalty_scored() {
		$this->gamesModel->updatePenaltyScoredByTeamAndGameId($this->id_team, $this->id_game);
		$this->teamGamePlayersModel->updatePenaltyScoredByGameId($this->id_game, $this->id_team, $this->id_player);
	}
	private function penalty_not_scored() {
		$this->teamGamePlayersModel->updatePenaltyNotScoredByGameId($this->id_game, $this->id_team, $this->id_player);
	}
	private function showArchive() {
		$id_championship = $this->id_championship;
		
		
		echo "<br><br><center><table style='border:0;'>";
		$i = 0;
		foreach ($this->gamesModel->getGamesByYearMonthChampionshipId($this->year, $this->month, $id_championship) as $number=>$row_date) {
			$allDate = $row_date['date'];
			$year = substr($allDate, 0, 4);
			$month = substr($allDate, 5, 2);
			$day = substr($allDate, 8, 2);
			$hour = substr($allDate, 11, 2);
			$minute = substr($allDate, 14, 2);
			$date = date('d F, l',mktime($hour,$minute,0,$month, $day, $year));
			
			$hour = date('H : i',mktime($hour,$minute));
			
			
			$month_for_sql = date('n',mktime(0, 0, 0, $month));
			
			$day_for_sql = date('j',mktime(0, 0, 0, 0, $day));
			echo "<tr id='tr_header'><td colspan='4'>".$date."</td></tr>";
				
			foreach ($this->gamesModel->getAllGamesByDateAndChampioshipId($year, $month_for_sql, $day_for_sql, $id_championship) as $row) {
				$i++;
				$team_owner_name = $this->teamsModel->getTeamNameByTeamId($row['id_team_owner']);
				$team_guest_name = $this->teamsModel->getTeamNameByTeamId($row['id_team_guest']);
				$team_owner_score = $this->gamesModel->getScoreOwnerByGameId($row['id_game']);
				$team_guest_score = $this->gamesModel->getScoreGuestByGameId($row['id_game']);
				$hour = substr($row['date'], 0, 2);
				$minute = substr($row['date'], 3, 2);
				$hour = date('H : i',mktime($hour,$minute));
				if ($i % 2 == 0) $backgroundColor = '#5475ED';
					else $backgroundColor = '';
				echo "<tr>";
				
				echo "<tr>
				<td style='background-color:".$backgroundColor.";' width='5px'>";
				if (($this->gamesModel->getFinishedByGameId($row['id_game']) == 1 ||
						$this->gamesModel->getMinutesByGameId($row['id_game']) > 130) && $this->gamesModel->getPostponedByGameId($row['id_game']) == 0) {
					$hour = 'FT';
				}
				else if ($this->gamesModel->getPostponedByGameId($row['id_game']) == 1) {
					$hour = 'Postp';
				}
				else if ($this->gamesModel->getBreakByGameId($row['id_game']) == 1) {
					$hour = "<img src='".$this->SITE_IMAGES."flash.gif'>&nbspHT";
				}
				else if ($this->gamesModel->getMinutesByGameId($row['id_game']) < 130  &&
						($this->gamesModel->getMinutesByGameId($row['id_game']) > 0)) {
					if($this->gamesModel->getScoreGuestByGameId($row['id_game']) == '?') {
						$this->gamesModel->setScores($row['id_game']);
					}
					$minute = round($this->gamesModel->getMinutesByGameId($row['id_game']));
					if ($minute >= 45 && $minute < 60) {
						$minute = 45;
					}
					if ($minute >= 60 && $minute < 105) {
						$minute = round($this->gamesModel->getMinutesByGameId($row['id_game'])) - 15;
					}
					if ($minute >= 105) {
						$minute = "90";
					}
					$hour = "<img src='".$this->SITE_IMAGES."flash.gif'>&nbsp".$minute."'";
				}
				echo $hour."</td>";
				
				echo "
				<td style='background-color:".$backgroundColor.";' align='right' width='100px'><div align='right'>".$team_owner_name."</div>
				<td style='background-color:".$backgroundColor.";' width='20px'>
				<div align='center'><a href='index.php?id_game=".$row['id_game']."'> ".$team_owner_score." - ".$team_guest_score." </a> </div></td>
				<td style='background-color:".$backgroundColor.";' width='100px'><div align='left'>".$team_guest_name."</div></td></td>
					</tr>";
			}
		}
		echo "</table></center>";
	}
}

$gamesAjax = new GamesAjax($_POST['action'], $_POST['team_name'], $_POST['team_owner_id'], $_POST['team_guest_id'], $_POST['team_owner_start'], 
							$_POST['team_guest_start'], $_POST['tour'], $_POST['id_referee'], $_POST['date'], $_POST['stadium_name'], $_POST['forecast'],
							$_POST['announcement'], $_POST['id_team'], 
							$_POST['id_player'], $_POST['minute'], $_POST['id_game'], $_POST['id_second_player'], $_POST['year'], $_POST['month'],
							 $_POST['id_championship'], $_POST['own_goal'], $_POST['team_owner_goal_diff'], $_POST['team_guest_goal_diff']);
?>