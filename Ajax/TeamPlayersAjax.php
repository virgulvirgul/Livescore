<?php
require_once '../Scripts/autoload.php';

class TeamPlayersAjax {
	/**
	 * 
	 * PlayersModel
	 */
	private $playersModel;
	/**
	 * 
	 * TeamPlayersModel
	 */
    private $teamPlayersModel;
    /**
     * 
     * TeamsModel
     */
    private $teamsModel;
    
    /**
     * 
     * Определяет что будем делать (delete, move, edit, showPlayerName, showPlayerNumber)
     */
	private $action;
	/**
	 * 
	 * id игрока
	 */
	private $id_player;
	/**
	 * 
	 * Имя игрока
	 */
	private $player_name;
	/**
	 * 
	 * Номер игрока
	 */
    private $player_number;
    /**
     * 
     * Позиция игрока
     */
    private $player_position;
    /**
     * 
     * Дата рождения игрока (нужна при добавлении нового игрока)
     */
    private $player_birth;
    /**
     * 
     * Имя команды в которой играет игрок
     */
    private $team_name;
    /**
     * 
     * id команды в которой игрок нахожится в данный момент
     */
    private $current_id_team;
	public function __construct($action, $id_player = null, $player_name = null, $player_number = null, $player_position = null,
								$player_birth = null, $team_name = null, $current_id_team = null) {
		$this->playersModel = new PlayersModel();
		$this->teamPlayersModel = new TeamPlayersModel();
		$this->teamsModel = new TeamsModel();
		
		$this->action = $action;
		if($id_player != null) $this->id_player = $id_player;
		if($player_name != null) $this->player_name = $player_name;
        if($player_number != null) $this->player_number = $player_number;
        if($player_position != null) $this->player_position = $player_position;
        if($player_birth != null) $this->player_birth = $player_birth;
        if($team_name != null) $this->team_name = $team_name;
        if($current_id_team != null) $this->current_id_team = $current_id_team;
        
		if($this->action == "showPlayerName" && $this->id_player != null) $this->showPlayerName();
        if($this->action == "showPlayerNumber" && $this->id_player != null) $this->showPlayerNumber();
		if($this->action == "edit" && $this->id_player != null) $this->editPlayer();
		if($this->action == "move") $this->movePlayer();	
		if($this->action == "delete") $this->deletePlayer();	
		if($this->action == "add") $this->addPlayer();
		
	}
	/**
     * Показываем имя игрока
     */
	private function showPlayerName() {
		echo $this->playersModel->getPlayerNameById($this->id_player);
	}
	/**
	 * Показываем номер игрока
	 */
    private function showPlayerNumber() {
        echo $this->teamPlayersModel->getTeamPlayersPlayerNumberByPlayerId($this->id_player);
    }
    /**
     * Изменение игрока
     */
	private function editPlayer() {
		/**
		* Если игрок с таким именем есть то выдаём ошибку
		*/
		if ($this->player_name != null && $this->playersModel->checkDuplicatePlayer($this->player_name)) {
            echo "errorName";
        }
        else
        /**
		* Если игрок с таким номером уже есть то выводим ошибку
		*/
        if ($this->player_number != null && $this->teamPlayersModel->checkDuplicatePlayerNumber($this->player_number, $this->current_id_team)) {
            echo "errorNumber";
        }
        /**
		* Иначе обновляем только те данные, которые были изменены
		*/
            if ($this->player_number != null  && $this->teamPlayersModel->checkDuplicatePlayerNumber($this->player_number, $this->current_id_team) == false) $this->teamPlayersModel->updatePlayerNumberByPlayerId($this->id_player, $this->player_number);
            if ($this->player_name != null && $this->playersModel->checkDuplicatePlayer($this->player_name) == false) $this->playersModel->updatePlayerName($this->id_player, $this->player_name);
            if ($this->player_position != null) {
               $this->teamPlayersModel->updatePlayerPositionByPlayerId($this->id_player, $this->player_position);
           }
	}
	/**
	 * Перемещение игрока
	 */
	private function movePlayer() {
		/**
		 * Если не существует команды с данным именем выводим ошибку
		 */
		if ($this->teamsModel->checkDuplicateTeam($this->team_name) != true) {
			echo "errorTeamName";
		}
		/**
		 * Если игрок с данным номером уже существует в команде выводим ошибку
		 */
		else if ($this->teamPlayersModel->checkDuplicatePlayerNumber($this->player_number, $this->teamsModel->getTeamIdByName($this->team_name)) == true) {
			echo "errorNumber";
		}
		/**
		 * Иначе перемещаем игрока
		 */
		else {
			$this->teamPlayersModel->moveTeamPlayerByPlayerId($this->id_player, $this->teamsModel->getTeamIdByName($this->team_name),
																$this->player_number, $this->player_position);
		}
	}
	/**
	 * Удаление игрока
	 */
	private function deletePlayer() {
		$this->playersModel->deletePlayerByPlayerId($this->id_player);
		$this->teamPlayersModel->deleteTeamPlayer($this->id_player);
	}
	/**
	 * Добавление игрока
	 */	
	private function addPlayer() {
		/**
		 * Если игрок с таким именем есть то выдаём ошибку
		 */
		if ($this->playersModel->checkDuplicatePlayer($this->player_name)) {
			echo "errorName";
		}
		else
		/**
		 * Если игрок с таким номером уже есть то выводим ошибку
		 */
		if ($this->teamPlayersModel->checkDuplicatePlayerNumber($this->player_number, $this->current_id_team)) {
			echo "errorNumber";
		}
		/**
		 * Иначе добавляем данные в таблицы players и team_players
		 */
		else {
			$this->playersModel->addPlayer($this->player_name, $this->player_birth);
			$this->teamPlayersModel->addTeamPlayer($this->playersModel->getLastInsertedPlayerId(),
					 $this->current_id_team, $this->player_number, $this->player_position);
		}
			
	}
}

$playerAjax = new TeamPlayersAjax($_POST['action'], $_POST['id_player'], $_POST['name'], $_POST['player_number'], $_POST['player_position'],
									$_POST['player_birth'], $_POST['team_name'], $_POST['id_team']);
?>
