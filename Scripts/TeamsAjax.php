<?php
require_once '../Models/TeamsModel.php';
require_once '../Models/ChampionshipsModel.php';
require_once '../Models/CountriesModel.php';
require_once '../Models/ContinentsModel.php';

$teamsModel = new TeamsModel();
$countriesModel = new CountriesModel();
$championsipModel = new ChampionshipsModel();
$continentsModel = new ContinentsModel();

$id_team = $_POST['id_team'];
$name = $_POST['name'];
$id_championship = $_POST['id_championship'];

if (isset ($id_team) && $_POST['action'] == "showResult") {
	echo $teamsModel->getTeamNameByTeamId($id_team);
}
else 
if (isset ($id_team) && $_POST['action'] == "edit" && isset($name) && $name != "") {
	if ($teamsModel->checkDuplicateTeam($name) == true) {
		echo "error";
	}
	else $teamsModel->updateTeamName($id_team, $name);
}
else
if (isset ($id_team) && $_POST['action'] == "delete") {
	$teamsModel->deleteTeamById($id_team);
}
else {
	if (isset($id_championship) && isset($name) && $name != "" && $_POST['action'] == "addTeam") {
		if ($teamsModel->checkDuplicateTeam($name) == true) {
			echo "error";
		}
		else
		{ 
			$teamsModel->addTeam($name, $id_championship);
			echo $teamsModel->getTeamIdByName($name);
		}
	}
}
if (isset($id_team) && $_POST['action'] == "moveTeam") {
    
    if ($_POST['champName'] != "Выберите чемпионат...") {
        $id_championship = $championsipModel->getChampionshipIdByName($_POST['champName']);
        $currentChampId = $_POST['currentChampId'];
        $id_country = $championsipModel->getIdCoutryByChampionshipId($id_championship);
        $id_continent = $countriesModel->getContinentIdByCoutryId($id_country);
        if ($continentsModel->getContinentNameByContinentId($id_continent) == "Other") {
            $teamsModel->moveTeamToAnotherInternationalChampionship($id_team, $currentChampId, $id_championship);
        }
        else {
          $teamsModel->moveTeamToAnotherChampionship($id_team, $id_championship);
        }
    }
    
    if ($_POST['europeChampName'] != "Выберите международный чемпионат..." && 
            $_POST['europeChampName'] != null && $_POST['europeChampName'] != "" && isset($_POST['europeChampName'])) {
        $id_championship_europe = $championsipModel->getChampionshipIdByName($_POST['europeChampName']);
        $teamsModel->addChampionshipIdByTeamId($id_team, $id_championship_europe);
    } 
}

?>