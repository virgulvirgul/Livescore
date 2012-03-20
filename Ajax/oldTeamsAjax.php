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

/**
 * Выводим название команды по её id
 */
if (isset ($id_team) && $_POST['action'] == "showResult") {
    echo $teamsModel->getTeamNameByTeamId($id_team);
}
/**
 * Изменение названия команды
 */
else 
if (isset ($id_team) && $_POST['action'] == "edit" && isset($name) && $name != "") {
    // Если команда с таким же название существует выводим ошибку
    if ($teamsModel->checkDuplicateTeam($name) == true) {
        echo "error";
    }
    else $teamsModel->updateTeamName($id_team, $name);
}
// Удаление чемпионата.
else
if (isset ($id_team) && $_POST['action'] == "delete") {
    $teamsModel->deleteTeamById($id_team);
}
/**
 * Добавление новой команды
 */
else {
    if (isset($id_championship) && isset($name) && $name != "" && $_POST['action'] == "addTeam") {
        // Если команда с таким же название существует выводим ошибку
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
/**
 * Перемещение команды в другой чемпионат
 */
if (isset($id_team) && $_POST['action'] == "moveTeam") {
    // Если выбран чемпионат
    if ($_POST['champName'] != "Выберите чемпионат...") {
        
        $id_championship = $championsipModel->getChampionshipIdByName($_POST['champName']);
        $currentChampId = $_POST['currentChampId'];
        $id_country = $championsipModel->getIdCoutryByChampionshipId($id_championship);
        $id_continent = $countriesModel->getContinentIdByCoutryId($id_country);
        
        // Если находимся в международном чемпионате
        if ($continentsModel->getContinentNameByContinentId($id_continent) == "Other") {
            $teamsModel->moveTeamToAnotherInternationalChampionship($id_team, $currentChampId, $id_championship);
        }
        // Если находимся в обычном чемпионате
        else {
          $teamsModel->moveTeamToAnotherChampionship($id_team, $id_championship);
        }
    }
    // Если выбран международный чемпионат
    if ($_POST['europeChampName'] != "Выберите международный чемпионат..." && 
            $_POST['europeChampName'] != null && $_POST['europeChampName'] != "" && isset($_POST['europeChampName'])) {
        $id_championship_europe = $championsipModel->getChampionshipIdByName($_POST['europeChampName']);
        $teamsModel->addChampionshipIdByTeamId($id_team, $id_championship_europe);
    } 
}

?>