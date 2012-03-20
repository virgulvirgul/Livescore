<?php
require_once '../Config/config.php.inc';
/**
 * 
 * @param id_country
 * @param name имя страны
 * @param id_continent id контиента
 * @author lastride
 *
 */
class CountriesModel {
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * 
	 * Получаем все страны
	 * @throws PDOException
	 */
	public function getAllCountries() {
		$query = "SELECT id_county, name, emblem, id_continent FROM countries";
		return $this->getQuery($query, "Невозможно получить все страны", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем страну по известному ID
	 * @param ID континента $id
	 * @throws PDOException
	 */
	public function getCountryById($id) {
		$query = "SELECT id_country, name, emblem, id_continent FROM countries WHERE id_country = {$id}";
		return $this->getQuery($query, "Невозможно получить страну по ID", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем страну по известному имени
	 * @param имя страны $name
	 * @throws PDOException
	 */
	public function getCountryByName($name) {
		$query = "SELECT id_country, name, emblem, id_continent FROM countries WHERE name like '".$name."'";
		return $this->getQuery($query, "Невозможно получить страну по имени", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем все страны из заданного ID континента
	 * @param ID континента $id_continent
	 * @throws PDOException
	 */
	public function getCountriesByContinentId($id_continent) {
		$query = "SELECT id_country, name, emblem, id_continent FROM countries 
				WHERE id_continent = {$id_continent}";
		return $this->getQuery($query, "Невозможно получить страны по ID континента", __FUNCTION__);
	}
	/**
	*
	* Получаем отсортированные страны по имени из заданного ID континента
	* @param ID континента $id_continent
	* @throws PDOException
	*/
	public function getCountriesByContinentIdOrderedByName($id_continent) {
		$query = "SELECT id_country, name, emblem, id_continent FROM countries
					WHERE id_continent = {$id_continent} ORDER BY name";
		return $this->getQuery($query, "Невозможно получить отсортированные страны по ID континента", __FUNCTION__);
	}
	/**
	*
	* Получаем все страны из заданного имени континента 
	* @param ID континента $id_continent
	* @throws PDOException
	*/
	public function getCountriesByContinentName($name_continent) {
		$query = "SELECT id_country, countries.name, emblem, countries.id_continent FROM countries, continents
					WHERE countries.id_continent = continents.id_continent
					 AND continents.name like '".$name_continent."'";
		return $this->getQuery($query, "Невозможно получить страны по имени континента", __FUNCTION__);
	}
    	/**
    	* Получаем id континента по id страны
     	* @param id страны $id_country
     	*/
	public function getContinentIdByCountryId($id_country) {
	    $query = "SELECT id_continent 
	    			FROM countries
	    				WHERE id_country = {$id_country}";
       	    return $this->getQuery($query, "Невозможно получить id континента страны по ID", __FUNCTION__)->fetchColumn(0);
    	}
	/**
	 * 
	 * Получаем эмблему страны по ID
	 * @param ID страны $id
	 * @throws PDOException
	 */
	public function getCountryEmblemById($id) {
		$query = "SELECT emblem FROM countries WHERE id_country = {$id}";
		return $this->getQuery($query, "Невозможно получить эмблему страны по ID", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Получаем имя страны по ID
	 * @param ID страны $id
	 * @throws PDOException
	 */
	public function getCountryNameById($id) {
		$query = "SELECT name FROM countries WHERE id_country = {$id}";
		return $this->getQuery($query, "Невозможно получить имя страны по ID", __FUNCTION__)->fetchColumn(0);
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
}
?>
