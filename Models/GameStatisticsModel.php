<?php


require_once '../Config/config.php.inc';

/**
 *
 * id_game_statistics 
 * id_game
 * possession_owner
 * possesion_guest
 * shots_owner
 * shots_guest
 * shots_on_target_owner
 * shots_on_target_guest
 * shots_wide_owner
 * shots_wide_guest
 * corners_owner
 * corners_guest
 * offside_owner
 * offside_guest
 * saves_owner
 * saves_guest
 * fouls_owner
 * fouls_guest
 * yellow_cards_owner
 * yellow_cards_guest
 * red_cards_owner
 * red_cards_guest
 * 
 */
class GameStatisticsModel {
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
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