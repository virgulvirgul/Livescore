<?php
require_once '../Models/TeamsModel.php';
require_once '../Models/ChampionshipsModel.php';
require_once '../Models/CountriesModel.php';
require_once '../Models/ContinentsModel.php';
require_once '../Models/TeamPlayersModel.php';
require_once '../Models/PlayersModel.php';

class TeamPlayersController {
	
	private $teamPlayersModel;
	private $playersModel;
	private $teamsModel;
	private $championshipsModel;
	private $countriesModel;
	private $COUNTRY_IMAGES = '../Images/countries_flags/';
	private $SITE_IMAGES = '../Images/site_images/';

public function __construct() {
	$this->teamsModel = new TeamsModel();
	$this->championshipsModel = new ChampionshipsModel();
	$this->countriesModel = new CountriesModel();
	$this->teamPlayersModel = new TeamPlayersModel();
	$this->playersModel = new PlayersModel();
	
	$this->getTeamPlayersContent();
}
/**
 *
 * Получаем список игроков по ID команды($_GET['id_championship'])
 */
public function getTeamPlayersContent() {
	$this->getFullEmblem();
	if (isset($_GET['id_team'])) {
		$id_team = $_GET['id_team'];
		if ($this->teamPlayersModel->getTeamPlayersByTeamId($id_team)->rowCount() < 1) {
			echo "<h4>Игроков нет</h4><br>";
			//$this->addTeam();
		}
		else {
			echo "<center><h3>Список игроков</h3>
							<table><tr id='tr_header'><td width='1px'>№</td><td>Фамилия</td><td>Имя</td><td>Амплуа<sup style='color:#D0F500;'>*</sup></td>
							<td>Возраст</td></tr>";
			foreach($this->teamPlayersModel->getTeamPlayersByTeamId($id_team)
			as $number=>$row) {
				echo "<tr><td width='1px'><a href='index.php?id_player=".$row['id_player']."'>".$row['player_number']."</a></td>
									<td id='selected' height='40px'>
										<div id='div".($number+1)."' style='display:{$display}'>
										<a href='index.php?id_player=".$row['id_player']."''>".$this->playersModel->getPlayerLastNameById($row['id_player'])."</a></div>
									</td>
									<td id='selected'>
									<a href='index.php?id_player=".$row['id_player']."''>".$this->playersModel->getPlayerFirstNameById($row['id_player'])."</a>
									</td>
									<td id='selected'>
									".$row['player_position']."
									</td>
									<td>".$this->playersModel->getPlayerAgeById($row['id_player'])." </td>
									</td></tr>";
			}
			echo "</table></center>";
			echo "<h5>* GK - GoalKeeper (Вратарь)<br>&nbsp;&nbsp;&nbsp;D - Defender (Защитник)
					<br>&nbsp;&nbsp;&nbsp;M - Midfielder (Полузащитник)
					<br>&nbsp;&nbsp;&nbsp;AM - AttaсkingMidfielder (Атакующий полузащитник)
					<br>&nbsp;&nbsp;&nbsp;ST - Striker (Нападающий)</h5>";
			//$this->addTeam();
		}
	}
}
/**
*
* Получаем картинку страны, название текущего чемпионата и команды
*/
public function getFullEmblem() {
	$id_team = $_GET['id_team'];
	$id_championship = $this->teamsModel->getChampionshipIdByTeamId($id_team);
	$id_country = $this->championshipsModel->getIdCoutryByChampionshipId($id_championship);
	
	echo "<h2><img align='middle' id='flag' src='".$this->COUNTRY_IMAGES."
			".$this->countriesModel->getCountryEmblemById($id_country)."'>&nbsp;
			".$this->countriesModel->getCountryNameById($id_country)." -> 
			".$this->championshipsModel->getChampionshipNameById($id_championship)." -> 
			".$this->teamsModel->getTeamNameByTeamId($id_team)."</h2><br>";
	}
}

?>