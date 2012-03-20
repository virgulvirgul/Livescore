<?php
require_once '../Models/TeamsModel.php';
require_once '../Models/ChampionshipsModel.php';
require_once '../Models/CountriesModel.php';
require_once '../Models/ContinentsModel.php';

/**
 * @param определяем что нужно делать (обновлять, удалять...) $action
 */
class TeamsAjax {
    private $teamsModel;
    private $championshipsModel;
    private $countriesModel;
    private $continentsModel;
    private $id_team;
    private $id_championship;
    private $team_name;
    private $action;
    
    private $championshipName;
    private $internationalChampionshipName;
    private $currentChampionshipId;
    
    public function __construct($action, $id_team = null, $id_championship = null, $team_name = null,
                                $championshipName = null, $internationalChampionshipName = null,
                                $currentChampionshipId = null) {
                                    
        $this->teamsModel = new TeamsModel();
        $this->championshipsModel = new ChampionshipsModel();
        $this->countriesModel = new CountriesModel();
        $this->continentsModel = new ContinentsModel();
        
        $this->action = $action;
        
        if ($id_team != null) $this->id_team = $id_team;
        if ($id_championship != null) $this->id_championship = $id_championship;
        if ($team_name != null) $this->team_name = $team_name;
        
        if ($championshipName != null) $this->championshipName = $championshipName;
        if ($internationalChampionshipName != null) $this->internationalChampionshipName = $internationalChampionshipName;
        if ($currentChampionshipId != null) $this->currentChampionshipId = $currentChampionshipId;

        if($this->action == "showResult" && $this->id_team != null) $this->showTeam();
        if($this->action == "edit" && $this->id_team != null) $this->editTeam();
        if($this->action == "addTeam" && $this->team_name != null) $this->addTeam();
        if($this->action == "moveTeam" && $this->id_team != null) $this->moveTeam();
    }
    /**
     * Получаем название команды по её id
     */
    private function showTeam() {
        echo $this->teamsModel->getTeamNameByTeamId($this->id_team);
    }
    
    /**
     * Изменение имени команды
     */
    private function editTeam() {
        // Если команда с таким же название существует выводим ошибку
        if ($this->teamsModel->checkDuplicateTeam($this->team_name) == true) {
            echo "error";
        }
        else $this->teamsModel->updateTeamName($this->id_team, $this->team_name);
    }
    /**
     * Удаление команды
     */
    private function deleteTeam() {
       echo $this->teamsModel->deleteTeamById($this->id_team);
    }
    /**
     * Добавление команды
     */
    private function addTeam() {
          // Если команда с таким же название существует выводим ошибку
        if ($this->teamsModel->checkDuplicateTeam($this->team_name) == true) {
            echo "error";
        }
        else
        { 
            $this->teamsModel->addTeam($this->team_name, $this->id_championship);
            echo $this->teamsModel->getTeamIdByName($this->team_name);
        }
    }
    /**
     * Перемещение команды в другой чемпионат
     */
    private function moveTeam() {
        
        if ($this->championshipName != "Выберите чемпионат...") {
        
        
        // Если находимся в международном чемпионате
            if ($this->getContinentName() == "Other") {
                $this->teamsModel->moveTeamToAnotherInternationalChampionship($this->id_team, 
                                                            $this->currentChampionshipId, $this->id_championship);
        }
        // Если находимся в обычном чемпионате
        else {
          $this->teamsModel->moveTeamToAnotherChampionship($this->id_team, $this->id_championship);
        }
    }
    // Если выбран международный чемпионат
    if ($this->internationalChampionshipName != "Выберите международный чемпионат..." && 
            $this->internationalChampionshipName != null && $this->internationalChampionshipName != "" 
            && isset($this->internationalChampionshipName)) {
                
        $id_championship_europe = $this->championshipsModel->getChampionshipIdByName($this->internationalChampionshipName);
        $this->teamsModel->addChampionshipIdByTeamId($this->id_team, $id_championship_europe);
    } 
            
    }
    /**
     * Получаем имя континента для того чтобы определить находимся ли мы в интернациональном чемпионате
     */
    private function getContinentName() {
    	$this->id_championship = $this->championshipsModel->getChampionshipIdByName($this->championshipName);
		$this->id_country = $this->championshipsModel->getIdCoutryByChampionshipId($this->id_championship);
		$this->id_continent = $this->countriesModel->getContinentIdByCountryId($this->id_country);
         
        return $this->continentsModel->getContinentNameByContinentId($this->id_continent);
    }
}

$teamsAjax = new TeamsAjax($_POST['action'], $_POST['id_team'], $_POST['id_championship'], $_POST['name'], 
                            $_POST['champName'], $_POST['europeChampName'], $_POST['currentChampId']);
?>