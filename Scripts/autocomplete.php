<?php
require_once '../Models/TeamsModel.php';
require_once '../Models/ChampionshipsModel.php';

if ($_GET['q']) {
	$teamsModel = new TeamsModel();
	$championshipsModel = new ChampionshipsModel();
	foreach($teamsModel->getAllTeams() as $row) {
		$res = mb_strpos(mb_strtolower($row['name'],"UTF-8"), mb_strtolower($_GET['q'],"UTF-8"));
		if($res!==false&&$res==0) {
			$championshipName = $championshipsModel->getChampionshipNameById($teamsModel->getChampionshipIdByTeamId($row['id_team']));
			print $row['name']."|".$row['id_team']."|".$championshipName."\n";
		}
	}
}
?>