<?php
require_once '../Config/config.php.inc';
/**
 * 
 * id_referee 	
 * first_name 	
 * last_name 	
 * birth 	
 * id_country
 *
 */
class RefereesModel {
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * 
	 * Получаем id страны в которой судит судья
	 * @param unknown_type $id_referee
	 */
	public function getCountryIdByRefereeId($id_referee) {
		$query = "SELECT id_country
					FROM referees
						WHERE id_referee = {$id_referee}";
		return $this->getQuery($query, "Невозможно получить id страны по id судьи", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Получаем имя судьи по его id
	 * @param id судьи $id_referee
	 */
	public function getRefereeFirstNameById($id_referee) {
		$query = "SELECT first_name 
					FROM referees
						WHERE id_referee = {$id_referee}";
		return $this->getQuery($query, "Невозможно получить имя судьи по ID", __FUNCTION__)->fetchColumn(0);
	}
	/**
	*
	* Получаем фамилию судьи по его id
	* @param id судьи $id_referee
	*/
	public function getRefereeLastNameById($id_referee) {
		$query = "SELECT last_name
						FROM referees
							WHERE id_referee = {$id_referee}";
		return $this->getQuery($query, "Невозможно получить имя судьи по ID", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Получаем дату рождения судьи по его id
	 * @param id судьи $id_referee
	 */
	public function getRefereeBirthById($id_referee) {
		$query = "SELECT birth
					FROM referees
						WHERE id_referee = {$id_referee}";
		return $this->getQuery($query, "Невозможно получить дату рождения по id судьи", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Получаем возраст судьи по его id
	 * @param id судьи $id_referee
	 */
	public function getRefereeAgeById($id_referee) {
		$query = "SELECT (YEAR(NOW())-YEAR(birth))
							FROM referees
								WHERE id_referee = {$id_referee}";
		return $this->getQuery($query, "Невозможно получить возраст по id судьи", __FUNCTION__)->fetchColumn(0);
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