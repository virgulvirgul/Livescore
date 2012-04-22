<?php
/*require_once '../Models/ContinentsModel.php';
require_once '../Models/TeamsModel.php';
require_once '../Models/PrivateMessagesInboxModel.php';

require_once '../Models/TeamPlayersModel.php';
require_once '../Models/UsersModel.php';

require_once '../Controllers/MessagesController.php';
require_once '../Controllers/MessagesController.php';
require_once '../Controllers/ChampionshipsController.php';
require_once '../Controllers/TeamsController.php';*/
require_once '../Scripts/autoload.php';


class MainController {
	private $COUNTRY_IMAGES = '../Images/countries_flags/';
	private $SITE_IMAGES = '../Images/site_images/';
	private $continentsModel;
	private $countriesModel;
	private $teamPlayersModel;
	private $usersModel;
	private $gamesModel;
	private $teamsModel;
	private $championshipsModel;
	
	public function __construct() {
		$this->continentsModel = new ContinentsModel();
		$this->countriesModel = new CountriesModel();
		$this->teamPlayersModel = new TeamPlayersModel();
		$this->usersModel = new UsersModel();
		$this->gamesModel = new GamesModel();
		$this->teamsModel = new TeamsModel();
		$this->championshipsModel = new ChampionshipsModel();
		
	}
	/**
	 * 
	 * Получаем левое меню
	 */
	public function getLeftMenu() {
		foreach ($this->continentsModel->getAllContinents() as $row)  {
			echo "<div id='continents'>".$row['name']."</div><br>";
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
		echo "<h2>Ближайшие матчи</h2><br><br>";
		
		echo "<center><table style='border:0;'>";
		$i = 0;
		$dates = array();
		foreach ($this->gamesModel->getAllNearestDates() as $row) {
			$dates[] = $row['date'];
		}
		foreach ($dates as $date) {
			$allDate = $date;
			$year = substr($allDate, 0, 4);
			$month = substr($allDate, 5, 2);
			$day = substr($allDate, 8, 2);
			$hour = substr($allDate, 11, 2);
			$minute = substr($allDate, 14, 2);
			$date = date('d F, l',mktime($hour,$minute,0,$month, $day, $year));
			$hour = date('H : i',mktime($hour,$minute));
			$month_for_sql = date('n',mktime(0, 0, 0, $month));
			$day_for_sql = date('j',mktime(0, 0, 0, 0, $day));
				
			foreach ($this->gamesModel->getChampionshipIdByDate($year, $month_for_sql, $day_for_sql) as $row) {
				$championship_name = $this->championshipsModel->getChampionshipNameById($row['id_championship']);
				$country_name = $this->countriesModel->getCountryNameById($this->championshipsModel->getIdCoutryByChampionshipId($row['id_championship']));
				echo "<tr id='tr_header'><td colspan='4'><u>".$country_name."</u> - ".$championship_name."<div align='right'>".$date."</div></td></tr>";
			
			
			foreach ($this->gamesModel->getAllGamesByDateAndChampioshipId($year, $month_for_sql, $day_for_sql, $row['id_championship']) as $row) {
				$i++;
				$team_owner_name = $this->teamsModel->getTeamNameByTeamId($row['id_team_owner']);
				$team_guest_name = $this->teamsModel->getTeamNameByTeamId($row['id_team_guest']);
				$hour = substr($row['date'], 0, 2);
				$minute = substr($row['date'], 3, 2);
				$hour = date('H : i',mktime($hour,$minute));
				if ($i % 2 == 0) $backgroundColor = '#5475ED';
				else $backgroundColor = '';
				
				$team_owner_score = $this->gamesModel->getScoreOwnerByGameId($row['id_game']);
				$team_guest_score = $this->gamesModel->getScoreGuestByGameId($row['id_game']);
				
				echo "<tr>
				<td style='background-color:".$backgroundColor.";' width='25px'>";
				
				//.$hour."</td>
				echo "<td style='background-color:".$backgroundColor.";' align='right' width='100px'><div align='right'>".$team_owner_name."</div>
				<td style='background-color:".$backgroundColor.";' width='20px'>
				<div align='center'><a href='index.php?id_game=".$row['id_game']."'> ".$team_owner_score." - ".$team_guest_score." </a> </div></td>
				<td style='background-color:".$backgroundColor.";' width='100px'><div align='left'>".$team_guest_name."</div></td></td>
				</tr>";
			}
			}
				
		}
		/*foreach ($this->gamesModel->getAllNearestGames() as $number=>$row_date) {
			$allDate = $row_date['date'];
			$year = substr($allDate, 0, 4);
			$month = substr($allDate, 5, 2);
			$day = substr($allDate, 8, 2);
			$hour = substr($allDate, 11, 2);
			$minute = substr($allDate, 14, 2);
			$date = date('d F, l',mktime($hour,$minute,0,$month, $day, $year));
				
			$hour = date('H : i',mktime($hour,$minute));
				
			$month_for_sql = date('n',mktime(0, 0, 0, $month));
				
			$day_for_sql = date('j',mktime(0, 0, 0, 0, $day));
			echo $allDate."<br>";
			$championship_name = $this->championshipsModel->getChampionshipNameById($this->teamsModel->getChampionshipIdByTeamId($row_date['id_team_owner']));
			$country_name = $this->countriesModel->getCountryNameById($this->championshipsModel->getIdCoutryByChampionshipId($this->teamsModel->getChampionshipIdByTeamId($row_date['id_team_owner'])));
			
			echo "<tr id='tr_header'><td colspan='4'><u>".$country_name."</u> - ".$championship_name."<div align='right'>".$date."</div></td></tr>";
			foreach ($this->gamesModel->getAllGamesByDateAndChampioshipId($year, $month_for_sql, $day_for_sql, $this->teamsModel->getChampionshipIdByTeamId($row_date['id_team_owner'])) as $row) {
				$i++;
				$team_owner_name = $this->teamsModel->getTeamNameByTeamId($row['id_team_owner']);
				$team_guest_name = $this->teamsModel->getTeamNameByTeamId($row['id_team_guest']);
				$hour = substr($row['date'], 0, 2);
				$minute = substr($row['date'], 3, 2);
				$hour = date('H : i',mktime($hour,$minute));
				if ($i % 2 == 0) $backgroundColor = '#5475ED';
				else $backgroundColor = '';
				echo "<tr>
				<td style='background-color:".$backgroundColor.";' width='25px'>".$hour."</td>
				<td style='background-color:".$backgroundColor.";' align='right' width='100px'><div align='right'>".$team_owner_name."</div>
				<td style='background-color:".$backgroundColor.";' width='20px'><div align='center'><a href='index.php?id_game=".$row['id_game']."'> ? - ?</a> </div></td>
				<td style='background-color:".$backgroundColor.";' width='100px'><div align='left'>".$team_guest_name."</div></td></td>
				</tr>";
			}
		}*/
		echo "</table></center>";
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
			&& !isset($_GET['messages']) && !isset($_GET['action']) && !isset($_GET['id_team']) && !isset($_GET['id_game']))
			 $this->getIndexContent();
		
		if (isset($_GET['id_country']) && !isset($_GET['option'])) new ChampionshipsController();

		//if (isset($_GET['id_championship'])) $this->getTeamsContent();
		if (isset($_GET['id_championship'])) new ChampionshipsController();
		
		if (isset($_GET['id_country']) && isset($_GET['option']) && $_GET['option']=='referees_list') new RefereesController();
		
		if (isset($_GET['option']) && $_GET['option']=='teams_list') new TeamsController();
		if (isset($_GET['option']) && $_GET['option']=='add_game') new GamesController();
		if (isset($_GET['option']) && $_GET['option']=='show_games') new GamesController();
		if (isset($_GET['id_game'])) new GamesController();
		
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