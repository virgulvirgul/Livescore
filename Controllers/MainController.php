<?php
require_once '../Models/ContinentsModel.php';
require_once '../Models/TeamsModel.php';
require_once '../Models/PrivateMessagesInboxModel.php';

require_once '../Models/TeamPlayersModel.php';
require_once '../Models/UsersModel.php';

require_once '../Controllers/MessagesController.php';
require_once '../Controllers/ChampionshipsController.php';
require_once '../Controllers/TeamsController.php';
require_once '../Controllers/TeamPlayersController.php';

class MainController {
	private $COUNTRY_IMAGES = '../Images/countries_flags/';
	private $SITE_IMAGES = '../Images/site_images/';
	private $continentsModel;
	private $countriesModel;
	private $teamPlayersModel;
	private $usersModel;
	public function __construct() {
		$this->continentsModel = new ContinentsModel();
		$this->countriesModel = new CountriesModel();
		$this->teamPlayersModel = new TeamPlayersModel();
		$this->usersModel = new UsersModel();
	}
	/**
	 * 
	 * Получаем левое меню
	 */
	public function getLeftMenu() {
		foreach ($this->continentsModel->getAllContinents() as $row)  {
			echo "<div id='continents'>".$row['name']."</div><br>";
			echo "";
			foreach ($this->countriesModel->getCountriesByContinentIdOrderedByName($row['id_continent']) 
								as $row1)  {
				echo "<li><a href='index.php?id_country=".$row1['id_country']."'>
				<img src='".$this->COUNTRY_IMAGES.$row1['emblem']."'>&nbsp;".$row1['name']."</a></li><br>";
			}
		
		}
	}
	/**
	 * 
	 * Содержимое главной страницы
	 */
	public function getIndexContent() {
		echo "<h2>Ближайшие матчи</h2>";
	}
	/**
	 * 
	 * Выход пользователя(logout)
	 */
	public function getLogoutContent() {
 		$_SESSION['id_user'] = null;
		session_destroy();
		echo "<script>window.location = 'login.php';</script>";
	}
	/**
	 * 
	 * Проверяем какой контент показывать
	 */
	public function checkContent() {
		if (!isset($_GET['id_country']) && !isset($_GET['id_championship']) 
			&& !isset($_GET['messages']) && !isset($_GET['action']) && !isset($_GET['id_team']))
			 $this->getIndexContent();
		
		if (isset($_GET['id_country'])) new ChampionshipsController();

		//if (isset($_GET['id_championship'])) $this->getTeamsContent();
		if (isset($_GET['id_championship'])) new ChampionshipsController();
		if (isset($_GET['option']) && $_GET['option']=='teams_list') new TeamsController();
		if (isset($_GET['id_team'])) new TeamPlayersController();
		if (isset($_GET['messages'])) new MessagesController('messages');
		if (isset($_GET['action']) && $_GET['action'] == 'readMsg') new MessagesController('read');
		if (isset($_GET['action']) && $_GET['action'] == 'sendMsg') new MessagesController('send');
		
		if ($_GET['action'] == 'logout') $this->getLogoutContent();
	}
	/**
	 * 
	 * Получаем количество непрочитанных сообщений
	 */
	public function getUnreadAmount() {
		$p = new PrivateMessagesInboxModel();
		return $p->getUnreadAmount($_SESSION['id_user']);
	}
	/**
	 * 
	 * Получаем путь к эмблемам стран
	 */	
	public function getCountryImages() {
		return $this->COUNTRY_IMAGES;
	}
	/**
	 * 
	 * Получаем логин юзера по сессии ($_SESSION['id_user'])
	 */
	public function getUserLoginBySessionId() {
		 session_start(); 
		 return $this->usersModel->getUserLoginById($_SESSION['id_user']);
	}
}
?>
<html></html>