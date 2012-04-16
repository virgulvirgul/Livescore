<?php
require_once '../Scripts/autoload.php';

class GamesController {
	private $gamesModel;
	private $teamsModel;
	private $championshipsModel;
	private $countriesModel;
	private $refereesModel;
	private $stadiumsModel;
	private $COUNTRY_IMAGES = '../Images/countries_flags/';
	private $SITE_IMAGES = '../Images/site_images/';
	private $STADIUMS_IMAGES = '../Images/stadiums/';
	
	public function __construct() {
		$this->gamesModel = new GamesModel();
		$this->teamsModel = new TeamsModel();
		$this->championshipsModel = new ChampionshipsModel();
		$this->countriesModel = new CountriesModel();
		$this->refereesModel = new RefereesModel();
		$this->stadiumsModel = new StadiumsModel(); 
		
		if (isset($_GET['option']) && $_GET['option'] == 'add_game') $this->getAddGameContent();
	}
	
	public function getAddGameContent() {
		$id_championship = $_GET['id_championship'];
		echo "<h2>Добавление матча</h2><br><br>
		<center><table><tr id='tr_header'><td><center>Хозяева</center></td><td><center>Гости</center></td></tr>
		
		
		<form>
			<td><select style='width:300px;' id='team_owner'><option selected disabled>Выберите команду...</option>";
		foreach($this->teamsModel->getTeamsByChampionshipId($id_championship)
				as $row) {
			echo "<option value='".$row['id_team']."'>".$row['name']."</option>";
		}
			echo "</select></td>
			<td><select style='width:300px;' id='team_guest'><option selected disabled>Выберите команду...</option>";
		foreach($this->teamsModel->getTeamsByChampionshipId($id_championship)
				as $row) {
			echo "<option value='".$row['id_team']."'>".$row['name']."</option>";
		}	
			echo "</select></td></tr>";
			
		echo "<tr id='tr_header'><td colspan='2'><center>Стартовый состав</center></td></tr>";
		
		echo "<tr><td><select disabled multiple style='width:300px;' id='team_owner_start'>";
		echo "</select></td>";
		
		echo "<td><select disabled multiple style='width:300px;' id='team_guest_start'>";
		echo "</select></td></tr>";
		
		echo "<tr id='tr_header'><td colspan='2'><center>Номер тура</center></td></tr>";
		echo "<tr><td colspan='2'><center><select style='width:300px;' id='tour'><option selected disabled>Выберите тур...</option>";
		for ($i = 1; $i <= 40; $i ++) {
			echo "<option>".$i."</option>";
		}
		echo "<tr id='tr_header'><td colspan='2'><center>Судья</center></td></tr>";
		
		echo "<tr><td colspan='2'><center><select style='width:300px;' id='referee'><option selected disabled>Выберите судью...</option>";
		
		$id_country = $this->championshipsModel->getIdCoutryByChampionshipId($id_championship);
		foreach($this->refereesModel->getRefereesByCountryId($id_country)
				as $number=>$row) {
			echo "<option value='".$row['id_referee']."'>".$row['referee_name']."</option>";
		}
		
		echo "</select></center></td></tr>";
		echo "<tr id='tr_header'><td colspan='2'><center>Дата и время проведения</center></td></tr>";
		echo "<tr><td colspan='2'><center><input id='date' style='width:200px;' type='text'></center></td></tr>";
		
		echo "<tr id='tr_header'><td colspan='2'><center>Стадион</center></td></tr>";
		
		echo "<tr><td colspan='2'><center><div id='stadium'></div></center></td></tr>";
		
		echo "</table><br><br>
		<input class='button' onclick='addGame(team_owner, team_guest, team_owner_start, team_guest_start, tour, referee, date, stadium);' type='button' value='Добавить'>
		</form></center>";
	}
	
}

?>