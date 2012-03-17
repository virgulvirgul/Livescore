<?php
require_once '../Config/config.php.inc';
// id_player;
// id_team;
// player_number
// player_position
class TeamPlayersModel {
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * 
	 * Получаем всех игроков всех команд
	 * @throws PDOException
	 */
	public function getAllTeamPlayers() {
		$query = "SELECT id_team_player, id_player, id_team, player_number, player_position
			FROM team_players";
		return $this->getQuery($query, "Невозможно получить всех игроков всех команд", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем всех игроков данной команды
	 * @param id команды $id
	 * @throws PDOException
	 */
	public function getTeamPlayersByTeamId($id) {
		$query = "SELECT id_team_player, id_player, id_team, player_number, player_position
					FROM team_players WHERE id_team = {$id}";
		return $this->getQuery($query, "Невозможно получить всех игроков команды (по id_team) ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем номер игрока по его id
	 * @param ID игрока $id
	 * @throws PDOException
	 */
	public function getTeamPlayersPlayerNumberByPlayerId($id) {
		$query = "SELECT player_number FROM team_players WHERE id_player = {$id}";
		return $this->getQuery($query, "Невозможно получить номер игрока по ID ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Получаем позицию игрока по его id
	 * @param ID игрока $id
	 * @throws PDOException
	 */
	public function getTeamPlayersPlayerPositionByPlayerId($id) {
		$query = "SELECT player_position FROM team_players WHERE id_player = {$id}";
		return $this->getQuery($query, "Невозможно получить позицию игрока по ID ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Получаем в какой команде играет игрок по id игрока
	 * @param ID игрока $id
	 * @throws PDOException
	 */
	public function getTeamPlayersIdTeamByPlayerId($id) {
		$query = "SELECT id_team FROM team_players WHERE id_player = {$id}";
		return $this->getQuery($query, "Невозможно получить id команды по id игрока ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Выполняем запрос
	 * @param запрос $query
	 * @param сообщение исключения $exception_message
	 * @param имя функции $function
	 * @throws PDOException
	 */
	private function getQuery($query, $exception_message, $function) {
		$exec = $this->pdo->query($query);
		if (! $exec) {
			throw new PDOException($exception_message."{".__CLASS__.".".$function."}");
		}
			else return $exec;
	}
}

?>