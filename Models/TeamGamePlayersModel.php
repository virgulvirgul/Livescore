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
	 * Получаем стартовый состав по id игры и id команды
	 * @param id игры $id_game
	 * @param id команды $id_team
	 */
	public function getPlayersIdByGameAndTeamId($id_game, $id_team) {
		$query = "SELECT id_players FROM team_game_players
					WHERE id_game = {$id_game} AND id_team = {$id_team}";
		return $this->getQuery($query, "Невозможно получить стартовый состав по id игры и id команды", __FUNCTION__)->fetchColumn(0);
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
	 * При голе пишим кто забил ($id_player) и на какой минуте($minute)
	 * @param id игры $id_game
	 * @param id игрока $id_player
	 * @param минута $minute
	 */
	public function updateScoreByGameId($id_game, $id_team, $id_player, $minute) {
		$exec_query = "UPDATE team_game_players
						SET score = CONCAT(score, '".$id_player.", ".$minute.",') 
							WHERE id_game = {$id_game} AND id_team = {$id_team}";
		return $this->getExec($exec_query, "Невозможно записать гол", __FUNCTION__);
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