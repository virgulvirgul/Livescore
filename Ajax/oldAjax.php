<?php
require_once '../Models/ChampionshipsModel.php';
require_once '../Models/TeamsModel.php';
$teamsModel = new TeamsModel();
$champModel = new ChampionshipsModel();

$id_championship = $_POST['id_championship'];
$name = $_POST['name'];
$id_country = $_POST['id_country'];

/**
 * По id чемпионата показываем его имя
 */
if (isset ($id_championship) && $_POST['action'] == "showResult") {
    echo $champModel->getChampionshipNameById($_POST['id_championship']);
}
/**
 * Изменение названия чемпионата
 */
else 
if (isset ($id_championship) && $_POST['action'] == "edit" && isset($name) && $name != "") {
    // Если такой чемпионат существует выводим ошибку
    if ($champModel->checkDuplicateChampionship($name) == true) {
        echo "error";
    }
    else $champModel->updateChampionship($id_championship, $name);
}
/**
 * Удаление чемпионата
 */
else
if (isset ($id_championship) && $_POST['action'] == "delete") {
    // Удаление чемпионата
    $champModel->deleteChampionshipById($id_championship);
    // Удаление всех команд из данного чемпината
    $teamsModel->deleteTeamsByChampionshipId($id_championship);
}
/**
 * Добавление чемпионата
 */
else {
    if (isset($id_country) && isset($name) && $name != "" && $_POST['action'] == "addChamp") {
        // Если чемпионат с таким же имененм существует выводим ошибку
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