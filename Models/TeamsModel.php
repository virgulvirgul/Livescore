<?php
require_once '../Config/config.php.inc';

class TeamsModel {
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * 
	 * Получаем все команды
	 * @throws PDOException
	 */
	public function getAllTeams() {
		$query = "SELECT name, id_team, id_championship FROM teams";
		return $this->getQuery($query, "Невозможно получить все команды ", __FUNCTION__);
	}
	/**
	 * Получаем названия всех команд
	 */
	public function getTeamsNames() {
		$query = "SELECT name FROM teams";
 		return $this->getQuery($query, "Невозможно получить названия всеx команды ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем команду по ID
	 * @param id команды $id
	 * @throws PDOException
	 */
	public function getTeamById($id) {
		$query = "SELECT name, id_team, id_championship FROM teams WHERE id = {$id}";
		return $this->getQuery($query, "Невозможно получить команду по ID ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем команду по имени
	 * @param имя команды $name
	 * @throws PDOException
	 */
	public function getTeamByName($name) {
		$query = "SELECT name, id_team, id_championship FROM teams WHERE name like '".$name."'";
		return $this->getQuery($query, "Невозможно получить команду по имени ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем команды по ID чемпионата сортируя по алфавиту
	 * @param ID чемпионата $id
	 * @throws PDOException
	 */
	public function getTeamsByChampionshipId($id_championship) {
		$query = "SELECT name, id_team, id_championship 
					FROM teams 
						WHERE id_championship like '{$id_championship}' ORDER BY id_team";
		return $this->getQuery($query, "Невозможно получить команды по id чемпионата ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем имя команды по ID
	 * @param ID команды $id_team
	 */
	public function getTeamNameByTeamId($id_team) {
		$query = "SELECT name
							FROM teams 
								WHERE id_team = {$id_team}";
		return $this->getQuery($query, "Невозможно получить имя команды по id", __FUNCTION__)->fetchColumn(0);
	}
    /**
     * 
     * Получаем id команды по имени
     * @param имя команды $name
     */
    public function getTeamIdByName($name) {
        $query = "SELECT id_team
                            FROM teams 
                                WHERE name like '".$name."'";
        return $this->getQuery($query, "Невозможно получить id команды по имени", __FUNCTION__)->fetchColumn(0);
    }
	/**
	 * 
	 * Получаем в каком чемпионате играет данная команда по ID команды
	 * @param ID команды $id_team
	 */
	public function getChampionshipIdByTeamId($id_team) {
		$query = "SELECT id_championship
							FROM teams 
								WHERE id_team = {$id_team}";
		return $this->getQuery($query, "Невозможно получить id чемпионата по id команды", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Добавляем команду
	 * @param имя новой команды $name
	 * @param ID чемпионата в который добавляем команду $id_championship
	 */
	public function addTeam($name, $id_championship) {
		$exec_query = "INSERT INTO teams(id_team, name, id_championship)
								VALUES ('NULL', '{$name}', {$id_championship})";
		return $this->getExec($exec_query, "Невозможно добавить команду", __FUNCTION__);
	}
	/**
	 * Проверяем есть ли уже команды с таким же именем
	 * @param имя команды $name
	 */
	public function checkDuplicateTeam($name) {
		$query = "SELECT id_team FROM teams WHERE name like '".$name."'";
		if ($this->getQuery($query, "Ошибка в ", __FUNCTION__)->rowCount() > 0) {
			return true;
		}
			else {
				return false;
			}
	}
    /**
     * Обновляем название команды
     * @param ID команды $id_team
     * @param новое имя команды $name
     */
	public function updateTeamName($id_team, $name) {
		$exec_query = "UPDATE teams  
                        SET name='".$name."' 
                            WHERE id_team = {$id_team}";
        return $this->getExec($exec_query, "Невозможно обновить имя команды", __FUNCTION__);
	}
    /**
     * Удаление команды
     * @param ID команды $id_team
     */
    public function deleteTeamById($id_team) {
        $exec_query = "DELETE FROM teams WHERE id_team = {$id_team}";
        return $this->getExec($exec_query, "Невозможно удалить команду", __FUNCTION__);
    }	
    /**
     * Если команда учавствует в нескольких чемпионатах, добавляем id чемпионата
     * @param id команды $id_team
     * @param id чемпионата $id_championship
     * 
     */
    public function addChampionshipIdByTeamId($id_team, $id_championship) {
        $exec_query = "UPDATE teams  
                        SET id_championship = CONCAT(id_championship, ';".$id_championship."')
                            WHERE id_team = {$id_team}";
        return $this->getExec($exec_query, "Невозможно добавить чемпионат команде", __FUNCTION__);
    }
    /**
     * Перемещение команды в другой чемпионат
     * @param id команды $id_team
     * @param id нового чемпионата $id_championship
     */   
    public function moveTeamToAnotherChampionship($id_team, $id_championship) {
        $exec_query = "UPDATE teams  
                        SET id_championship = {$id_championship} 
                            WHERE id_team = {$id_team}";
        return $this->getExec($exec_query, "Невозможно переместит команду в другой чемпионат", __FUNCTION__);
    }
    
    /**
     * Перемещение команды в другой международный чемпионат чемпионат
     * @param id команды $id_team
     * @param id прошлого чемпионата $id_championship_old
     * @param id нового чемпионата $id_championship_new
     */   
    public function moveTeamToAnotherInternationalChampionship($id_team, $id_championship_old,
                                                            $id_championship_new) {
        $exec_query = "UPDATE teams  
                        SET id_championship = REPLACE(id_championship, '".$id_championship_old."',
                            '".$id_championship_new."') 
                            WHERE id_team = {$id_team}";
        return $this->getExec($exec_query, "Невозможно переместить команду в другой международный чемпионат чемпионат", __FUNCTION__);
    }
    /**
     * Удаление всех команд по ID чемпионата
     * @param ID чемпионатаs $id_championship
     */
    public function deleteTeamsByChampionshipId($id_championship) {
        $exec_query = "DELETE FROM teams WHERE id_championship = {$id_championship}";
        return $this->getExec($exec_query, "Невозможно удалить все команды по ID чемпионата", __FUNCTION__);
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