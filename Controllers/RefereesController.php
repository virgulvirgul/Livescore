<?php
require_once '../Scripts/autoload.php';
// Вывести в гетконтент даты рождения
// Сделать удаление перемещение изменение и добавление
class RefereesController {
	private $refereesModel;
	private $countriesModel;
	
	private $COUNTRY_IMAGES = '../Images/countries_flags/';
	private $SITE_IMAGES = '../Images/site_images/';
	
	public function __construct() {
		$this->refereesModel = new RefereesModel();
		$this->countriesModel = new CountriesModel();
		if (isset($_GET['id_country']) && $_GET['option'] == 'referees_list') {
			$this->getRefereesContent();
		}
	}
	
	public function getRefereesContent() {
		$id_country = $_GET['id_country'];
			echo "<h2><img align='middle' id='flag' src='".$this->COUNTRY_IMAGES."
			".$this->countriesModel->getCountryEmblemById($id_country)."'>&nbsp;
			<a href='index.php?id_country=".$id_country."' class='hrefEmblem'>".$this->countriesModel->getCountryNameById($id_country)."</a></h2><br>";
			
			if ($this->refereesModel->getRefereesByCountryId($id_country)->rowCount() < 1) {
				echo "<h4>Судей нет</h4><br>";
			}
			else {
				echo "<center><h3>Список судей</h3>
				<table><tr id='tr_header'><td width='1px'>№</td><td>Имя</td><td>Возраст</td>";
				foreach($this->refereesModel->getRefereesByCountryId($id_country)
						as $number=>$row) {
					//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
					echo "<tr id='tr_number{$number}'>
					<td width='1px'><a id='aNumber{$number}'>".($number+1)."</a></td>
					<td id='selected{$number}' height='40px'>
					<!-- Контекст меню для судей-->
					<div style='display:none' class='contextMenu' id='refereesContextMenu{$number}'>
					<ul>
					<a onclick='editReferee(".$row['id_referee'].", {$number}); return false;'><li id='Edit'>Изменить</li></a>
					<a onclick='deleteReferee(".$row['id_referee'].", {$number});'><li id='Delete'>Удалить</li></a>
					</ul>
					</div>
					<!-- Конец меню для судей -->
					<span class='referee{$number}'><a style='cursor:pointer'>".$row['referee_name']."</a></span>
					</td><td>".$this->refereesModel->getRefereeAgeById($row['id_referee'])."</td>";
						
				}
				echo "</table></center>";
		}
		$this->addReferee();
		
	}
	/**
	 *
	 * Добавление чемпионата	
	 */
	public function addReferee() {
		echo "<center><h3>Добавить судью</h3>
		<form class='form' id='newRefereeForm' action='' onsubmit='addReferee({$_GET['id_country']}, newRefereeName, newRefereeBirth, newRefereeForm); return false;'>
		Имя<br><input id='newRefereeName' style='width:200px;' type='text'><br><br>
		Дата рождения<br><input id='newRefereeBirth' style='width:200px;' type='text'><br><br>
		
		<input class='button' onclick='addReferee({$_GET['id_country']}, newRefereeName, newRefereeBirth, newRefereeForm);' type='button' value='Добавить'>
		</form></center>";
	}
}

?>