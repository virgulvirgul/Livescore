<?php
require_once '../Config/config.php.inc';

/**
 * 
 * id_championship
 * name
 * id_country
 */
class ChampionshipsModel {
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * 
	 * Получаем все чемпионаты
	 * @throws PDOException
	 */
	public function getAllChampionships() {
		$query = "SELECT name, id_championship, id_country FROM championships";
		return $this->getQuery($query, "Невозможно получить все чемпионаты ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем чемпионат по ID
	 * @param ID чемпионата $id
	 * @throws PDOException
	 */
	public function getChampionshipById($id) {
		$query = "SELECT name, id_championship, id_country FROM championships 
			WHERE id_championship = {$id}";
		return $this->getQuery($query, "Невозможно получить чемпионат по ID ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем чемпионат по имени
	 * @param unknown_type $name
	 * @throws PDOException
	 */
	public function getChampionshipByName($name) {
		$query = "SELECT name, id_championship, id_country FROM championships
				WHERE name like '".$name."'";
		return $this->getQuery($query, "Невозможно получить чемпионат по имени ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем ID страны в которой находится чемпионат по ID чемпионата
	 * @param ID чемпионата $id_championship
	 */
	public function getIdCoutryByChampionshipId($id_championship) {
		$query = "SELECT id_country FROM championships
						WHERE id_championship = {$id_championship}";
		return $this->getQuery($query, "Невозможно получить ID страны по ID чемпионата ", __FUNCTION__)->fetchColumn(0);
	} 
	/**
	 * 
	 * Получаем чемпионаты по ID страны
	 * @param ID страны $id
	 * @throws PDOException
	 */
	public function getChampionshipsByCountryId($id) {
		$query = "SELECT name, id_championship, id_country FROM championships
				WHERE id_country = {$id} ORDER by id_championship";
		return $this->getQuery($query, "Невозможно получить чемпионаты по ID страны ", __FUNCTION__);
	}
    /**
     * 
     * Получаем чемпионаты по имени страны
     * @param имя страны $name
     * @throws PDOException
     */
    public function getChampionshipsByCountryName($name) {
        $query = "SELECT championships.name, championships.id_championship, championships.id_country 
                    FROM championships, countries
                        WHERE championships.id_country = countries.id_country 
                            AND countries.name like '".$name."' ORDER by championships.id_championship";
        return $this->getQuery($query, "Невозможно получить чемпионаты по имени страны ", __FUNCTION__);
    }
	/**
	 * 
	 * Получаем имя чемпионата по ID
	 * @param ID чемпионата $id
	 * @throws PDOException
	 */
	public function getChampionshipNameById($id) {
		$query = "SELECT name FROM championships
				WHERE id_championship = {$id}";
		return $this->getQuery($query, "Невозможно получить чемпионат по ID ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	*
	* Получаем id чемпионата по имени
	* @param имя чемпионата $name
	* @throws PDOException
	*/
	public function getChampionshipIdByName($name) {
		$query = "SELECT id_championship FROM championships
					WHERE name like '%".$name."%'";
		return $this->getQuery($query, "Невозможно получить ID чемпионата по имени ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Добавление нового чемпионата
	 * @param имя чемпионата $name
	 * @param ID страны в которой находится чемпионат $id_country
	 */
	public function addChampionship($name, $id_country) {
		$exec_query = "INSERT INTO championships(id_championship, name, id_country)
					VALUES ('NULL', '{$name}', {$id_country})";
		return $this->getExec($exec_query, "Невозможно добавить чемпионат", __FUNCTION__);
	}
	/**
	*
	* Проверяем есть ли уже чемпионат с заданным именм
	* @param имя чемпионата $name
	*/
	public function checkDuplicateChampionship($name) {
		$query = "SELECT id_championship FROM championships WHERE name like '".$name."'";
		if ($this->getQuery($query, "Ошибка в ", __FUNCTION__)->rowCount() > 0) {
			return true;
		}
			else {
				return false;
			}
	}
	/**
     * Проверяем может ли чемпионат учавствовать в международных турнирах
     * @param id чемпионата $id_championship
     */
    public function checkCanPlayInternationalByChampionshipId($id_championship) {
        $query = "SELECT canPlayInternational FROM championships WHERE id_championship = {$id_championship}";
        if ($this->getQuery($query, "Ошибка в ", __FUNCTION__)->fetchColumn(0) == 1) {
            return true;
        }
            else {
                return false;
            }
    }
	
	/**
	 * 
	 * Обновление чемпионата
	 * @param ID чемпионата $id_championship
	 * @param новое имя чемпионата $name
	 */
	public function updateChampionship($id_championship, $name) {
		$exec_query = "UPDATE championships	
						SET name='".$name."' 
							WHERE id_championship = {$id_championship}";
		return $this->getExec($exec_query, "Невозможно обновить чемпионат", __FUNCTION__);
	}
	/**
	 * 
	 * Удаление чемпионата
	 * @param ID чемпионата $id_championship
	 */
	public function deleteChampionshipById($id_championship) {
		$exec_query = "DELETE FROM championships WHERE id_championship = {$id_championship}";
		return $this->getExec($exec_query, "Невозможно удалить чемпионат", __FUNCTION__);
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