<?php
require_once '../Models/PlayersModel.php';
require_once '../Models/ContinentsModel.php';
require_once '../Models/CountriesModel.php';
require_once '../Models/TeamPlayersModel.php';

class TeamPlayersAjax {
	private $playersModel;
    private $teamPlayersModel;
    private $continentsModel;
    private $countriesModel;
	private $action;
	private $id_player;
	private $player_name;
    private $player_number;
    private $player_position;
    private $continent_name;
	public function __construct($action, $id_player = null, $player_name = null, $player_number = null, $player_position = null,
								$continent_name = null) {
		$this->playersModel = new PlayersModel();
		$this->teamPlayersModel = new TeamPlayersModel();
		$this->continentsModel = new ContinentsModel();
		$this->countriesModel = new CountriesModel();
		
		$this->action = $action;
		if($id_player != null) $this->id_player = $id_player;
		if($player_name != null) $this->player_name = $player_name;
        if($player_number != null) $this->player_number = $player_number;
        if($player_position != null) $this->player_position = $player_position;
        if($continent_name != null) $this->continent_name = $continent_name;
        
		if($this->action == "showPlayerName" && $this->id_player != null) $this->showPlayerName();
        if($this->action == "showPlayerNumber" && $this->id_player != null) $this->showPlayerNumber();
        
		if($this->action == "edit" && $this->id_player != null) $this->editPlayer();
		
		if ($this->action == "showContinents") $this->showContinents();
		if ($this->action == "showCountries") $this->showCountries();
		
		
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
        if ($this->player_number && $this->teamPlayersModel->checkDuplicatePlayerNumber($this->player_number)) {
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
	}
	private function showContinents() {
		$continents = array();
		foreach ($this->continentsModel->getAllContinentsName() as $row) {
			$continents[] = array('name'=>$row['name']);
		}
		$result = array('continents'=>$continents);
		print json_encode($result);
	}
	private function showCountries() {
		$countries= array();
		foreach ($this->countriesModel->getCountriesByContinentName($this->continent_name) as $row) {
			$countries[] = array('name'=>$row['name']);
		}
		$result = array('countries'=>$countries);
		print json_encode($result);
	}
}

$playerAjax = new TeamPlayersAjax($_POST['action'], $_POST['id_player'], $_POST['name'], $_POST['player_number'], $_POST['player_position'],
									$_POST['continent_name']);
?>
