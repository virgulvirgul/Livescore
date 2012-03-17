<?php
require_once '../Config/config.php.inc' ;
class UsersModel {
	private $pdo;
	public function __construct() {
		$this->pdo = Config::getInstance()->getPDO();
	}
	/**
	 * 
	 * Получаем всех юзеров
	 */
	public function getAllUsers() {
		$query = "SELECT login, password, superadmin FROM users";
		return $this->getQuery($query, "Невозможно получить всех юзеров ", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем логин юзера по ID
	 * @param id юзера $id
	 */
	public function getUserLoginById($id) {
		$query = "SELECT login FROM users WHERE id_user = {$id}";
		return $this->getQuery($query, "Невозможно получить логин юзера по ID", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Получаем все поля по ID
	 * @param id юзера $id
	 */	
	public function getUserById($id) {
		$query = "SELECT login, password, superadmin FROM users WHERE id_user = {$id}";
		return $this->getQuery($query, "Невозможно получить все поля юзера по ID", __FUNCTION__);
	}
	/**
	 * 
	 * Получаем id юзера по логину
	 * @param Логин $login
	 */
	public function getUsersIdByLogin($login) {
		$query = "SELECT id_user FROM users WHERE login like '".$login."'";
		return $this->getQuery($query, "Невозможно получить ID юзера по логину ", __FUNCTION__)->fetchColumn(0);
	}
	/**
	 * 
	 * Получаем все поля по логину
	 * @param логин $login
	 */
	public function getUserByLogin($login) {
		$query = "SELECT login, password, superadmin FROM users WHERE login like '".$login."'";
		return $this->getQuery($query, "Невозможно получить все поля юзера по логину ", __FUNCTION__);
	}
	/**
	 * 
	 * Проверяем есть ли юзер с заданным ID
	 * @param ID юзера $user_id
	 * @return boolean
	 */
	public function checkUserExistsByUserId($user_id) {
		$query = "SELECT id_user FROM users WHERE id_user = {$user_id}";
		if ($this->pdo->query($query)->rowCount() > 0) return true;
			else return false;
	}
	/**
	*
	* Проверяем есть ли юзер с заданным логином
	* @param ID юзера $user_id
	* @return boolean
	*/
	public function checkUserExistsByUserLogin($login) {
		$query = "SELECT id_user FROM users WHERE login like '".$login."'";
		if ($this->pdo->query($query)->rowCount() > 0) return true;
		else return false;
	}
	/*
	* Хэширование пароля
	*/
	public function hashPassword($password) {
		return md5(md5($password));
	}
	/*
	 * Проверка правильного ввода логина и пароля
	 */
	public function checkUserPassword($login, $password) {
		$hashPassword = $this->hashPassword($password);
		$query = "SELECT login, password, superadmin FROM users WHERE login like '".$login."' 
			AND password like '".$hashPassword."'";
		$check = $this->pdo->query($query);
		if ($check->rowCount() > 0) return true;
			else return false;
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