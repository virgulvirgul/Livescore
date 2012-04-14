<?php
require_once '../Scripts/autoload.php';

class StadiumsAjax {
	/**
	 * 
	 * StadiumsModel()
	 */
	private $stadiumsModel;
	private $action;
	private $id_stadium;
	public function __construct($action = null, $id_stadium = null) {
		$this->stadiumsModel =  new StadiumsModel();
		$this->action = $action;
		if ($id_stadium != null) $this->id_stadium = $id_stadium;
		if ($action == "showImage") $this->getStadiumImage();
	}
	/**
	 * Получаем изображение стадиона по id
	 */
	private function getStadiumImage() {
		echo json_encode(array("image"=>$this->stadiumsModel->getStadiumImageByStadiumId($this->id_stadium),
							"capacity"=>$this->stadiumsModel->getStadiumCapacityById($this->id_stadium)));
		//echo json_encode(array("name"=>"John","time"=>"2pm"));
	}
}

$stadiumsAjax = new StadiumsAjax($_POST['action'], $_POST['id_stadium']);
?>