<?php
require_once '../Models/ChampionshipsModel.php';
require_once '../Models/CountriesModel.php';

class ChampionshipsController {
	/**
	*
	* Получаем чемпионаты по ID страны ($_GET['id_country'])
	*/
	private $championshipsModel;
	private $countriesModel;
	
	private $COUNTRY_IMAGES = '../Images/countries_flags/';
	private $SITE_IMAGES = '../Images/site_images/';
	public function __construct() {
		$this->championshipsModel = new ChampionshipsModel();
		$this->countriesModel = new CountriesModel();
		if (isset($_GET['id_country'])) $this->getChampionshipsContent();
			else if (isset($_GET['id_championship'])) $this->getOneChampionshipContent();
	}
	/**
	 * 
	 * Получаем список чемпионатов данной страны ($_GET['id_country'])
	 */
	public function getChampionshipsContent() {
		$id_country = $_GET['id_country'];
		if (isset($id_country)) {
			echo "<h2><img align='middle' id='flag' src='".$this->COUNTRY_IMAGES."
								".$this->countriesModel->getCountryEmblemById($id_country)."'>&nbsp;".$this->countriesModel->getCountryNameById($id_country)."</h2><br>";
			echo "<a id='a_champ' href='index.php?id_country=".$_GET['id_country']."&option=referees_list'>Список судей</a><br><br>";
			if ($this->championshipsModel->getChampionshipsByCountryId($id_country)->rowCount() < 1) {
				echo "<h4>Чемпионатов нет</h4><br>";
				$this->addChampionship();
			}
			else {
				echo "<center><h3>Список чемпионатов</h3>
					<table><tr id='tr_header'><td width='1px'>№</td><td>Чемпионат</td>";
				foreach($this->championshipsModel->getChampionshipsByCountryId($id_country)
				as $number=>$row) {
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
					echo "<tr id='tr_number{$number}'>
					<td width='1px'><a id='aNumber{$number}'>".($number+1)."</a></td>
					<td id='selected{$number}' height='40px'>
					<!-- Контекст меню для чемпионатов-->
						<div style='display:none' class='contextMenu' id='champContextMenu{$number}'>
    					 	<ul>
        						<a onclick='editChamp(".$row['id_championship'].", {$number}); return false;'><li id='Edit'>Изменить</li></a>
        						<a onclick='deleteChamp(".$row['id_championship'].", {$number});'><li id='Delete'>Удалить</li></a>
      						</ul>
    					</div>	
					<!-- Конец меню для чемпионатов -->
							<span class='championship{$number}'><a href='index.php?id_championship=".$row['id_championship']."''>".$row['name']."</a></span>
							</td>";
					
				}
				echo "</table></center>";
				$this->addChampionship();
			}
		}
	}
	/**
	 * 
	 *  Получаем список доступных действий для выбранного чемпионата
	 */
	public function getOneChampionshipContent() {
		if (isset($_GET['id_championship']) && !isset($_GET['option'])) {
			$this->getChampionshipEmblem();
			echo "<a id='a_champ' href='index.php?id_championship=".$_GET['id_championship']."&option=closest_matches'>Ближайшие матчи</a><br>";
			echo "<a id='a_champ' href='index.php?id_championship=".$_GET['id_championship']."&option=teams_list'>Список команд</a><br>";
			echo "<a id='a_champ' href='index.php?id_championship=".$_GET['id_championship']."&option=stadiums_list'>Список стадионов</a><br>";
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
	* Добавление чемпионата
	*/
	public function addChampionship() {
		echo "<center><h3>Добавить чемпионат</h3>
				<form class='form' id='newChampForm' action='' onsubmit='addChamp({$_GET['id_country']}, newChampName, newChampForm); return false;'>
				<input id='newChampName' type='text'>&nbsp&nbsp&nbsp
				<input class='button' onclick='addChamp({$_GET['id_country']}, newChampName, newChampForm);' type='button' value='Добавить'>
				</form></center>";
	}
}

?>
