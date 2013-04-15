<?php
require_once '../Config/config.php.inc';

/**
 * id_tactic
 * tactic_name
 * tactic_image
 */

class TacticsModel {
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}

	/**
	 * Получаем все тактики
	 * @throws PDOException
	 */
	public function getAllTactics() {
		$query = "SELECT id_tactic, tactic_name, tactic_image
					FROM tactics";
		return $this->getQuery($query, "Невозможно получить все тактики ", __FUNCTION__);
	}
	/**
	 * Получаем все названия тактик
	 * @throws PDOException
	 */
	public function getAllTacticsName() {
		$query = "SELECT tactic_name
					FROM tactics";
		return $this->getQuery($query, "Невозможно получить все названия тактик ", __FUNCTION__);
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