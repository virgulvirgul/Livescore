<?php
require_once '../Config/config.php.inc';
/**
 * 
 * id_referee 	
 * referee_name 	
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
	 * Получаем список судей из данной страны
	 * @param id страны $id_country
	 */
	public function getRefereesByCountryId($id_country) {
		$query = "SELECT id_referee, referee_name, birth
					FROM referees
						WHERE id_country = {$id_country} ORDER BY referee_name";
		return $this->getQuery($query, "Невозможно получить судей по id страны", __FUNCTION__);
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
	public function getRefereeNameById($id_referee) {
		$query = "SELECT referee_name 
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
	 * Проверяем есть ли уже судья с данным именем
	 * @param имя судьи $referee_name
	 */
	public function checkDuplicateReferee($referee_name) {
		$query = "SELECT id_referee
					FROM referees 
						WHERE referee_name like '".$referee_name."'";
		if ($this->getQuery($query, "Ошибка в ", __FUNCTION__)->rowCount() > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	/**
	 * Изменяем имя судьи по его id
	 * @param id судьи $id_referee
	 * @param имя судьи $refereee_name
	 */
	public function updateRefereeById($id_referee, $referee_name) {
		$exec_query = "UPDATE referees
						SET referee_name='".$referee_name."'
							WHERE id_referee = {$id_referee}";
		return $this->getExec($exec_query, "Невозможно изменит имя судьи", __FUNCTION__);
	}
	/**
	 * Добаление судьи
	 * @param id страны $id_country
	 * @param имя судьи $referee_name
	 * @param дата рождения судьи $referee_birth
	 */
	public function addReferee($id_country, $referee_name, $referee_birth) {
		$exec_query = "INSERT INTO referees(id_referee, referee_name, birth, id_country)
						VALUES ('NULL', '".$referee_name."', '".$referee_birth."', {$id_country})";
		return $this->getExec($exec_query, "Невозможно добавить судью", __FUNCTION__);
	}
	/**
	 * Удаляем судью по его id
	 * @param id судьи $id_referee
	 */
	public function deleteRefereeById($id_referee) {
		$exec_query = "DELETE FROM referees 
							WHERE id_referee = {$id_referee}";
		return $this->getExec($exec_query, "Невозможно удалить судью", __FUNCTION__);
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