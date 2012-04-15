<?php
require_once '../Scripts/autoload.php';

class StadiumsAjax {
	/**
	 * 
	 * StadiumsModel()
	 */
	private $stadiumsModel;
	/**
	 * 
	 * Что будем делать(add)
	 */
	private $action;
	/**
	 * 
	 * id стадиона
	 */
	private $id_stadium;
	/**
	 * 
	 * id команды
	 */
	private $id_team;
	/**
	 * 
	 * Имя стадиона
	 */
	private $stadium_name;
	/**
	 * 
	 * Изображение стадиона
	 */	
	private $stadium_image;
	private $number;
	public function __construct($action = null, $id_stadium = null, $stadium_name = null,
								$stadium_image = null, $id_team = null, $number = null) {
		$this->stadiumsModel =  new StadiumsModel();
		$this->action = $action;
		
		if ($id_stadium != null) $this->id_stadium = $id_stadium;
		if ($stadium_name != null) $this->stadium_name = $stadium_name;
		if ($stadium_image != null) $this->stadium_image = $stadium_image;
		if ($id_team != null) $this->id_team = $id_team;
		if ($number != null) $this->number = $number;
		
		
		if ($action == "showImage") $this->getStadiumImage();
		if ($action == "addStadium") $this->addStadium();
		
	}
	/**
	 * Получаем изображение стадиона по id
	 */
	private function getStadiumImage() {
		echo json_encode(array("image"=>$this->stadiumsModel->getStadiumImageByStadiumId($this->id_stadium),
							"capacity"=>$this->stadiumsModel->getStadiumCapacityById($this->id_stadium)));
		//echo json_encode(array("name"=>"John","time"=>"2pm"));
	}
	/**
	 * Добавляем стадион
	 */
	private function addStadium() {
		if ($this->stadiumsModel->checkDuplicateStadium($this->stadium_name) == true) {
			echo "error";
		}
		else {
			var_dump($_FILES);
			if(is_uploaded_file($_FILES["stadiumImage".$this->number]["tmp_name"]))
			{
				echo "ololo1";
				// Если файл загружен успешно, перемещаем его
				// из временной директории в конечную
				move_uploaded_file($_FILES["stadiumImage".$this->number]["tmp_name"], "../Images/stadiums/".$_FILES["stadiumImage".$this->number]["name"]);
			}
		}
	}
}
for ($i = 0; $i <= $_POST['hid']; $i++) {
	if(is_uploaded_file($_FILES["stadiumImage".$i]["tmp_name"]))
		// Если файл загружен успешно, перемещаем его
		// из временной директории в конечную
		if (move_uploaded_file($_FILES["stadiumImage".$i]["tmp_name"], "../Images/stadiums/".$_FILES["stadiumImage".$i]["name"])) {
			$stadiumsModel = new StadiumsModel();
			
			$stadiumsModel->addStadium($_POST['stadiumName'.$i], $_POST['stadiumCapacity'.$i],
						$_FILES["stadiumImage".$i]["name"], $_POST['id_team']);
		}
}
	
{
	
}

//$stadiumsAjax = new StadiumsAjax($_POST['action'], $_POST['id_stadium'], $_POST['stadium_name'],
//									$_POST['stadium_image'], $_POST['id_team'], $_POST['number']);
?>