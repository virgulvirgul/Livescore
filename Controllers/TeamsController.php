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
				echo "<center><h3>Список команд</h3>
							<table><tr id='tr_header'><td width='1px'>№</td><td>Команда</td><td>Стадион</td>";
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
                                <!-- Модальное меню для команд-->
    					</div>	
					<!-- Конец меню для команд -->
					<span class='team{$number}'><a href='index.php?id_team=".$row['id_team']."'>".$row['name']."</a></span>
									</td>";
                                
					$id_stadium = $this->stadiumsModel->getStadiumIdByTeamId($row['id_team']);
					if ($id_stadium != null) {
						$stadium_name = $this->stadiumsModel->getStadiumNameById($id_stadium);
						$stadium_image = $this->stadiumsModel->getStadiumImageByStadiumId($id_stadium);
						$stadium_capacity = $this->stadiumsModel->getStadiumCapacityById($id_stadium);
					echo "<td><div onmouseenter='getTooltipForStadiums({$id_stadium}, \"".$stadium_capacity."\", \"".$stadium_image."\");' id='stadium{$id_stadium}'>".$stadium_name."</div></td>";
					}
					else echo "<td>NONE</td>";
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