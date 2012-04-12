<?php
/**
 * 
 * id_stadium		 	 	 	 	 
 * name	 	 	 	 	 	 
 * description	 	 	 	 
 * id_team
 *
 */
class StadiumsModel {
	
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * 
	 * Получаем имя стадиона по его id
	 * @param id стадиона $id_stadium
	 */
	public function getStadiumNameById($id_stadium) {
		$query = "SELECT name
					FROM stadiums
						WHERE id_stadium = {$id_stadium}";
		return $this->getQuery($query, "Невозможно получить имя стадиона по его id", __FUNCTION__)->fetchColumn(0);
	}
	/**
	*
	* Получаем вместительность стадиона по его id
	* @param id стадиона $id_stadium
	*/
	public function getStadiumCapacityById($id_stadium) {
		$query = "SELECT capacity
						FROM stadiums
							WHERE id_stadium = {$id_stadium}";
		return $this->getQuery($query, "Невозможно получить описание стадиона по его id", __FUNCTION__)->fetchColumn(0);
	}
	/**
	*
	* Получаем команду к которой привязан стадион по id стадиона
	* @param id стадиона $id_stadium
	*/
	public function getTeamIdByStadiumId($id_stadium) {
		$query = "SELECT id_team
							FROM stadiums
								WHERE id_stadium = {$id_stadium}";
		return $this->getQuery($query, "Невозможно получить id команды по id стадиона", __FUNCTION__)->fetchColumn(0);
	}
	
	/**
	 * 
	 * Добавляем стадион
	 * @param имя стадиона $name
	 * @param описание $description
	 * @param id команды которой принадлежит стадион $id_team
	 */
	public function addStadium($name, $capacity, $image, $id_team) {
		$exec_query = "INSERT INTO stadiums(id_stadium, name, description, id_team)
						VALUES (NULL. ".$name.", '".$capacity."' , '".$image."', {$id_team})";
		return $this->getExec($exec_query, "Невозможно создать стадион", __FUNCTION__);
		
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