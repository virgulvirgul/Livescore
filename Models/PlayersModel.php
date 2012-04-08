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
	* Получаем имя по ID игрока
	* @param ID игрока $id_player
	*/
	public function getPlayerNameById($id_player) {
		$query = "SELECT player_name FROM players WHERE id_player = ".$id_player."";
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
	 * Проверяем есть ли уже игрок с данным именем
	 * @param имя игрока $player_name
	 */
	public function checkDuplicatePlayer($player_name) {
		$query = "SELECT id_player FROM players WHERE player_name like '".$player_name."'";
		if ($this->getQuery($query, "Ошибка в ", __FUNCTION__)->rowCount() > 0) {
			return true;
		}
			else {
				return false;
			}
	}
	/**
	 * Обновляем имя игрока
	 * @param id игрока $id_player
	 * @param новое имя игрока $player_name
	 */
	public function updatePlayerName($id_player, $player_name) {
		$exec_query = "UPDATE players  
                        SET player_name='".$player_name."' 
                            WHERE id_player= {$id_player}";
        return $this->getExec($exec_query, "Невозможно обновить имя игрока", __FUNCTION__);
	}
	
	/**
 	 * Удаляем игрока по его id
	 * @param id игрока $id_player
	 */
	public function deletePlayerByPlayerId($id_player) {
		$exec_query = "DELETE FROM players
						WHERE id_player = {$id_player}";
		return $this->getExec($exec_query, "Невозможно удалить игрока", __FUNCTION__);
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
	/**
	*
	* Выполняем запрос exec (на update delete insert)
	* @param запрос $query
	* @param сообщение исключения $exception_message
	* @param имя функции $function
	* @throws PDOException
	*/
	private function getExec($exec_query, $exception_message, $function) {
		$exec = $this->pdo->exec($exec_query);
		if (! $exec) {
			throw new PDOException($exception_message."{".__CLASS__.".".$function."}");
		}
		else return $exec;
	}
	
}
?>