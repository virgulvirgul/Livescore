<?php
require_once '../Models/ChampionshipsModel.php';
require_once '../Models/TeamsModel.php';
class ChampionshipsAjax {
    private $action;
    private $teamsModel;
    private $championshipsModel;
    private $id_championship;
    private $id_country;
    private $name;
    public function __construct($action, $id_country = null, $id_championship = null, $name = null) {
        $this->action = $action;
        $this->teamsModel = new TeamsModel();
        $this->championshipsModel = new ChampionshipsModel();
        
        if ($id_championship != null) $this->id_championship = $id_championship;
        if ($id_country != null) $this->id_country = $id_country;
        if ($name != null) $this->name = $name;
        
        if ($this->action == "showResult" && $this->id_championship != null) $this->showChampionship();
        if ($this->action == "edit" && $this->id_championship != null) $this->editChampionship();
        if ($this->action == "delete" && $this->id_championship != null) $this->deleteChampionship();
        if ($this->action == "addChamp" && $this->id_country != null && $this->name != null) $this->addChampionship(); 
        
    }
    /**
     * Показываем имя чемпионата по его id
     */
    private function showChampionship() {
       echo $this->championshipsModel->getChampionshipNameById($this->id_championship);
    }
    /**
     * Изменяем имя чемпионата
     */
    private function editChampionship() {
        if ($this->championshipsModel->checkDuplicateChampionship($this->name) == true) {
            echo "error";
        }
        else $this->championshipsModel->updateChampionship($this->id_championship, $this->name);
    }
    /**
     * Удаляем чемпионат
     */
    private function deleteChampionship() {
        // Удаление чемпионата
        $this->championshipsModel->deleteChampionshipById($this->id_championship);
        // Удаление всех команд из данного чемпината
        $this->championshipsModel->deleteTeamsByChampionshipId($this->id_championship);
    }
    /**
     * Добавляем чемпионат
     */
    private function addChampionship() {
        if ($this->championshipsModel->checkDuplicateChampionship($this->name) == true) {
            echo "error";
        }
        else { 
            $this->championshipsModel->addChampionship($this->name, $this->id_country);
            echo $this->championshipsModel->getChampionshipIdByName($this->name);
        }
    }
}

$championshipAjax = new ChampionshipsAjax($_POST['action'], $_POST['id_country'], $_POST['id_championship'], $_POST['name']);

?>