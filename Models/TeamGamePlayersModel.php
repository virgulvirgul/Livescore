<?php

require_once '../Config/config.php.inc';
// id_team_game_player;
// id_players;
// red_card;
// yellow_card;
// subsitution;
// score;
// id_game
class TeamGamePlayersModel {
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * Добавляем стартовый состав
	 * @param массив игроков $id_players
	 * @param id игры $id_game
	 */
	public function addTeamGamePlayers($id_players, $id_team, $id_game) {
		$exec_query = "INSERT INTO team_game_players(id_team_game_player, id_team, id_players, id_game)
						VALUES(NULL, {$id_team}, '".$id_players."', '".$id_game."')";
		return $this->getExec($exec_query, "Невозможно добавит стартовый состав", __FUNCTION__);
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
			else return $exec;;
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