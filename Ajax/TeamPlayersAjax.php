<?php
require_once '../Models/PlayersModel.php';
require_once '../Models/TeamPlayersModel.php';

class TeamPlayersAjax {
	private $playersModel;
    private $teamPlayersModel;
	private $action;
	private $id_player;
	private $player_name;
	public function __construct($action, $id_player = null, $player_name = null) {
		$this->playersModel = new PlayersModel();
		$this->teamPlayersModel = new TeamPlayersModel();
		
		$this->action = $action;
		
		if($id_player != null) $this->id_player = $id_player;
		if($player_name != null) $this->player_name = $player_name;
		if($this->action == "showPlayerName" && $this->id_player != null) $this->showPlayerName();
        if($this->action == "showPlayerNumber" && $this->id_player != null) $this->showPlayerNumber();
        
		if($this->action == "edit" && $this->id_player != null && $this->player_name != null) $this->editPlayer();
		
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
		if ($this->playersModel->checkDuplicatePlayer($this->player_name)) {
            echo "error";
        }
        else $this->playersModel->updatePlayerName($this->id_player, $this->player_name);
	}
}

$playerAjax = new TeamPlayersAjax($_POST['action'], $_POST['id_player'], $_POST['name']);
?>
