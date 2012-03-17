<?php
require_once '../Models/ChampionshipsModel.php';
require_once '../Models/TeamsModel.php';
$teamsModel = new TeamsModel();
$champModel = new ChampionshipsModel();
$id_championship = $_POST['id_championship'];
$name = $_POST['name'];
$id_country = $_POST['id_country'];
if (isset ($id_championship) && $_POST['action'] == "showResult") {
	echo $champModel->getChampionshipNameById($_POST['id_championship']);
}
else 
if (isset ($id_championship) && $_POST['action'] == "edit" && isset($name) && $name != "") {
	if ($champModel->checkDuplicateChampionship($name) == true) {
		echo "error";
	}
	else $champModel->updateChampionship($id_championship, $name);
}
else
if (isset ($id_championship) && $_POST['action'] == "delete") {
    $champModel->deleteChampionshipById($id_championship);
    $teamsModel->deleteTeamsByChampionshipId($id_championship);
}
else {
	if (isset($id_country) && isset($name) && $name != "" && $_POST['action'] == "addTeam") {
		if ($champModel->checkDuplicateChampionship($name) == true) {
			echo "error";
		}
		else
		{ 
			$champModel->addChampionship($name, $id_country);
			echo $champModel->getChampionshipIdByName($name);
		}
	}
}

?>