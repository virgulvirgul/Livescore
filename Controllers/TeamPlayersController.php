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
							<table><tr id='tr_header'><td width='1px'>№</td><td>Имя</td><td><div id='amplua'>Амплуа<sup style='color:#D0F500;'>*</sup></div></td>
							<td>Возраст</td></tr>";
			foreach($this->teamPlayersModel->getTeamPlayersByTeamId($id_team)
			as $number=>$row) {
				echo "<tr>
				<td width='1px'>".$row['player_number']."</td>
				<td id='selected{$number}' height='40px'>
								
				<!-- Контекст меню для игроков -->
						<div style='display:none' class='contextMenu' id='playerContextMenu{$number}'>
    					 	<ul>
        						<a onclick='showModalForEditPlayer(".$row['id_player'].", {$number}); return false;'><li id='Edit'>Изменить</li></a>
        						<a onclick='showModalForMovePlayer(".$row['id_player'].", {$number}); return false;'><li id='Move'>Переместить</li></a>
        						<a onclick='deletePlayer(".$row['id_player'].", {$number}); return false;'><li id='Delete'>Удалить</li></a>
      						</ul>
      					</div>
      			<!-- Конец контекст меню для игроков -->
      			 <!-- Модальное меню для редактирования игроков -->
                                <div style='display:none' id='modalEditContent{$number}'>	
                                <form id='editPlayerForm{$number}' action=''>
                                   <h6>Новое имя </h6><br><input type='text' style='width:300px;' id='editPlayerName{$number}'><br><br><br>
                                    <h6>Новый номер </h6><br><input type='text' style='width:300px;' id='editPlayerNumber{$number}'><br><br><br>
                                    <h6>Новое амплуа </h6><br>
                                    <select style='width:300px;' id='editPlayerPosition{$number}'>
                                    <option selected disabled>Выберите амплуа...</option>
                                    <option>GK</option><option>D</option>
                                    <option>M</option><option>AM</option>
                                    <option>ST</option>
                                    </select><br><br><br>
                                 <input type='submit' class='button' onclick='editPlayer(".$row['id_player'].", {$number}); return false;' value='Изменить'>
                                    
                                </form>	
                                </div>
      			 <!-- Конец модального меню для редактирования игроков-->
      			 
                  <!-- Модальное меню для перемещения игроков -->
                                <div style='display:none' id='modalMoveContent{$number}'>
                                <form id='movePlayerForm{$number}' action=''>
                                
                                 <h6>Введите название команды </h6><input type='text' style='width:300px;' id='selectTeam{$number}'><br><br><br>
                                
                                 <h6>Выберите континент  </h6><br> <select id='selectContinent{$number}'style='width:300px;'>
                                 </select><br><br><br>
                                 <h6>Выберите страну  </h6><br> <select disabled id='selectCountry{$number}' style='width:300px;'></select><br><br><br>
                                 <h6>Выберите чемпионат  </h6><br> <select disabled id='selectChampionship{$number}' style='width:300px;'></select><br><br><br>
                                <!-- <h6>Выберите команду  </h6><br> <select disabled id='selectTeam{$number}' style='width:300px;'></select><br><br><br> -->
                                 <h6>Номер  </h6><br><input type='text' style='width:300px;' id='movePlayerNumber{$number}'><br><br><br>
                                 <h6>Амплуа  </h6><br> <select style='width:300px;' id='movePlayerPosition{$number}'>
                                    <option selected disabled>Выберите амплуа...</option>
                                    <option>GK</option><option>D</option>
                                    <option>M</option><option>AM</option>
                                    <option>ST</option>
                                    </select><br><br><br>
                               <input type='submit' class='button' onclick='movePlayer(".$row['id_player'].", {$number}); return false;' value='Переместить'>
                                 
                                </form>	
                                </div>
      			 <!-- Конец модального меню для перемещения игроков-->
      			 
				<span class='player{$number}'><a href='index.php?id_player=".$row['id_player']."''>".$this->playersModel->getPlayerNameById($row['id_player'])."</a></div>
				</span>
				</td>
									<td id='selected'>
									".$row['player_position']."
									</td>
									<td>".$this->playersModel->getPlayerAgeById($row['id_player'])." </td>
									</td></tr>";
			}
			echo "</table></center>";
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