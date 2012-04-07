<?php
require_once '../Models/PlayersModel.php';
require_once '../Models/ContinentsModel.php';
require_once '../Models/CountriesModel.php';
require_once '../Models/TeamPlayersModel.php';
require_once '../Models/TeamsModel.php';


class TeamPlayersAjax {
	private $playersModel;
    private $teamPlayersModel;
    private $teamsModel;
    
	private $action;
	private $id_player;
	private $player_name;
    private $player_number;
    private $player_position;
    private $team_name;
    private $current_id_team;
	public function __construct($action, $id_player = null, $player_name = null, $player_number = null, $player_position = null,
								$team_name = null, $current_id_team = null) {
		$this->playersModel = new PlayersModel();
		$this->teamPlayersModel = new TeamPlayersModel();
		$this->teamsModel = new TeamsModel();
		
		$this->action = $action;
		if($id_player != null) $this->id_player = $id_player;
		if($player_name != null) $this->player_name = $player_name;
        if($player_number != null) $this->player_number = $player_number;
        if($player_position != null) $this->player_position = $player_position;
        if($team_name != null) $this->team_name = $team_name;
        if($current_id_team != null) $this->current_id_team = $current_id_team;
        
		if($this->action == "showPlayerName" && $this->id_player != null) $this->showPlayerName();
        if($this->action == "showPlayerNumber" && $this->id_player != null) $this->showPlayerNumber();
		if($this->action == "edit" && $this->id_player != null) $this->editPlayer();
		if($this->action == "move") $this->movePlayer();		
		
	}
	/**
     * Показываем имя игрока
     */
	private function showPlayerName() {
		echo $this->playersModel->getPlayerNameById($this->id_player);
	}
    private function showPlayerNumber() {
        echo $this->teamPlayersModel->getTeamPlayersPlayerNumberByPlayerId($this->id_player);
    }
	private function editPlayer() {
		if ($this->player_name != null && $this->playersModel->checkDuplicatePlayer($this->player_name)) {
            echo "errorName";
        }
        if ($this->player_number && $this->teamPlayersModel->checkDuplicatePlayerNumber($this->player_number, $this->current_id_team)) {
            echo "errorNumber";
        }
        /////////////// !!!!!!!!!!!!!!!!!!
            if ($this->player_number != null) $this->teamPlayersModel->updatePlayerNumberByPlayerId($this->id_player, $this->player_number);
            if ($this->player_name != null) $this->playersModel->updatePlayerName($this->id_player, $this->player_name);
            if ($this->player_position != null) {
               $this->teamPlayersModel->updatePlayerPositionByPlayerId($this->id_player, $this->player_position);
           }
	}
	private function movePlayer() {
		if ($this->teamsModel->checkDuplicateTeam($this->team_name) != true) {
			echo "errorTeamName";
		}
		else if ($this->teamPlayersModel->checkDuplicatePlayerNumber($this->player_number, $this->teamsModel->getTeamIdByName($this->team_name)) == true) {
			echo "errorNumber";
		}
		else {
			$this->teamPlayersModel->moveTeamPlayerByPlayerId($this->id_player, $this->teamsModel->getTeamIdByName($this->team_name),
																$this->player_number, $this->player_position);
		}
	}
}

$playerAjax = new TeamPlayersAjax($_POST['action'], $_POST['id_player'], $_POST['name'], $_POST['player_number'], $_POST['player_position'],
									$_POST['team_name'], $_GET['id_team']);
?>
