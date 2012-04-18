<?php
require_once '../Scripts/autoload.php';

class GamesController {
	private $gamesModel;
	private $teamsModel;
	private $championshipsModel;
	private $countriesModel;
	private $refereesModel;
	private $stadiumsModel;
	private $teamGamePlayersModel;
	private $playersModel;
	private $teamPlayersModel;
	
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
		$this->teamGamePlayersModel = new TeamGamePlayersModel();
		$this->playersModel = new PlayersModel();
		$this->teamPlayersModel = new TeamPlayersModel();
		
		if (isset($_GET['option']) && $_GET['option'] == 'add_game') $this->getAddGameContent();
		if (isset($_GET['option']) && $_GET['option'] == 'show_games') $this->getShowGamesContent();
		if (isset($_GET['id_game'])) $this->getOneGameContent();
		
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
				echo "<tr>
				<td style='background-color:".$backgroundColor.";' width='25px'>".$hour."</td>
				<td style='background-color:".$backgroundColor.";' align='right' width='100px'><div align='right'>".$team_owner_name."</div>
				<td style='background-color:".$backgroundColor.";' width='20px'><div align='center'><a href='index.php?id_game=".$row['id_game']."'> ? - ?</a> </div></td>
				<td style='background-color:".$backgroundColor.";' width='100px'><div align='left'>".$team_guest_name."</div></td></td>
					</tr>";
			}
		}
		echo "</table></center>";
	}
	public function getOneGameContent() {
		$id_game = $_GET['id_game'];
		$id_team_owner = $this->gamesModel->getTeamOwnerIdByGameId($id_game);
		$id_team_guest = $this->gamesModel->getTeamGuestIdByGameId($id_game);
		$team_owner_name = $this->teamsModel->getTeamNameByTeamId($id_team_owner);
		$team_guest_name = $this->teamsModel->getTeamNameByTeamId($id_team_guest);
		
		echo "<h2>".$team_owner_name." <span id='score_owner'> ? </span> - <span id='score_guest'> ? </span> ".$team_guest_name." </h2><br><br>";
		echo "<center><table>";
		
		echo "<tr id='tr_header'><td colspan='3' width='300px'>".$team_owner_name."</td><td width='300px' colspan='3'>".$team_guest_name."</td></tr>";
		echo "<tr id='tr_header'><td colspan='6'><center>Стартовый состав</center></td></tr>";
		echo "<tr id='tr_header'>
		<td>№</td><td>Имя</td><td><div id='amplua'>Амплуа<sup style='color:#D0F500;'>*</sup></div></td>
		<td>№</td><td>Имя</td><td><div id='amplua'>Амплуа<sup style='color:#D0F500;'>*</sup></div></td>
		</tr>";
		
		$team_owner_players_id_array = explode(',', $this->teamGamePlayersModel->getPlayersIdByGameAndTeamId($id_game, $id_team_owner));
		$team_guest_players_id_array = explode(',', $this->teamGamePlayersModel->getPlayersIdByGameAndTeamId($id_game, $id_team_guest));
		
		if (count($team_owner_players_id_array) >= count($team_guest_players_id_array)) {
			for ($i = 0; $i < count($team_owner_players_id_array); $i++) {
				
			
				
				$id_player = $team_owner_players_id_array[$i];
				$player_number = $this->teamPlayersModel->getTeamPlayersPlayerNumberByPlayerId($id_player);
				$player_position = $this->teamPlayersModel->getTeamPlayersPlayerPositionByPlayerId($id_player);
				$player_name = $this->playersModel->getPlayerNameById($id_player);
				
				echo "<tr><td>".$player_number."</td><td class='cont{$id_player}'>".$player_name."</td><td>".$player_position."</td>";
				
				if ($i < count($team_guest_players_id_array)) {
					$id_player_guest = $team_guest_players_id_array[$i];
					$player_guest_number = $this->teamPlayersModel->getTeamPlayersPlayerNumberByPlayerId($id_player_guest);
					$player_guest_position = $this->teamPlayersModel->getTeamPlayersPlayerPositionByPlayerId($id_player_guest);
					$player_guest_name = $this->playersModel->getPlayerNameById($id_player_guest);
				echo "<td>".$player_guest_number."</td><td class='cont'>".$player_guest_name."</td><td>".$player_guest_position."</td></tr>";
				}				
				else echo "<td></td><td></td><td></td></tr>";
					
			}
		}	
		else {
			
			for ($i = 0; $i < count($team_guest_players_id_array); $i++) {
				if ($i < count($team_owner_players_id_array)) {
					$id_player = $team_owner_players_id_array[$i];
					$player_number = $this->teamPlayersModel->getTeamPlayersPlayerNumberByPlayerId($id_player);
					$player_position = $this->teamPlayersModel->getTeamPlayersPlayerPositionByPlayerId($id_player);
					$player_name = $this->playersModel->getPlayerNameById($id_player);
					echo "<tr><td>".$player_number."</td><td class='cont'>".$player_name."</td><td>".$player_position."</td>";
				}
				else echo "<tr><td></td><td></td><td></td>";
					$id_player_guest = $team_guest_players_id_array[$i];
					$player_guest_number = $this->teamPlayersModel->getTeamPlayersPlayerNumberByPlayerId($id_player_guest);
					$player_guest_position = $this->teamPlayersModel->getTeamPlayersPlayerPositionByPlayerId($id_player_guest);
					$player_guest_name = $this->playersModel->getPlayerNameById($id_player_guest);
					echo "<td>".$player_guest_number."</td><td class='cont'>".$player_guest_name."</td><td>".$player_guest_position."</td></tr>";
			}
		}
		echo "</table></center><br>";
		
		echo "<center><form>
		<input type='button' onclick='scored_form()' class='button' style='width:200px' value='Забит гол'><br><br>
		<input type='button' onclick='yellow_card_form()' class='button' style='width:200px' value='Жёлтая карточка'><br><br>
		<input type='button' onclick='red_card_form()' class='button' style='width:200px' value='Красная карточка'><br><br>
		<input type='button' onclick='substitution_form()' class='button' style='width:200px' value='Замена'><br><br>
		<input type='button' onclick='time_out_form()' class='button' style='width:200px' value='Перерыв'><br><br>
		<input type='button' onclick='end_of_match_form()' class='button' style='width:200px' value='Конец матча'>
		
		</form></center>";
		
		$id_game = $_GET['id_game'];
		$id_team_owner = $this->gamesModel->getTeamOwnerIdByGameId($id_game);
		$id_team_guest = $this->gamesModel->getTeamGuestIdByGameId($id_game);
		$team_owner_name = $this->teamsModel->getTeamNameByTeamId($id_team_owner);
		$team_guest_name = $this->teamsModel->getTeamNameByTeamId($id_team_guest);
		
		echo "<!-- Модальное меню для забитого голв-->
                                <div style='display:none' id='scored'>	
                                <form id='scored_form' action=''>
                                  <h6>Команда</h6><br><select onchange='showTeamPlayers(team_select, team_players)' style='width:300px;' id='team_select'><option selected disabled>Выберите команду...</option>";
		echo "<option value='".$id_team_owner."'>".$team_owner_name."</option><option value='".$id_team_guest."'>".$team_guest_name."</option>";		
        echo "</select><br><br>
        <h6>Игрок</h6><br><select disabled style='width:300px;' id='team_players'></select><br><br>
        <h6>Минута</h6><br>
        <input type='text' style='width:300px;' id='scored_minute'><br><br><br>
        <input type='button' class='button' onclick='scored(team_select, team_players, scored_minute, ".$_GET['id_game'].")' value='Принять'>
                                    
                                </form>	
                                </div>
      			 <!-- Конец модального меню для забитого гола-->";
	}
}
?>