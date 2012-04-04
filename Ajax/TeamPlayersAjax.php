<?php
require_once '../Models/PlayersModel.php';
require_once '../Models/TeamPlayersModel.php';

class TeamPlayersAjax {
	private $playersModel;
    private $teamPlayersModel;
	private $action;
	private $id_player;
	private $player_name;
    private $player_number;
    private $player_position;
	public function __construct($action, $id_player = null, $player_name = null, $player_number = null, $player_position = null) {
		$this->playersModel = new PlayersModel();
		$this->teamPlayersModel = new TeamPlayersModel();
		
		$this->action = $action;
		if($id_player != null) $this->id_player = $id_player;
		if($player_name != null) $this->player_name = $player_name;
        if($player_number != null) $this->player_number = $player_number;
        if($player_position != null) $this->player_position = $player_position;
		if($this->action == "showPlayerName" && $this->id_player != null) $this->showPlayerName();
        if($this->action == "showPlayerNumber" && $this->id_player != null) $this->showPlayerNumber();
        
		if($this->action == "edit" && $this->id_player != null) $this->editPlayer();
		
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
            echo "errorName";
        }
        if ($this->teamPlayersModel->checkDuplicatePlayerNumber($this->player_number)) {
            echo "errorNumber";
        }
        /////////////// !!!!!!!!!!!!!!!!!!
            $this->teamPlayersModel->updatePlayerNumberByPlayerId($this->id_player, $this->player_number);
            $this->playersModel->updatePlayerName($this->id_player, $this->player_name);
            if ($this->player_position != "Выберите амплуа...") {
                $this->teamPlayersModel->updatePlayerPositionByPlayerId($this->id_player, $this->player_position);
            }
        
	}
}

$playerAjax = new TeamPlayersAjax($_POST['action'], $_POST['id_player'], $_POST['name'], $_POST['player_number'], $_POST['player_position']);
?>
