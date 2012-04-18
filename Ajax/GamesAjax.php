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
	private $id_team;
	private $id_player;
	private $minute;
	private $id_game;
	
	public function __construct($action = null, $team_name = null, $team_owner_id = null, $team_guest_id = null, $team_owner_start = null, 
								$team_guest_start = null, $tour = null, $id_referee = null, $date = null, $stadium_name = null, $id_team = null,
								$id_player = null, $minute = null, $id_game = null ) {
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
		
		if ($this->action == "showPlayers") $this->showTeamPlayersAndStadium();
		if ($this->action == "addGame") $this->addGame();
		if ($this->action == "scored") $this->scored();
		
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
	
	private function addGame() {
		$id_championship = $this->teamsModel->getChampionshipIdByTeamId($this->team_owner_id);
		$id_stadium = $this->stadiumsModel->getStadiumIdByName($this->stadium_name);
		$this->gamesModel->addGame($this->date, $this->team_owner_id, $this->team_guest_id, $id_championship, $this->tour,
						$this->id_referee, $id_stadium, '');
		$id_game = $this->gamesModel->getLastInsertedGameId();
		$this->teamGamePlayersModel->addTeamGamePlayers(implode(',', $this->team_owner_start), $this->team_owner_id, $id_game);
		$this->teamGamePlayersModel->addTeamGamePlayers(implode(',', $this->team_guest_start), $this->team_guest_id, $id_game);
	}
	/**
	 * Обрабатываем забитый гол.
	 */
	private function scored() {
		$this->teamGamePlayersModel->updateScoreByGameId($this->id_game, $this->id_team, $this->id_player, $this->minute);
	}
}

$gamesAjax = new GamesAjax($_POST['action'], $_POST['team_name'], $_POST['team_owner_id'], $_POST['team_guest_id'], $_POST['team_owner_start'], 
							$_POST['team_guest_start'], $_POST['tour'], $_POST['id_referee'], $_POST['date'], $_POST['stadium_name'], $_POST['id_team'], 
							$_POST['id_player'], $_POST['minute'], $_POST['id_game']);
?>