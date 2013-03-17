<?php 
require_once '../Scripts/autoload.php';

class TeamsController {

	private $teamsModel;
	private $championshipsModel;
	private $countriesModel;
	private $stadiumsModel;
	private $COUNTRY_IMAGES = '../Images/countries_flags/';
	private $SITE_IMAGES = '../Images/site_images/';
	private $STADIUMS_IMAGES = '../Images/stadiums/';

	public function __construct() {
		$this->teamsModel = new TeamsModel();
		$this->championshipsModel = new ChampionshipsModel();
		$this->countriesModel = new CountriesModel();
		$this->stadiumsModel = new StadiumsModel();
		$this->getTeamsContent();
	}
	/**
	 *
	 * Получаем список команд по ID чемпионата($_GET['id_championship'])
	 */
	public function getTeamsContent() {
		$this->getChampionshipEmblem();
		if (isset($_GET['option']) && $_GET['option'] == 'teams_list') {
			$id_championship = $_GET['id_championship'];
			if ($this->teamsModel->getTeamsByChampionshipId($id_championship)->rowCount() < 1) {
				echo "<h4>Команд нет</h4><br>";
				$this->addTeam();
			}
			else {
				if ($this->championshipsModel->getChampionshipNameById($_GET['id_championship']) == "Champions League") {
					echo "<a id='a_champ' href='index.php?id_championship=".$_GET['id_championship']."&option=champ_preselection'>Отборочный тур</a><br>";
					echo "<a id='a_champ' href='index.php?id_championship=".$_GET['id_championship']."&option=champ_group_round'>Групповой раунд</a><br>";
					echo "<a id='a_champ' href='index.php?id_championship=".$_GET['id_championship']."&option=champ_play_off'>Плей-офф</a><br>";
					echo "<a id='a_champ' href='index.php?id_championship=".$_GET['id_championship']."&option=champ_show_archive_games'>Архив матчей</a><br>";
				}
				else {
						echo "<a id='a_champ' href='index.php?id_championship=".$_GET['id_championship']."&option=teams_list'>Список команд</a><br>";
						echo "<a id='a_champ' href='index.php?id_championship=".$_GET['id_championship']."&option=add_game'>Добавить матч</a><br>";
						echo "<a id='a_champ' href='index.php?id_championship=".$_GET['id_championship']."&option=show_games'>Список матчей</a><br>";
						echo "<a id='a_champ' href='index.php?id_championship=".$_GET['id_championship']."&option=show_archive_games'>Архив матчей</a><br><br>";
				}
				
				echo "<center><h3>Список команд</h3>
						<table><tr id='tr_header'><td width='1px'>№</td><td>Команда</td><td>Стадион</td><td width='1px'>И</td><td width='1px'>В</td><td width='1px'>П</td><td width='1px'>Н</td><td width='1px'>Рм</td><td width='1px'>О</td>";
				foreach($this->teamsModel->getTeamsByChampionshipId($id_championship)
						as $number=>$row) {
					echo "<tr><td width='1px'>".($number+1)."</td>
					<td id='selected{$number}' height='40px'>
					<!-- Контекст меню для команд-->
					<div style='display:none' class='contextMenu' id='teamContextMenu{$number}'>
					<ul>
					<a onclick='editTeam(".$row['id_team'].", {$number}); return false;'><li id='Edit'>Изменить</li></a>
					<a onclick='showModalForTeams(".$row['id_team'].", {$number}); return false;'><li id='Move'>Переместить</li></a>
					<a onclick='deleteTeam(".$row['id_team'].", {$number}); return false;'><li id='Delete'>Удалить</li></a>
					</ul>";

					echo "<!-- Модальное меню для команд-->
					<div style='display:none' id='modalContent{$number}' >

					<form name='moveTeamForm{$number}'><h6>Чемпионат</h6><br>
					<select style='width: 300px' id='selectChamps{$number}' name='selectChamps{$number}'>";
					echo "<option selected disabled>Выберите чемпионат...</option>";

					$id_country = $this->championshipsModel->getIdCoutryByChampionshipId($id_championship);
					foreach($this->championshipsModel->getChampionshipsByCountryId($id_country)
							as $number1=>$champRow) {
						echo "<option>".$champRow['name']."</option>";
					}
					echo "</select><br><br>";

					if ($this->championshipsModel-> checkCanPlayInternationalByChampionshipId($id_championship) == true) {
						echo "<h6>Международный чемпионат</h6><br>";
						echo "<select  style='width: 300px' id='selectEuropeChamps{$number}'>";
						echo "<option selected disabled>Выберите международный чемпионат...</option>";

						foreach ($this->championshipsModel->getChampionshipsByCountryName("European Cups")
								as $number2=>$europeRow) {
							echo "<option>".$europeRow['name']."</option>";
						}

						echo "</select>";
					}
					echo "<br><br><br>
							<input type='button' class='button' onclick='moveTeam(".$row['id_team'].", {$number}, ".$id_championship."); return false;' value='Переместить'>
							</form>
							</div>
							</div>
							<span class='team{$number}'><a href='index.php?id_team=".$row['id_team']."'>".$row['name']."</a></span>
									</td>";

					$id_stadium = $this->stadiumsModel->getStadiumIdByTeamId($row['id_team']);
					if ($id_stadium != null) {
						$stadium_name = $this->stadiumsModel->getStadiumNameById($id_stadium);
						$stadium_image = $this->stadiumsModel->getStadiumImageByStadiumId($id_stadium);
						$stadium_capacity = $this->stadiumsModel->getStadiumCapacityById($id_stadium);
						echo "<td><div onmouseover='getTooltipForStadiums({$id_stadium}, \"".$stadium_capacity."\", \"".$stadium_image."\");' id='stadium{$id_stadium}'>".$stadium_name."</div></td>";
					}
					else echo "<!-- Контекст меню для добавления стадиона-->
					<div style='display:none' class='contextMenu' id='addStadiumContextMenu{$number}'>
					<ul>
					<a onclick='addStadiumModal({$number}, ".$row['id_team'].")'><li id='Add'>Добавить</li></a>
					</ul>
					</div>
					<!-- Конец меню для добавления стадиона -->
					<!-- Модальное меню для стадиона-->
					<div style='display:none' id='stadiumModalContent{$number}' >
					<form  enctype='multipart/form-data' target='hiddenframe{$number}' name='addStadium{$number}'  method='POST' action='../Ajax/StadiumsAjax.php'>
					<h6>Название стадиона</h6><br>
					<input type='text' name='stadiumName{$number}' id='stadiumName{$number}' style='width:300px;'><br><br><br>
					<h6>Вместительность</h6><br>
					<input type='text' name='stadiumCapacity{$number}' 'id='stadiumCapacity{$number}' style='width:300px;'><br><br><br>
					<h6>Загрузите изображение</h6><br>
					<input align='middle' type='file' name='stadiumImage{$number}' id='stadiumImage{$number}' size='25px' ><br><br><br>
					<input type='submit' class='button' onclick='addStadium({$number}, ".$row['id_team'].", stadiumName{$number}, stadiumCapacity{$number}, stadiumImage{$number});' value='Добавить'>
					<input type='hidden' name='hid' value='".$this->teamsModel->getTeamsByChampionshipId($id_championship)->rowCount()."'>
							<input type='hidden' name='id_team' value=".$row['id_team'].">
							<iframe id='hiddenframe{$number}' name='hiddenframe{$number}' style='width:0px; height:0px; border:0px'></iframe>
							</form>
							</div>
							<!-- Модальное меню для стадиона-->
							<td><span class='addStadium{$number}'>NONE</span></td>";
					echo "<td>".$this->teamsModel->getGamesByIdTeam($row['id_team'])."</td>
							<td>".$this->teamsModel->getWinByIdTeam($row['id_team'])."</td>
									<td>".$this->teamsModel->getLoseByIdTeam($row['id_team'])."</td>
											<td>".$this->teamsModel->getDrawByIdTeam($row['id_team'])."</td>
													<td>".$this->teamsModel->getGoalDiffByIdTeam($row['id_team'])."</td>
															<td>".$this->teamsModel->getPointsByIdTeam($row['id_team'])."</td>";
					echo "</tr>";
				}
				echo "</table></center>";

				$this->addTeam();
			}
		}
	}

	/**
	 *
	 * Получаем картинку страны и текущего чемпионата
	 */
	public function getChampionshipEmblem() {
		$id_country = $this->championshipsModel->getIdCoutryByChampionshipId($_GET['id_championship']);
		echo "<h2><img align='middle' id='flag' src='".$this->COUNTRY_IMAGES."
				".$this->countriesModel->getCountryEmblemById($id_country)."'>&nbsp;
						<a href='index.php?id_country=".$id_country."' class='hrefEmblem'>".$this->countriesModel->getCountryNameById($id_country)."</a>
								-> <a href='index.php?id_championship=".$_GET['id_championship']."' class='hrefEmblem'>".$this->championshipsModel->getChampionshipNameById($_GET['id_championship'])."</a></h2><br>";
	}
	/**
	 *
	 * Добавление команды
	 */
	public function addTeam() {
		echo "<center><h3>Добавить команду</h3>
		<form class='form' id='newTeamForm' action='' onsubmit='addTeam({$_GET['id_championship']}, newTeamName, newTeamForm); return false;'>
		<input id='newTeamName' type='text'>&nbsp&nbsp&nbsp
		<input class='button' onclick='addTeam({$_GET['id_championship']}, newTeamName, newTeamForm);' type='button' value='Добавить'>
		</form></center>";
		 
	}
}



?>