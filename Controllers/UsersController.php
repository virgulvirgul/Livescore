<?php
require_once '../Models/UsersModel.php';
class UsersController {
	private $usersModel;
	/**
	 * 
	 * Сообщение об ошибке
	 * 
	 */
	private $msg;
	/**
	 * 
	 * Скрываем форму при плавильном вводе
	 *
	 */
	private $hidden;
	public function __construct() {
		$this->usersModel = new UsersModel();
	}
	/**
	 * 
	 * Проверка пароля и логина
	 */
	public function checkUserPassword() {
		$this->checkUserSession();
		$this->hidden = "inline";
		if ($this->usersModel->checkUserPassword($_POST['login'], $_POST['password']) == true
		&& isset($_POST['login']) && isset($_POST['password'])) {
			session_start();
			$_SESSION['id_user'] = $this->usersModel->getUsersIdByLogin($_POST['login']);
			echo "<p class='center_text'>Добро пожаловать
				 		<span style='font-style:italic;color:#B0C4DE;'>{$_POST['login']}</span>.<br>
				 		Вы будете перенаправлены на целевую страницу через 3 секунды<br>
				 		Если этого не произошло перейдите по <a href='index.php'>ссылке</a></p>";
			unset($login);
			unset($password);
			$this->hidden = "none";
		    header('Refresh: 3; URL=index.php');
		}
		else if (isset($_POST['login']) || isset($_POST['password'])) $this->msg = "Вы ввели неверный логин либо пароль";
	}
	/**
	 * 
	 * Проверяем или залогинен пользователь
	 */
	private function checkUserSession() {
		session_start();
		if (isset($_SESSION) && $_SESSION['id_user'] != "") {
			header('Location: index.php');
		}
	}
	public function getHidden() {
		return $this->hidden;
	}
	public function getMsg() {
		return $this->msg;
	}
}
?>