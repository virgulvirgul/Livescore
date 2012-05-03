<?php
require_once '../Scripts/autoload.php';

class RefereesAjax {
	/**
		Выбираем что будем делать (edit, delete)
	 */
	private $action;
	/**
		RefereesModel()
	 */
	private $refereesModel;
	/**
	 * 
	 * ID судьи
	 */
	private $id_referee;
	/**
	 * 
	 * Имя судьи
	 */
	private $referee_name;
	/**
		Дата рождения судьи (нужно при добавлении)
	 */
	private $referee_birth;
	/**
	 * 
	 * id страны в которой находится судья
	 */
	private $id_country;
	public function __construct($action = null, $id_referee = null, $referee_name = null,
								$referee_birth = null, $id_country = null) {
		$this->action = $action;
		$this->refereesModel = new RefereesModel();
		
		if ($id_referee != null) $this->id_referee = $id_referee;
		if ($referee_name != null) $this->referee_name = $referee_name;
		if ($referee_birth != null) $this->referee_birth = $referee_birth;
		if ($id_country != null) $this->id_country = $id_country;
		
        if ($this->action == "showResult" && $this->id_referee != null) $this->showReferee();
        if ($this->action == "edit") $this->editReferee();
        if ($this->action == "delete") $this->deleteReferee();
        if ($this->action == "addReferee") $this->addReferee();
        
	}
	/**
	 * Показываем имя судьи по его id
	 */
	private function showReferee() {
		echo $this->refereesModel->getRefereeNameById($this->id_referee);
	}
	/**
	 * Изменяем имя судьи
	 */
	private function editReferee() {
		if ($this->refereesModel->checkDuplicateReferee($this->referee_name) == true) {
			echo "error";
		}
		else $this->refereesModel->updateRefereeById($this->id_referee, $this->referee_name);
	}
	/**
	 * Добавляем судью
	 */
	private function addReferee() {
		if ($this->refereesModel->checkDuplicateReferee($this->referee_name) == true) {
			echo "error";
		}
		else {
			$this->refereesModel->addReferee($this->id_country, $this->referee_name, $this->referee_birth);
		}
	}
	/**
	 * Удаляем судью
	 */
	private function deleteReferee() {
		 echo $this->refereesModel->deleteRefereeById($this->id_referee);
	}
}

$refereesAjax = new RefereesAjax($_POST['action'], $_POST['id_referee'], $_POST['referee_name'],
									$_POST['referee_birth'], $_POST['id_country']);
?>