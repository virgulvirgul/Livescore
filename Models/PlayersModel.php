<?php
require_once '../Config/config.php.inc';
// id_player
// name;
// birth;
class PlayersModel {
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * 
	 * Получаем всех игроков
	 */
	public function getAllPlayers() {
		$query = "SELECT id_player, first_name, last_name, birth FROM players";
		return $this->getQuery($query, "Невозможно получить всех игроков ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем все поля по ID игрока
	 * @param ID игрока $id_player
	 */
	public function getPlayerById($id_player) {
		$query = "SELECT id_player, first_name, last_name birth FROM players WHERE id_player = ".$id_player."";
		return $this->getQuery($query, "Невозможно получить игрока по ID ", __FUNCTION__);
	}
	/**
	*
	* Получаем фамилию по ID игрока
	* @param ID игрока $id_player
	*/
	public function getPlayerLastNameById($id_player) {
		$query = "SELECT last_name FROM players WHERE id_player = ".$id_player."";
		return $this->getQuery($query, "Невозможно получить фамилию игрока по ID ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	*
	* Получаем имя по ID игрока
	* @param ID игрока $id_player
	*/
	public function getPlayerFirstNameById($id_player) {
		$query = "SELECT first_name FROM players WHERE id_player = ".$id_player."";
		return $this->getQuery($query, "Невозможно получить имя игрока по ID ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	*
	* Получаем возраст игрока по его id
	* @param id игрока $id_player
	*/
	public function getPlayerAgeById($id_player) {
		$query = "SELECT (YEAR(NOW())-YEAR(birth))
								FROM players
									WHERE id_player = {$id_player}";
		return $this->getQuery($query, "Невозможно получить возраст по id игрока", __FUNCTION__)->fetchColumn(0);
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