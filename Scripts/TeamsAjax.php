<?php
require_once '../Models/TeamsModel.php';
$teamsModel = new TeamsModel();

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

?>