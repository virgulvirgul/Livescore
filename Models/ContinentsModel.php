<?php
require_once '../Config/config.php.inc';
class ContinentsModel{
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * 
	 * Получаем все континенты
	 * @throws PDOException
	 */
	public function getAllContinents() {
		$query = "SELECT id_continent, name FROM continents";
		return $this->getQuery($query, "Невозможно получить все континенты ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем континент по известному ID
	 * @param ID континента $id
	 * @throws PDOException
	 */
	public function getContinentById($id) {
		$query = "SELECT name, id_continent FROM continents WHERE id_continent = {$id}";
		return $this->getQuery($query, "Невозможно получить континент по ID ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем континент по известному имени
	 * @param имя континента $name
	 * @throws PDOException
	 */
	public function getContinentByName($name) {
		$query = "SELECT name, id_continent FROM continents WHERE name like '".$name."'";
		return $this->getQuery($query, "Невозможно получить континент по имени ", __FUNCTION__);
	}
    /**
     * Получаем имя континента по его id
     * @param id континента $id_continent
     */
	public function getContinentNameByContinentId($id_continent) {
        $query = "SELECT name FROM continents WHERE id_continent = {$id_continent}";
        return $this->getQuery($query, "Невозможно получить имя континента по id", __FUNCTION__)->fetchColumn(0);
    }
	/**
	 * 
	 * Получаем имена всех континентов
	 */
	public function getAllContinentsName() {
		$query = "SELECT name FROM continents";
		return $this->getQuery($query, "Невозможно получить все континенты ", __FUNCTION__);
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