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
		if (isset($_GET['option']) && $_GET['option'] == 'show_games') $this->getShowGamesContent();
		
	}
	/**
	 * Выводим форму для добавления новой игры
	 */
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
	/**
	 * Список всех игр
	 */
	public function getShowGamesContent() {
		$id_championship = $_GET['id_championship'];
		
		
		echo '<h2>Список матчей</h2><br><br>';
		echo "<center><table style='border:0;'>";
		$i = 0;
		foreach ($this->gamesModel->getAllDatesByChampionshipId($id_championship) as $number=>$row_date) {
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
			
			echo "<tr id='tr_header'><td colspan='4'>".$date."</td></tr>";
				
			foreach ($this->gamesModel->getAllGamesByDate($year, $month_for_sql, $day_for_sql) as $row) {
				$i++;
				$team_owner_name = $this->teamsModel->getTeamNameByTeamId($row['id_team_owner']);
				$team_guest_name = $this->teamsModel->getTeamNameByTeamId($row['id_team_guest']);
				$hour = substr($row['date'], 0, 2);
				$minute = substr($row['date'], 3, 2);
				$hour = date('H : i',mktime($hour,$minute));
				if ($i % 2 == 0) $backgroundColor = '#5475ED';
					else $backgroundColor = '';
				echo "<tr><td style='background-color:".$backgroundColor.";' width='25px'>".$hour."</td><td style='background-color:".$backgroundColor.";' align='right' width='100px'><div align='right'>".$team_owner_name."</div> <td style='background-color:".$backgroundColor.";' width='20px'> <div align='center'> ? - ? </div></td><td style='background-color:".$backgroundColor.";' width='100px'><div align='left'>".$team_guest_name."</div></td></td></tr>";
			}
		}
		/*foreach ($this->gamesModel->getGamesByChampionshipId($id_championship) as $row) {
			
			$allDate = $this->gamesModel->getGameDateById($row['id_game']);
			$year = substr($allDate, 0, 4);
			$month = substr($allDate, 5, 2);
			$day = substr($allDate, 8, 2);
			$hour = substr($allDate, 11, 2);
			$minute = substr($allDate, 14, 2);
			$date = date('d F, l',mktime($hour,$minute,0,$month, $day, $year));
			
			$hour = date('H : i',mktime($hour,$minute));
			
			
			$month_for_sql = date('n',mktime(0, 0, 0, $month));
			
			$day_for_sql = date('j',mktime(0, 0, 0, 0, $day));
			//echo $year . "***" . $month . "***" . $day;
			
			echo "<tr id='tr_header'><td colspan='2'>".$date."</td></tr>";
			
			//echo $allDate;
		//	foreach ($this->gamesModel->getAllGamesByDate($year, $month_for_sql, $day_for_sql) as $row1) {
				$team_owner_name = $this->teamsModel->getTeamNameByTeamId($row['id_team_owner']);
				$team_guest_name = $this->teamsModel->getTeamNameByTeamId($row['id_team_guest']);
				
				echo "<tr><td width='10%'>".$hour."</td><td><div style='text-align:center;'>".$team_owner_name." ? - ? ".$team_guest_name."</div></td></td></tr>";
			//}
		}
		*/
		echo "</table></center>";
	}
}

?>